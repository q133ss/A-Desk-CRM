<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
 * Создаем АПИ
 * Фронт на VueJS будет хранится отдельно
 *
 ### ЗАДАЧИ
 * Настройки!
 *
 */

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('general/settings', [\App\Http\Controllers\ProfileController::class, 'general']);
    Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'profile']);
    Route::apiResource('users', \App\Http\Controllers\UserController::class);
    Route::apiResource('entity', \App\Http\Controllers\EntityController::class);

    Route::post('password/change', [\App\Http\Controllers\ProfileController::class, 'password']);
});

Route::post('/active/{user_id}/{hash}', [\App\Http\Controllers\UserController::class, 'activate'])->name('activate.invite');
