<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntityController\StoreRequest;
use App\Http\Requests\EntityController\UpdateRequest;
use App\Services\EntityService;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth('sanctum')->user()->entity;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return (new EntityService())->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return (new EntityService())->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        return (new EntityService())->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return (new EntityService())->delete($id);
    }
}
