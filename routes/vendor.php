<?php

use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorProductController;
use Illuminate\Support\Facades\Route;

// Vendor routes
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return app(\App\Http\Controllers\DashboardController::class)->vendorDashboard(auth()->user());
    })->name('dashboard');

     // Products Management
     Route::resource('products', VendorProductController::class);
     Route::post('products/{product}/create-version', [VendorProductController::class, 'createVersion'])->name('products.create-version');

    // Orders Management
    Route::resource('orders', VendorOrderController::class)->only(['index', 'show']);

    // Analytics
    Route::get('analytics', [VendorProductController::class, 'analytics'])->name('analytics');

    // Earnings
    Route::get('earnings', [VendorOrderController::class, 'earnings'])->name('earnings');
});