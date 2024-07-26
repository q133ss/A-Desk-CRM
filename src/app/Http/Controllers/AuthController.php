<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthController\LoginRequest;
use App\Http\Requests\AuthController\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        return (new AuthService())->register($request);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        return (new AuthService())->login($request);
    }
}
