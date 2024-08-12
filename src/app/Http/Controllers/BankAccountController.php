<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankAccountController\AddGroupRequest;
use App\Http\Requests\BankAccountController\StoreGroupRequest;
use App\Http\Requests\BankAccountController\StoreRequest;
use App\Services\BankAccountService;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new BankAccountService())->index();
    }

    public function getByEntity()
    {
        return (new BankAccountService())->getByEntity();
    }

    public function storeGroup(StoreGroupRequest $request)
    {
        return (new BankAccountService())->storeGroup($request->validated());
    }

    public function addGroup(AddGroupRequest $request)
    {
        return (new BankAccountService())->addGroup($request->validated());
    }

    public function getByGroup()
    {
        return (new BankAccountService())->getByGroup();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return (new BankAccountService())->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return (new BankAccountService())->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        return (new BankAccountService())->update($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return (new BankAccountService())->delete($id);
    }
}
