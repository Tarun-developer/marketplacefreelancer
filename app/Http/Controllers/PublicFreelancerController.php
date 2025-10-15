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
        $user->load(['services', 'profile']);

        return view('public.freelancers.show', compact('user'));
    }
}