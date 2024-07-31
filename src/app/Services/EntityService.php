<?php

namespace App\Services;

use App\Http\Requests\EntityController\StoreRequest;
use App\Models\Entity;

class EntityService
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth('sanctum')->id();
        return Entity::create($data);
    }

    private function check($id)
    {
        $entity = Entity::findOrFail($id);
        if($entity->user_id != Auth('sanctum')->id()){
            abort(403, 'Ошибка');
        }
        return $entity;
    }

    public function show($id)
    {
        return $this->check($id);
    }

    public function update(StoreRequest $request, $id)
    {
        $entity =  $this->check($id);
        $update = $entity->update($request->validated());
        return $entity;
    }

    public function delete($id)
    {
        $this->check($id)->delete();
        return Response()->json([
            'message' => 'true'
        ]);
    }
}
