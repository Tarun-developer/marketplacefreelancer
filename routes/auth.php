<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
})->name('login.post')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

     $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
         'role' => 'client', // Default role
     ]);

     $user->assignRole('client');

     // Generate avatar if not provided
     $user->generateAvatar();

     auth()->login($user);

     // Redirect to onboarding for new users
     return redirect()->route('onboarding.index');
})->name('register.post')->middleware('guest');

Route::post('/logout', function () {
    auth()->logout();

    return redirect('/');
})->name('logout')->middleware('auth');
