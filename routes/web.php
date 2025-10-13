<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (using Laravel Breeze or similar)
require __DIR__.'/auth.php';

// Authenticated Dashboard Route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes
// Onboarding routes
Route::middleware('auth')->group(function () {
    Route::get('onboarding', [SettingsController::class, 'showOnboarding'])->name('onboarding');
    Route::post('onboarding/set-role', [SettingsController::class, 'setRole'])->name('onboarding.set-role');
    Route::post('switch-role', [SettingsController::class, 'switchRole'])->name('switch-role');
});

// Include role-based route files
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
require __DIR__.'/client.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/support.php';
