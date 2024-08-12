<?php

namespace App\Services;

use App\Models\TransactionCategory;
use App\Models\TransactionItem;

class TransactionService
{
    public function index($request)
    {
        return TransactionCategory::where('user_id', Auth('sanctum')->id())
            ->where('is_archive', 0)
            ->where('category', $request->category)
            ->orderBy('position', 'asc')
            ->get()
            ->load('transations');
    }

    private function getMaxPosition($user_id)
    {
        $itemPos = TransactionItem::where('user_id', $user_id)->max('position');
        $groupPos = TransactionCategory::where('user_id', $user_id)->max('position');

        $itemPos = $itemPos !== null ? $itemPos : 0;
        $groupPos = $groupPos !== null ? $groupPos : 0;

        return max($itemPos, $groupPos) + 1;
    }

    public function store(array $data)
    {
        $user_id = Auth('sanctum')->id();
        $data['user_id'] = $user_id;

        $pos = $this->getMaxPosition($user_id);

        $data['position'] = $pos;

        return TransactionItem::create($data);
    }

    public function storeGroup(array $data)
    {
        $user_id = Auth('sanctum')->id();

        $data['user_id'] = $user_id;
        $pos = $this->getMaxPosition($user_id);

        $data['position'] = $pos;

        return TransactionCategory::create($data);
    }

    private function check($id)
    {
        $item = TransactionItem::findOrFail($id);
        if($item->user_id != Auth('sanctum')->id())
        {
            abort(403, 'Ошибка, попробуйте еще раз');
        }
        return $item;
    }

    public function show($id)
    {
        return $this->check($id);
    }

    public function update($id, array $data)
    {
        $item = $this->check($id);
        $update = $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->check($id);
        $item->delete();
        return Response()->json([
            'message' => 'true'
        ]);
    }
}
