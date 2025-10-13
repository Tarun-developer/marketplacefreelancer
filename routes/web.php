<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (using Laravel Breeze or similar)
require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:super_admin|admin'])->group(function () {
    Route::resource('users', \App\Modules\Users\Controllers\UserController::class);
    Route::resource('products', \App\Modules\Products\Controllers\ProductController::class);
    Route::resource('categories', \App\Modules\Products\Controllers\CategoryController::class);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/products', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'index'])->name('vendor.products.index');
    Route::get('/vendor/products/create', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'create'])->name('vendor.products.create');
    Route::post('/vendor/products', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'store'])->name('vendor.products.store');
    Route::get('/vendor/products/{product}/edit', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'edit'])->name('vendor.products.edit');
    Route::put('/vendor/products/{product}', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'update'])->name('vendor.products.update');
    Route::delete('/vendor/products/{product}', [\App\Modules\Products\Controllers\Vendor\VendorProductController::class, 'destroy'])->name('vendor.products.destroy');
});

Route::middleware(['auth', 'role:super_admin|admin|vendor|freelancer|client|support'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
