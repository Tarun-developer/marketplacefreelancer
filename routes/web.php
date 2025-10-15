<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [PublicProductController::class, 'index'])->name('index');
    Route::get('/category/{category}', [PublicProductController::class, 'category'])->name('category');
    Route::get('/{product:slug}', [PublicProductController::class, 'show'])->name('show');
    Route::get('/{product:slug}/checkout', [PublicProductController::class, 'checkout'])->name('checkout');
    Route::post('/add-to-cart', [PublicProductController::class, 'addToCart'])->name('add-to-cart');
});

// Public Job Routes
Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicJobController::class, 'index'])->name('index');
    Route::get('/category/{category}', [App\Http\Controllers\PublicJobController::class, 'category'])->name('category');
    Route::get('/{job:slug}', [App\Http\Controllers\PublicJobController::class, 'show'])->name('show');
});

// Public Service Routes
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicServiceController::class, 'index'])->name('index');
    Route::get('/category/{category}', [App\Http\Controllers\PublicServiceController::class, 'category'])->name('category');
    Route::get('/{service:slug}', [App\Http\Controllers\PublicServiceController::class, 'show'])->name('show');
});

// Public Freelancer Routes
Route::prefix('freelancers')->name('freelancers.')->group(function () {
    Route::get('/', [App\Http\Controllers\PublicFreelancerController::class, 'index'])->name('index');
    Route::get('/{user}', [App\Http\Controllers\PublicFreelancerController::class, 'show'])->name('show');
});

// Public Pages
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

Route::get('/pricing', function () {
    return view('public.pricing');
})->name('pricing');

Route::get('/help', function () {
    return view('public.help');
})->name('help');

// Authentication routes (using Laravel Breeze or similar)
require __DIR__.'/auth.php';

// Authenticated Dashboard Route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/select-role', [DashboardController::class, 'selectRole'])->name('dashboard.select-role');
    Route::get('/downloads', [App\Http\Controllers\DownloadController::class, 'index'])->name('downloads');
    Route::get('/downloads/{order}', [App\Http\Controllers\DownloadController::class, 'download'])->name('downloads.download');

     // Chat System (All Roles)
     Route::prefix('chat')->name('chat.')->group(function () {
         Route::get('/', [ChatController::class, 'index'])->name('index');
         Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
         Route::post('/', [ChatController::class, 'store'])->name('store');
         Route::post('/create', [ChatController::class, 'createConversation'])->name('create');
         Route::get('/{conversation_id}/new-messages', [ChatController::class, 'getNewMessages'])->name('new-messages');
     });

     // Messaging System (All Roles)
     Route::prefix('messages')->name('messages.')->group(function () {
         Route::get('/', [App\Http\Controllers\MessagingController::class, 'index'])->name('index');
         Route::get('/create', [App\Http\Controllers\MessagingController::class, 'create'])->name('create');
         Route::post('/', [App\Http\Controllers\MessagingController::class, 'store'])->name('store');
         Route::get('/start/{user}', [App\Http\Controllers\MessagingController::class, 'startConversation'])->name('start');
         Route::get('/unread-count', [App\Http\Controllers\MessagingController::class, 'getUnreadCount'])->name('unread-count');
         Route::get('/{conversation}', [App\Http\Controllers\MessagingController::class, 'show'])->name('show');
         Route::post('/{conversation}/send', [App\Http\Controllers\MessagingController::class, 'sendMessage'])->name('send');
         Route::get('/{conversation}/new-messages', [App\Http\Controllers\MessagingController::class, 'getNewMessages'])->name('get-new');
         Route::delete('/{conversation}', [App\Http\Controllers\MessagingController::class, 'destroy'])->name('destroy');
     });
});

// Admin Routes
// Onboarding and Role Management routes
Route::middleware('auth')->group(function () {
    Route::get('onboarding', [SettingsController::class, 'showOnboarding'])->name('onboarding');
    Route::post('onboarding/set-role', [SettingsController::class, 'setRole'])->name('onboarding.set-role');
    Route::post('settings/switch-role', [SettingsController::class, 'switchRole'])->name('settings.switch-role');
    Route::get('checkout/{role}', [SettingsController::class, 'checkout'])->name('checkout');
    Route::post('checkout/{role}', [SettingsController::class, 'processPayment'])->name('checkout.process');

     // Onboarding routes
     Route::middleware(['auth'])->prefix('onboarding')->name('onboarding.')->group(function () {
         Route::get('/', [App\Http\Controllers\OnboardingController::class, 'index'])->name('index');
         Route::get('/step/{step}', [App\Http\Controllers\OnboardingController::class, 'showStep'])->name('step');
         Route::post('/process', [App\Http\Controllers\OnboardingController::class, 'processStep'])->name('process');
         Route::get('/skip/{step}', [App\Http\Controllers\OnboardingController::class, 'skipToStep'])->name('skip');
     });

     // Profile routes
     Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
     Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // User Settings routes
     Route::middleware(['auth'])->prefix('settings')->name('settings.')->group(function () {
         Route::get('/', [App\Http\Controllers\UserSettingsController::class, 'index'])->name('index');
         Route::post('/profile', [App\Http\Controllers\UserSettingsController::class, 'updateProfile'])->name('profile');
         Route::post('/password', [App\Http\Controllers\UserSettingsController::class, 'updatePassword'])->name('password');
         Route::post('/notifications', [App\Http\Controllers\UserSettingsController::class, 'updateNotifications'])->name('notifications');
         Route::post('/privacy', [App\Http\Controllers\UserSettingsController::class, 'updatePrivacy'])->name('privacy');
     });

     // Public Profile routes
     Route::get('users/{user}', [ProfileController::class, 'show'])->name('users.show');
     Route::get('users/{user}/reviews', [ProfileController::class, 'reviews'])->name('users.reviews');

     // Feature Purchase routes
     Route::prefix('checkout')->name('checkout.')->middleware(['auth'])->group(function () {
         Route::get('/feature/{feature}', [App\Http\Controllers\FeatureController::class, 'checkout'])->name('feature');
         Route::post('/feature/{feature}/purchase', [App\Http\Controllers\FeatureController::class, 'purchase'])->name('feature.purchase');
     });

     // SPM routes
     Route::prefix('spm')->name('spm.')->middleware(['auth'])->group(function () {
         Route::resource('/', App\Http\Controllers\SpmController::class)->parameters(['' => 'project']);
         Route::get('/subscriptions', [App\Http\Controllers\SpmSubscriptionController::class, 'index'])->name('subscriptions.index');
         Route::get('/subscriptions/checkout/{planId}', [App\Http\Controllers\SpmSubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
         Route::post('/subscriptions/purchase/{planId}', [App\Http\Controllers\SpmSubscriptionController::class, 'purchase'])->name('subscriptions.purchase');
         Route::post('/subscriptions/cancel', [App\Http\Controllers\SpmSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
         Route::post('/subscriptions/change-plan/{planId}', [App\Http\Controllers\SpmSubscriptionController::class, 'changePlan'])->name('subscriptions.change-plan');
     });
});

// Include role-based route files
require __DIR__.'/admin.php';
require __DIR__.'/vendor.php';
require __DIR__.'/client.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/support.php';
