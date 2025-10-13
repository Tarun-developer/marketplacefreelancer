<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Authentication routes (using Laravel Breeze or similar)
require __DIR__.'/auth.php';

// Authenticated Dashboard Route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/select-role', [DashboardController::class, 'selectRole'])->name('dashboard.select-role');
});

// Admin Routes
// Onboarding and Role Management routes
Route::middleware('auth')->group(function () {
    Route::get('onboarding', [SettingsController::class, 'showOnboarding'])->name('onboarding');
    Route::post('onboarding/set-role', [SettingsController::class, 'setRole'])->name('onboarding.set-role');
    Route::post('settings/switch-role', [SettingsController::class, 'switchRole'])->name('settings.switch-role');
    Route::get('checkout/{role}', [SettingsController::class, 'checkout'])->name('checkout');
    Route::post('checkout/{role}', [SettingsController::class, 'processPayment'])->name('checkout.process');

    // Profile routes
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include role-based route files
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
require __DIR__.'/client.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/support.php';
