<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseActivation;
use App\Models\LicenseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    /**
     * API endpoint for license validation
     */
    public function validateLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string',
            'domain' => 'nullable|string',
            'ip' => 'nullable|ip',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Invalid request parameters.',
            ], 400);
        }

        $license = License::where('license_key', $request->license_key)->first();

        if (!$license) {
            LicenseLog::create([
                'license_id' => null,
                'action' => 'validation_failed',
                'message' => "Invalid license key: {$request->license_key}",
                'timestamp' => now(),
                'metadata' => ['ip' => $request->ip(), 'domain' => $request->domain],
            ]);

            return response()->json([
                'status' => 'invalid',
                'message' => 'Invalid license key.',
            ], 404);
        }

        if ($license->status !== 'active') {
            return response()->json([
                'status' => 'invalid',
                'message' => 'License is not active.',
            ], 403);
        }

        if ($license->expires_at && now()->gt($license->expires_at)) {
            return response()->json([
                'status' => 'expired',
                'message' => 'License has expired.',
            ], 403);
        }

        $ipAddress = $request->ip();
        $domain = $request->domain;

        // Check if domain is already activated
        $existingActivation = $license->activations()
            ->where('domain', $domain)
            ->where('status', 'active')
            ->first();

        if ($existingActivation) {
            // Update last validation
            $license->touch('last_validation');
            return response()->json([
                'status' => 'valid',
                'license_type' => $license->license_type,
                'expires_at' => $license->expires_at,
                'message' => 'License already activated for this domain.',
            ]);
        }

        // Check activation limit
        if ($license->activations_used >= $license->activation_limit) {
            return response()->json([
                'status' => 'limit_exceeded',
                'message' => 'Activation limit reached.',
            ], 403);
        }

        // Create new activation
        $activation = $license->activate($domain, $ipAddress);

        if ($activation) {
            return response()->json([
                'status' => 'valid',
                'license_type' => $license->license_type,
                'expires_at' => $license->expires_at,
                'message' => 'License activated successfully.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to activate license.',
        ], 500);
    }

    /**
     * Admin: List all licenses
     */
    public function index(Request $request)
    {
        $query = License::with(['product', 'buyer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('license_type')) {
            $query->where('license_type', $request->license_type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('buyer_id')) {
            $query->where('buyer_id', $request->buyer_id);
        }

        $licenses = $query->paginate(20);

        return view('admin.licenses.index', compact('licenses'));
    }

    /**
     * Admin: Show license details
     */
    public function show(License $license)
    {
        $license->load(['product', 'buyer', 'activations', 'logs']);
        return view('admin.licenses.show', compact('license'));
    }

    /**
     * Admin: Revoke license
     */
    public function revoke(License $license, Request $request)
    {
        $reason = $request->input('reason', 'Revoked by admin');

        $license->revoke($reason);

        return redirect()->back()->with('success', 'License revoked successfully.');
    }

    /**
     * Admin: Extend license
     */
    public function extend(License $license, Request $request)
    {
        $request->validate([
            'expires_at' => 'required|date|after:today',
        ]);

        $license->update([
            'expires_at' => $request->expires_at,
            'status' => 'active',
        ]);

        $license->logs()->create([
            'action' => 'extended',
            'message' => "License extended to {$request->expires_at}",
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', 'License extended successfully.');
    }

    /**
     * Admin: Change activation limit
     */
    public function changeLimit(License $license, Request $request)
    {
        $request->validate([
            'activation_limit' => 'required|integer|min:1',
        ]);

        $license->update(['activation_limit' => $request->activation_limit]);

        $license->logs()->create([
            'action' => 'limit_changed',
            'message' => "Activation limit changed to {$request->activation_limit}",
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('success', 'Activation limit updated successfully.');
    }

    /**
     * Admin: Generate manual license
     */
    public function generateManual(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'buyer_id' => 'required|exists:users,id',
            'license_type' => 'required|in:standard,professional,ultimate,custom',
            'activation_limit' => 'required|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $licenseKey = License::generateLicenseKey($request->product_id, $request->buyer_id);

        $license = License::create([
            'product_id' => $request->product_id,
            'buyer_id' => $request->buyer_id,
            'license_key' => $licenseKey,
            'license_type' => $request->license_type,
            'activation_limit' => $request->activation_limit,
            'activations_used' => 0,
            'status' => 'active',
            'issued_at' => now(),
            'expires_at' => $request->expires_at,
        ]);

        $license->logs()->create([
            'action' => 'manual_generated',
            'message' => 'License manually generated by admin',
            'timestamp' => now(),
        ]);

        return redirect()->route('admin.licenses.show', $license)->with('success', 'Manual license generated successfully.');
    }
}