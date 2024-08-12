<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionController\StoreGroupRequest;
use App\Http\Requests\TransactionController\StoreRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return (new TransactionService())->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return (new TransactionService())->store($request->validated());
    }

    public function storeGroup(StoreGroupRequest $request)
    {
        return (new TransactionService())->storeGroup($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return (new TransactionService())->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        return (new TransactionService())->update($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return (new TransactionService())->delete($id);
    }
}
