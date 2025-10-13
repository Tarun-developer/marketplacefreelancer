<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\DisputeApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\WalletApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\SupportApiController;
use App\Http\Controllers\Api\SubscriptionApiController;

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

    // Disputes
    Route::apiResource('disputes', DisputeApiController::class);

    // Payments
    Route::get('payment-gateways', [PaymentApiController::class, 'gateways']);
    Route::post('payments/process', [PaymentApiController::class, 'processPayment']);
    Route::get('transactions', [PaymentApiController::class, 'transactions']);

    // Wallet
    Route::get('wallet/balance', [WalletApiController::class, 'balance']);
    Route::get('wallet/transactions', [WalletApiController::class, 'transactions']);
    Route::post('wallet/deposit', [WalletApiController::class, 'deposit']);
    Route::post('wallet/withdraw', [WalletApiController::class, 'withdraw']);

    // Reviews
    Route::apiResource('reviews', ReviewApiController::class);

    // Support
    Route::apiResource('support-tickets', SupportApiController::class);

    // Subscriptions
    Route::get('subscription-plans', [SubscriptionApiController::class, 'plans']);
    Route::post('subscribe', [SubscriptionApiController::class, 'subscribe']);
    Route::get('my-subscription', [SubscriptionApiController::class, 'mySubscription']);
    Route::post('cancel-subscription', [SubscriptionApiController::class, 'cancel']);
});