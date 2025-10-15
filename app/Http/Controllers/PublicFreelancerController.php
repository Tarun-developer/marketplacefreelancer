<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicFreelancerController extends Controller
{
    public function index()
    {
        $freelancers = User::where('current_role', 'freelancer')
            ->with('services')
            ->paginate(12);

        return view('public.freelancers.index', compact('freelancers'));
    }

    public function show(User $user)
    {
        $user->load(['profile', 'reviews', 'services']);

        // Calculate ratings
        $averageRating = $user->reviews()->avg('rating') ?? 0;
        $totalReviews = $user->reviews()->count();

        // Get badges
        $badges = app(\App\Http\Controllers\ProfileController::class)->calculateBadges($user);

        return view('profile.show', compact('user', 'averageRating', 'totalReviews', 'badges'));
    }
}