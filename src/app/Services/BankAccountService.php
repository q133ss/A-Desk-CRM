<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\BankAccountGroup;
use App\Models\Entity;

class BankAccountService
{
    public function index()
    {
        return BankAccount::where('user_id', Auth('sanctum')->id())->get();
    }

    public function getByEntity()
    {
        $bankAccounts = BankAccount::where('entity_id', '!=', null)->where('user_id', Auth('sanctum')->id())->get();

        // Группировка по entity_id
        $grouped = $bankAccounts->groupBy('entity_id');

        // Преобразование результата
        $result = $grouped->mapWithKeys(function ($accounts, $entityId) {
            $entityName = Entity::find($entityId)->entity_name ?? '---';
            return [$entityName => $accounts];
        });

        return response()->json($result);
    }

    public function storeGroup(array $data)
    {
        $data['user_id'] = Auth('sanctum')->id();
        return BankAccountGroup::create($data);
    }

    public function addGroup(array $data)
    {
        $group = BankAccountGroup::findOrFail($data['group_id']);
        unset($data['group_id']);
        $update = $group->update($data);
        return $group;
    }

    public function getByGroup()
    {
        $bankAccounts = BankAccount::where('group_id', '!=', null)->where('user_id', Auth('sanctum')->id())->get();

        // Группировка по group_id
        $grouped = $bankAccounts->groupBy('group_id');

        // Преобразование результата
        $result = $grouped->mapWithKeys(function ($accounts, $groupId) {
            $entityName = BankAccountGroup::find($groupId)->name ?? '---';
            return [$entityName => $accounts];
        });

        return response()->json($result);
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth('sanctum')->id();
        return BankAccount::create($data);
    }

    private function check($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        if($bankAccount->user_id != Auth('sanctum')->id()){
            abort(403, 'Данный счет принадлежит не вам');
        }
        return $bankAccount;
    }

    public function show($id)
    {
        return $this->check($id);
    }

    public function update(array $data, $id)
    {
        $bankAccount = $this->check($id);
        $updated = $bankAccount->update($data);
        return $bankAccount;
    }

    public function delete($id)
    {
        $bankAccount = $this->check($id);
        $bankAccount->delete();
        return Response()->json([
            'message' => 'true'
        ]);
    }
}
