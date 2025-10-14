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

     // Wallet
     Route::get('wallet', [App\Http\Controllers\Client\ClientWalletController::class, 'index'])->name('wallet.index');
     Route::post('wallet/deposit', [App\Http\Controllers\Client\ClientWalletController::class, 'deposit'])->name('wallet.deposit');
     Route::post('wallet/withdraw', [App\Http\Controllers\Client\ClientWalletController::class, 'withdraw'])->name('wallet.withdraw');

     // Favorites
     Route::get('favorites', [ClientJobController::class, 'favorites'])->name('favorites');
     Route::post('services/{service}/favorite', [App\Http\Controllers\Client\ClientServiceController::class, 'toggleFavorite'])->name('services.favorite');
     Route::delete('services/{service}/favorite', [App\Http\Controllers\Client\ClientServiceController::class, 'removeFavorite'])->name('services.unfavorite');

      // Services
      Route::get('services', [App\Http\Controllers\Client\ClientServiceController::class, 'index'])->name('services.index');
      Route::get('services/{service}', [App\Http\Controllers\Client\ClientServiceController::class, 'show'])->name('services.show');
      Route::post('services/{service}/purchase', [App\Http\Controllers\Client\ClientServiceController::class, 'purchase'])->name('services.purchase');

      // Products
      Route::prefix('products')->name('products.')->group(function () {
          Route::get('/', [App\Http\Controllers\Client\ClientProductController::class, 'index'])->name('index');
          Route::get('/{product}', [App\Http\Controllers\Client\ClientProductController::class, 'show'])->name('show');
          Route::post('/{product}/purchase', [App\Http\Controllers\Client\ClientProductController::class, 'purchase'])->name('purchase');
      });

     // Profile
     Route::get('profile', [ClientJobController::class, 'profile'])->name('profile');

     // Plans
     Route::get('plans', [ClientJobController::class, 'plans'])->name('plans');
     Route::get('checkout-plan/{plan}', [ClientJobController::class, 'showPlanCheckout'])->name('show-plan-checkout');
     Route::post('checkout-plan/{plan}', [ClientJobController::class, 'processPlanCheckout'])->name('process-plan-checkout');
});