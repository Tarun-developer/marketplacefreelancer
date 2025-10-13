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
Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users Management
    Route::resource('users', \App\Modules\Users\Controllers\UserController::class)->except(['show']);

    // Products Management
    Route::resource('products', \App\Modules\Products\Controllers\ProductController::class);
    Route::post('products/{product}/approve', [\App\Modules\Products\Controllers\ProductController::class, 'approve'])->name('products.approve');
    Route::post('products/{product}/feature', [\App\Modules\Products\Controllers\ProductController::class, 'feature'])->name('products.feature');

     // Categories Management
     Route::resource('categories', \App\Modules\Products\Controllers\CategoryController::class);
     Route::get('categories/{category}/subcategories', [\App\Modules\Products\Controllers\ProductController::class, 'getSubcategories'])->name('categories.subcategories');

    // Services Management
    Route::resource('services', \App\Http\Controllers\Admin\AdminServiceController::class)->except(['create', 'store']);
    Route::post('services/{service}/approve', [\App\Http\Controllers\Admin\AdminServiceController::class, 'approve'])->name('services.approve');
    Route::post('services/{service}/suspend', [\App\Http\Controllers\Admin\AdminServiceController::class, 'suspend'])->name('services.suspend');

    // Jobs Management
    Route::resource('jobs', \App\Http\Controllers\Admin\AdminJobController::class)->except(['create', 'store']);
    Route::post('jobs/{job}/close', [\App\Http\Controllers\Admin\AdminJobController::class, 'close'])->name('jobs.close');

    // Orders Management
     Route::resource('orders', \App\Http\Controllers\Admin\AdminOrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::post('orders/{order}/refund', [\App\Http\Controllers\Admin\AdminOrderController::class, 'refund'])->name('orders.refund');

    // Transactions Management
    Route::resource('transactions', \App\Http\Controllers\Admin\AdminTransactionController::class)->only(['index', 'show']);
    Route::post('transactions/{transaction}/approve', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('transactions/{transaction}/reject', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Disputes Management
    Route::resource('disputes', \App\Http\Controllers\Admin\AdminDisputeController::class)->only(['index', 'show', 'update']);
    Route::post('disputes/{dispute}/resolve', [\App\Http\Controllers\Admin\AdminDisputeController::class, 'resolve'])->name('disputes.resolve');

    // Support Tickets Management
    Route::resource('tickets', \App\Http\Controllers\Admin\AdminSupportTicketController::class)->only(['index', 'show', 'update']);
    Route::post('tickets/{ticket}/assign', [\App\Http\Controllers\Admin\AdminSupportTicketController::class, 'assign'])->name('tickets.assign');
    Route::post('tickets/{ticket}/close', [\App\Http\Controllers\Admin\AdminSupportTicketController::class, 'close'])->name('tickets.close');
    Route::post('tickets/{ticket}/reply', [\App\Http\Controllers\Admin\AdminSupportTicketController::class, 'reply'])->name('tickets.reply');

    // Reviews Management
    Route::resource('reviews', \App\Http\Controllers\Admin\AdminReviewController::class)->only(['index', 'show', 'destroy']);
    Route::post('reviews/{review}/approve', [\App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/flag', [\App\Http\Controllers\Admin\AdminReviewController::class, 'flag'])->name('reviews.flag');
    Route::post('reviews/{review}/unflag', [\App\Http\Controllers\Admin\AdminReviewController::class, 'unflag'])->name('reviews.unflag');

    // Subscriptions Management
    Route::get('subscriptions', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('subscriptions/{subscription}', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('subscriptions/{subscription}/cancel', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::post('subscriptions/{subscription}/extend', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'extend'])->name('subscriptions.extend');

    // Subscription Plans Management
    Route::get('subscription-plans', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'plans'])->name('subscriptions.plans');
    Route::get('subscription-plans/create', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'createPlan'])->name('subscriptions.plans.create');
    Route::post('subscription-plans', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'storePlan'])->name('subscriptions.plans.store');
    Route::get('subscription-plans/{plan}/edit', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'editPlan'])->name('subscriptions.plans.edit');
    Route::put('subscription-plans/{plan}', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'updatePlan'])->name('subscriptions.plans.update');
    Route::delete('subscription-plans/{plan}', [\App\Http\Controllers\Admin\AdminSubscriptionController::class, 'destroyPlan'])->name('subscriptions.plans.destroy');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

// Vendor Routes
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::resource('products', \App\Modules\Products\Controllers\Vendor\VendorProductController::class);
    Route::resource('orders', \App\Http\Controllers\Vendor\VendorOrderController::class)->only(['index', 'show']);
});

// Freelancer Routes
Route::middleware(['auth', 'role:freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
    Route::resource('jobs', \App\Http\Controllers\Freelancer\FreelancerJobController::class)->only(['index', 'show']);
    Route::resource('proposals', \App\Http\Controllers\Freelancer\FreelancerProposalController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('services', \App\Http\Controllers\Freelancer\FreelancerServiceController::class);
});

// Client Routes
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::resource('jobs', \App\Http\Controllers\Client\ClientJobController::class);
    Route::resource('orders', \App\Http\Controllers\Client\ClientOrderController::class)->only(['index', 'show']);
});

// Support Routes
Route::middleware(['auth', 'role:support'])->prefix('support')->name('support.')->group(function () {
    Route::resource('tickets', \App\Http\Controllers\Support\SupportTicketController::class);
});
