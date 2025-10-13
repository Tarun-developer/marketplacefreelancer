<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (using Laravel Breeze or similar)
require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:SuperAdmin|Admin'])->group(function () {
    Route::resource('users', \App\Modules\Users\Controllers\UserController::class);
});

Route::middleware(['auth', 'role:SuperAdmin|Admin|Vendor|Freelancer|Client|Support'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
