<?php

use App\Http\Controllers\Freelancer\FreelancerJobController;
use App\Http\Controllers\Freelancer\FreelancerProposalController;
use App\Http\Controllers\Freelancer\FreelancerServiceController;
use Illuminate\Support\Facades\Route;

// Freelancer routes
Route::middleware(['auth', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return app(\App\Http\Controllers\DashboardController::class)->freelancerDashboard(auth()->user());
    })->name('dashboard');

    // Jobs Management
    Route::resource('jobs', FreelancerJobController::class)->only(['index', 'show']);

    // Proposals Management
    Route::resource('proposals', FreelancerProposalController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

    // Services Management
    Route::resource('services', FreelancerServiceController::class);

    // Earnings
    Route::get('earnings', [FreelancerJobController::class, 'earnings'])->name('earnings');

    // Profile
    Route::get('profile', [FreelancerServiceController::class, 'profile'])->name('profile');
});