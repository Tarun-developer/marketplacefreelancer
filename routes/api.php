<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ChatApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::apiResource('users', UserApiController::class);
    Route::get('users/{user}/profile', [UserApiController::class, 'profile']);
    Route::put('users/profile', [UserApiController::class, 'updateProfile']);

    // Products
    Route::apiResource('products', ProductApiController::class);
    Route::get('categories', [ProductApiController::class, 'categories']);

    // Services
    Route::apiResource('services', ServiceApiController::class);

    // Jobs
    Route::apiResource('jobs', JobApiController::class);
    Route::get('jobs/{job}/bids', [JobApiController::class, 'bids']);
    Route::post('jobs/{job}/bid', [JobApiController::class, 'placeBid']);

    // Orders
    Route::apiResource('orders', OrderApiController::class);

    // Chat
    Route::get('conversations', [ChatApiController::class, 'conversations']);
    Route::get('conversations/{conversation}', [ChatApiController::class, 'conversation']);
    Route::post('conversations/{conversation}/message', [ChatApiController::class, 'sendMessage']);
    Route::post('conversations/start', [ChatApiController::class, 'startConversation']);
});