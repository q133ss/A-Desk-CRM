<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessDirectionController\StoreRequest;
use App\Models\BusinessDirection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessDirectionController extends Controller
{
    private function buildTree($directions)
    {
        // Проходим по каждому направлению и рекурсивно добавляем дочерние элементы
        foreach ($directions as $direction) {
            $children = BusinessDirection::where('user_id', Auth()->id())->where('parent_id', $direction->id)
                ->orderBy('position')
                ->get();

            if ($children->isNotEmpty()) {
                $direction->children = $this->buildTree($children);
            } else {
                $direction->children = [];
            }
        }

        return $directions;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directions = BusinessDirection::where('user_id', Auth('sanctum')->id())
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get();

        $result = $this->buildTree($directions);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth('sanctum')->id();

        // Найти максимальное значение position среди элементов с тем же parent_id
        $maxPosition = BusinessDirection::where('parent_id', $data['parent_id'] ?? null)
            ->where('user_id', $data['user_id'])
            ->max('position');

        // Установить значение position как maxPosition + 1
        $data['position'] = $maxPosition !== null ? $maxPosition + 1 : 0;

        $direction = BusinessDirection::create($data);
        return response()->json($direction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $direction = BusinessDirection::where('user_id', auth()->id())->findOrFail($id);
        $direction = $this->buildTree(collect([$direction]))->first();

        return response()->json($direction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $direction = BusinessDirection::where('user_id', Auth('sanctum')->id())->findOrFail($id);
        $direction->update($request->validated());

        return response()->json($direction);
    }

    private function deleteChildren($direction)
    {
        // Получаем всех дочерних элементов текущего направления
        $children = BusinessDirection::where('parent_id', $direction->id)
            ->where('user_id', auth('sanctum')->id())
            ->get();

        // Рекурсивно проходим по всем дочерним элементам и удаляем их
        foreach ($children as $child) {
            $this->deleteChildren($child); // Удаляем всех потомков дочернего элемента
            $child->delete(); // Удаляем сам дочерний элемент
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $direction = BusinessDirection::where('user_id', auth('sanctum')->id())->findOrFail($id);

        $this->deleteChildren($direction);
        $direction->delete();

        return response()->json([
            'message' => 'true'
        ]);
    }

    public function sort(Request $request)
    {
        $sortedItems = $request->input('items');

        DB::transaction(function () use ($sortedItems) {
            foreach ($sortedItems as $item) {
                BusinessDirection::where('user_id', Auth('sanctum')->id())->where('id', $item['id'])
                    ->update([
                        'parent_id' => $item['parent_id'],
                        'position' => $item['position'],
                    ]);
            }
        });

        return response()->json(['message' => 'Сортировка успешно обновлена.']);
    }
}
