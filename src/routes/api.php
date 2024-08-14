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
    Route::apiResource('bank/account', \App\Http\Controllers\BankAccountController::class);
    Route::get('bank/account/get/by/entity', [\App\Http\Controllers\BankAccountController::class, 'getByEntity']);
    Route::post('bank/account/group', [\App\Http\Controllers\BankAccountController::class, 'storeGroup']);
    Route::post('bank/account/add/group', [\App\Http\Controllers\BankAccountController::class, 'addGroup']);
    Route::get('bank/account/get/by/group', [\App\Http\Controllers\BankAccountController::class, 'getByGroup']);
    # TODO
    // Добавить сортировку DragAndDrop
    // Добавить создание группы
    // Добавить список по группам в доходах и расходах
    Route::apiResource('transaction', \App\Http\Controllers\TransactionController::class);
    Route::post('/transaction/add/group', [\App\Http\Controllers\TransactionController::class, 'storeGroup']);

    // Группы счетов
    Route::apiResource('group', \App\Http\Controllers\GroupController::class);
    Route::apiResource('counterparty', \App\Http\Controllers\CounterpartyGroupController::class);
    Route::post('password/change', [\App\Http\Controllers\ProfileController::class, 'password']);
    Route::apiResource('businessdir', \App\Http\Controllers\BusinessDirectionController::class);
    Route::post('business-directions/sort', [\App\Http\Controllers\BusinessDirectionController::class, 'sort']);
    Route::apiResource('product', \App\Http\Controllers\ProductController::class);
    Route::get('billing-settings', [\App\Http\Controllers\BillingSettingsController::class, 'index']);
    Route::post('billing-settings/{entity_id}', [\App\Http\Controllers\BillingSettingsController::class, 'update']);
});

Route::post('/active/{user_id}/{hash}', [\App\Http\Controllers\UserController::class, 'activate'])->name('activate.invite');
