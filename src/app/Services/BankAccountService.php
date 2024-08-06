<?php

namespace App\Services;

use App\Models\BankAccount;

class BankAccountService
{
    public function index()
    {
        return BankAccount::where('user_id', Auth('sanctum')->id())->get();
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
