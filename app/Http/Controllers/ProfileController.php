<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['profile', 'reviews', 'services', 'products', 'jobs', 'ordersAsSeller', 'ordersAsBuyer']);

        // Calculate ratings
        $averageRating = $user->reviews()->avg('rating') ?? 0;
        $totalReviews = $user->reviews()->count();

        // Get badges based on achievements
        $badges = $this->calculateBadges($user);

        return view('profile.show', compact('user', 'averageRating', 'totalReviews', 'badges'));
    }

    public function reviews(User $user)
    {
        $reviews = $user->reviews()->with('reviewer')->paginate(10);

        return view('profile.reviews', compact('user', 'reviews'));
    }

    public function edit()
    {
        $user = auth()->user();
        $layout = $this->getLayoutForUser($user);

        return view('profile.edit', [
            'user' => $user,
            'layout' => $layout
        ]);
    }

    private function calculateBadges(User $user)
    {
        $badges = [];

        // Rating badges
        $averageRating = $user->reviews()->avg('rating') ?? 0;
        if ($averageRating >= 4.5) {
            $badges[] = ['name' => 'Top Rated', 'icon' => 'bi-star-fill', 'color' => 'warning'];
        } elseif ($averageRating >= 4.0) {
            $badges[] = ['name' => 'Highly Rated', 'icon' => 'bi-star-half', 'color' => 'info'];
        }

        // Project/Service badges
        if ($user->hasRole('freelancer') || $user->hasRole('vendor')) {
            $completedOrders = $user->ordersAsSeller()->where('status', 'completed')->count();
            if ($completedOrders >= 50) {
                $badges[] = ['name' => 'Expert Seller', 'icon' => 'bi-trophy', 'color' => 'success'];
            } elseif ($completedOrders >= 10) {
                $badges[] = ['name' => 'Rising Star', 'icon' => 'bi-graph-up', 'color' => 'primary'];
            }
        }

        // Client badges
        if ($user->hasRole('client')) {
            $completedJobs = $user->jobs()->where('status', 'completed')->count();
            if ($completedJobs >= 20) {
                $badges[] = ['name' => 'Top Client', 'icon' => 'bi-person-check', 'color' => 'danger'];
            }
        }

        // Verification badges
        if ($user->profile && $user->profile->is_verified) {
            $badges[] = ['name' => 'Verified', 'icon' => 'bi-patch-check', 'color' => 'success'];
        }

        return $badges;
    }

    private function getLayoutForUser($user)
    {
        if ($user->hasRole('client')) {
            return 'layouts.client';
        } elseif ($user->hasRole('freelancer')) {
            return 'layouts.freelancer';
        } elseif ($user->hasRole('vendor')) {
            return 'layouts.vendor';
        } elseif ($user->hasRole(['admin', 'super_admin', 'manager'])) {
            return 'layouts.admin';
        } else {
            return 'layouts.app';
        }
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = auth()->user();

        auth()->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
