<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'default_currency' => 'required|string|in:USD,EUR,GBP',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        // Update config or save to database/settings table
        // For simplicity, assuming updating config files or a settings model
        // Here, you might want to save to a settings table or update .env

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
