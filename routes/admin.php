<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDisputeController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminSubscriptionController;
use App\Http\Controllers\Admin\AdminSupportTicketController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

// Admin routes
Route::middleware(['auth', 'role:super_admin|admin|manager'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return app(\App\Http\Controllers\DashboardController::class)->adminDashboard();
    })->name('dashboard');

    // Users Management
    Route::resource('users', AdminUserController::class);

    // Categories Management
    Route::resource('categories', AdminCategoryController::class);

    // Products Management
    Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);

    // Services Management
    Route::resource('services', AdminServiceController::class);
    Route::post('services/{service}/approve', [AdminServiceController::class, 'approve'])->name('services.approve');
    Route::post('services/{service}/suspend', [AdminServiceController::class, 'suspend'])->name('services.suspend');

    // Jobs Management
    Route::resource('jobs', AdminJobController::class)->except(['create', 'store']);
    Route::post('jobs/{job}/close', [AdminJobController::class, 'close'])->name('jobs.close');

    // Orders Management
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::post('orders/{order}/refund', [AdminOrderController::class, 'refund'])->name('orders.refund');

    // Transactions Management
    Route::resource('transactions', AdminTransactionController::class)->only(['index', 'show']);
    Route::post('transactions/{transaction}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Disputes Management
    Route::resource('disputes', AdminDisputeController::class)->only(['index', 'show', 'edit', 'update']);
    Route::post('disputes/{dispute}/resolve', [AdminDisputeController::class, 'resolve'])->name('disputes.resolve');

    // Support Tickets Management
    Route::resource('tickets', AdminSupportTicketController::class);
    Route::post('tickets/{ticket}/assign', [AdminSupportTicketController::class, 'assign'])->name('tickets.assign');
    Route::post('tickets/{ticket}/close', [AdminSupportTicketController::class, 'close'])->name('tickets.close');
    Route::post('tickets/{ticket}/reply', [AdminSupportTicketController::class, 'reply'])->name('tickets.reply');

    // Reviews Management
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'show']);
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/flag', [AdminReviewController::class, 'flag'])->name('reviews.flag');
    Route::post('reviews/{review}/unflag', [AdminReviewController::class, 'unflag'])->name('reviews.unflag');

    // Subscriptions Management
    Route::resource('subscriptions', AdminSubscriptionController::class)->only(['index', 'show']);
    Route::post('subscriptions/{subscription}/cancel', [AdminSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::post('subscriptions/{subscription}/extend', [AdminSubscriptionController::class, 'extend'])->name('subscriptions.extend');
    Route::resource('subscription-plans', AdminSubscriptionController::class)->except(['show']);

    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('update');
        Route::post('/security', [App\Http\Controllers\Admin\AdminSettingsController::class, 'updateSecurity'])->name('security');
        Route::post('/notifications', [App\Http\Controllers\Admin\AdminSettingsController::class, 'updateNotifications'])->name('notifications');
        Route::post('/maintenance', [App\Http\Controllers\Admin\AdminSettingsController::class, 'updateMaintenance'])->name('maintenance');
        Route::post('/integrations', [App\Http\Controllers\Admin\AdminSettingsController::class, 'updateIntegrations'])->name('integrations');
        Route::post('/roles', [App\Http\Controllers\SettingsController::class, 'updateRoles'])->name('roles');
        Route::post('/clear-cache', [App\Http\Controllers\Admin\AdminSettingsController::class, 'clearCache'])->name('clear-cache');
        Route::post('/clear-view-cache', [App\Http\Controllers\Admin\AdminSettingsController::class, 'clearViewCache'])->name('clear-view-cache');
        Route::post('/clear-route-cache', [App\Http\Controllers\Admin\AdminSettingsController::class, 'clearRouteCache'])->name('clear-route-cache');
    });
});