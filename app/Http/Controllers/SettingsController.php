<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_description' => 'A comprehensive marketplace platform',
            'commission_rate' => 15,
            'enable_kyc' => true,
            'enable_2fa' => true,
            'maintenance_mode' => false,
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'enable_kyc' => 'boolean',
            'enable_2fa' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        // In a real app, save to database or config
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
