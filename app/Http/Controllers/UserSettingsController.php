<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'timezone' => 'nullable|string',
            'language' => 'nullable|string|in:en,es,fr,de',
        ]);

        $user->update($request->only(['name', 'email', 'timezone', 'language']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'new_message_notifications' => 'boolean',
            'order_notifications' => 'boolean',
            'review_notifications' => 'boolean',
        ]);

        // Update user notification preferences
        $user->update($request->only([
            'email_notifications',
            'sms_notifications',
            'push_notifications',
            'new_message_notifications',
            'order_notifications',
            'review_notifications',
        ]));

        return back()->with('success', 'Notification preferences updated successfully.');
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_visibility' => 'required|in:public,friends,private',
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
            'show_location' => 'boolean',
            'allow_messaging' => 'boolean',
        ]);

        // Update privacy settings
        $user->update($request->only([
            'profile_visibility',
            'show_email',
            'show_phone',
            'show_location',
            'allow_messaging',
        ]));

        return back()->with('success', 'Privacy settings updated successfully.');
    }
}