<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->hasRole('super_admin|admin')) {
            return view('dashboards.admin');
        } elseif ($user->hasRole('vendor')) {
            return view('dashboards.vendor');
        } elseif ($user->hasRole('freelancer')) {
            return view('dashboards.freelancer');
        } elseif ($user->hasRole('client')) {
            return view('dashboards.client');
        } elseif ($user->hasRole('support')) {
            return view('dashboards.support');
        }

        return redirect('/');
    }
}
