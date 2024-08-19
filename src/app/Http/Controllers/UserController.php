<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserController\StoreRequest;
use App\Http\Requests\UserController\UpdateRequest;
use App\Mail\WellcomeUserMail;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Auth('sanctum')->user()->users()->withFilter($request)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return (new UserService())->store($request);
    }

    public function activate($user_id, $hash)
    {
        return (new UserService())->activate($user_id, $hash);
    }

    public function permissions()
    {
        return Permission::get();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return (new UserService())->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        return (new UserService())->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return (new UserService())->delete($id);
    }
}
