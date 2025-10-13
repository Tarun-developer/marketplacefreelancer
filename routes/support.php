<?php

use App\Http\Controllers\Support\SupportTicketController;
use Illuminate\Support\Facades\Route;

// Support routes
Route::middleware(['auth', 'role:support'])->prefix('support')->name('support.')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return app(\App\Http\Controllers\DashboardController::class)->supportDashboard(auth()->user());
    })->name('dashboard');

    // Tickets Management
    Route::resource('tickets', SupportTicketController::class);
    Route::post('tickets/{ticket}/assign', [SupportTicketController::class, 'assign'])->name('tickets.assign');
    Route::post('tickets/{ticket}/close', [SupportTicketController::class, 'close'])->name('tickets.close');
    Route::post('tickets/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('tickets.reply');

    // Disputes
    Route::resource('disputes', \App\Http\Controllers\Support\SupportDisputeController::class)->only(['index', 'show']);
});