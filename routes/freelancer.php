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
     Route::post('jobs/{job}/bid', [FreelancerJobController::class, 'storeBid'])->name('jobs.storeBid');

    // Proposals Management
    Route::resource('proposals', FreelancerProposalController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

    // Services Management
    Route::resource('services', FreelancerServiceController::class);

    // Earnings
    Route::get('earnings', [FreelancerJobController::class, 'earnings'])->name('earnings');

     // Profile
     Route::get('profile', [FreelancerServiceController::class, 'profile'])->name('profile');

     // Buy Extra Bids
     Route::get('buy-bids', [FreelancerJobController::class, 'buyBids'])->name('buy-bids');
     Route::post('buy-bids', [FreelancerJobController::class, 'purchaseBids'])->name('purchase-bids');
     Route::get('checkout-bids/{pack}', [FreelancerJobController::class, 'showBidCheckout'])->name('show-bid-checkout');
     Route::post('checkout-bids/{pack}', [FreelancerJobController::class, 'processBidCheckout'])->name('process-bid-checkout');

     // Freelancer Plans
     Route::get('plans', [FreelancerJobController::class, 'plans'])->name('plans');
     Route::get('checkout-plan/{plan}', [FreelancerJobController::class, 'showPlanCheckout'])->name('show-plan-checkout');
     Route::post('checkout-plan/{plan}', [FreelancerJobController::class, 'processPlanCheckout'])->name('process-plan-checkout');

     // Service Orders
     Route::get('service-orders', [FreelancerJobController::class, 'serviceOrders'])->name('service-orders');
     Route::get('service-orders/{order}', [FreelancerJobController::class, 'showServiceOrder'])->name('service-orders.show');

     // SPM Projects
     Route::get('projects', [App\Http\Controllers\Freelancer\FreelancerSpmController::class, 'index'])->name('projects.index');
     Route::get('projects/{project}', [App\Http\Controllers\Freelancer\FreelancerSpmController::class, 'show'])->name('projects.show');
});