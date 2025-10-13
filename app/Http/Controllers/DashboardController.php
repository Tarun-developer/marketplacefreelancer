<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasRole('SuperAdmin|Admin')) {
            return view('dashboards.admin');
        } elseif ($user->hasRole('Vendor')) {
            return view('dashboards.vendor');
        } elseif ($user->hasRole('Freelancer')) {
            return view('dashboards.freelancer');
        } elseif ($user->hasRole('Client')) {
            return view('dashboards.client');
        } elseif ($user->hasRole('Support')) {
            return view('dashboards.support');
        }

        return redirect('/');
    }
}
