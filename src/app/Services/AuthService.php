<?php

namespace App\Services;

use App\Http\Requests\AuthController\LoginRequest;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Models\Role;
use App\Models\Timezone;
use App\Models\User;

class AuthService
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $data['role_id'] = Role::where('slug', 'owner')->pluck('id')->first();
        $data['timezone_id'] = Timezone::where('name', '(GMT +03:00) Europe/Moscow')->pluck('id')->first();

        $user = User::create($data);
        $token = $user->createToken('web');

        return Response()->json(['user' => $user, 'token' => $token->plainTextToken]);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('web');

        return Response()->json(['user' => $user, 'token' => $token->plainTextToken]);
    }
}
