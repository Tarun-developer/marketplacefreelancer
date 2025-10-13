<?php

use App\Http\Controllers\Client\ClientJobController;
use App\Http\Controllers\Client\ClientOrderController;
use Illuminate\Support\Facades\Route;

// Client routes
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return app(\App\Http\Controllers\DashboardController::class)->clientDashboard(auth()->user());
    })->name('dashboard');

    // Jobs Management
    Route::resource('jobs', ClientJobController::class);
    Route::get('jobs/{job}/messages', [ClientJobController::class, 'messages'])->name('jobs.messages');
    Route::post('jobs/{job}/messages', [ClientJobController::class, 'sendMessage'])->name('jobs.sendMessage');

    // Orders Management
    Route::resource('orders', ClientOrderController::class)->only(['index', 'show']);

    // Payments
    Route::get('payments', [ClientOrderController::class, 'payments'])->name('payments');

    // Favorites
    Route::get('favorites', [ClientJobController::class, 'favorites'])->name('favorites');
});