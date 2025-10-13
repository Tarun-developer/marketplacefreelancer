<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_description' => 'A comprehensive marketplace platform',
            'site_email' => config('mail.from.address'),
            'contact_phone' => '+1-234-567-8900',
            'default_currency' => config('app.currency', 'USD'),
            'commission_rate' => 15.00,
            'timezone' => config('app.timezone', 'UTC'),
            'items_per_page' => 15,
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'site_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'default_currency' => 'required|in:USD,EUR,GBP,CAD',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'timezone' => 'required|string',
            'items_per_page' => 'required|integer|min:5|max:100',
        ]);

        // In a real app, save to database or config files
        // For demo, we'll just redirect with success
        return redirect()->route('admin.settings.index')->with('success', 'General settings updated successfully.');
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'password_min_length' => 'required|integer|min:6|max:20',
            'session_lifetime' => 'required|integer|min:15|max:1440',
            'require_email_verification' => 'boolean',
            'enable_two_factor' => 'boolean',
            'enable_captcha' => 'boolean',
            'enable_rate_limiting' => 'boolean',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Security settings updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'notification_email' => 'required|email',
            'notify_new_user' => 'boolean',
            'notify_new_order' => 'boolean',
            'notify_payment' => 'boolean',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Notification settings updated successfully.');
    }

    public function updateMaintenance(Request $request)
    {
        $request->validate([
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'required|string',
            'allowed_ips' => 'nullable|string',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Maintenance settings updated successfully.');
    }

    public function updateIntegrations(Request $request)
    {
        $request->validate([
            'stripe_public_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_secret' => 'nullable|string',
            'google_analytics_id' => 'nullable|string',
            'facebook_pixel_id' => 'nullable|string',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Integration settings updated successfully.');
    }

    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            return response()->json(['message' => 'Application cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to clear cache'], 500);
        }
    }

    public function clearViewCache(Request $request)
    {
        try {
            Artisan::call('view:clear');
            return response()->json(['message' => 'View cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to clear view cache'], 500);
        }
    }

    public function clearRouteCache(Request $request)
    {
        try {
            Artisan::call('route:clear');
            return response()->json(['message' => 'Route cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to clear route cache'], 500);
        }
    }

    public function showOnboarding()
    {
        // Check if user has roles
        if (auth()->user()->roles->count() > 0) {
            return redirect()->route('dashboard');
        }

        return view('auth.onboarding');
    }

    public function setRole(Request $request)
    {
        try {
             $request->validate([
                 'role' => 'required|in:client,freelancer,vendor,customer,multi',
             ]);

            $user = auth()->user();

            if ($request->role === 'multi') {
                // Assign multiple roles
                $user->assignRole(['client', 'freelancer', 'vendor']);
                $user->update(['current_role' => 'client']); // Default to client
                $redirect = route('dashboard'); // Go to common dashboard
            } else {
                // Assign single role (ADD to existing roles, don't replace)
                if (!$user->hasRole($request->role)) {
                    $user->assignRole($request->role);
                }
                $user->update(['current_role' => $request->role]);

                 switch ($request->role) {
                     case 'client':
                         $redirect = route('client.dashboard');
                         break;
                     case 'freelancer':
                         $redirect = route('freelancer.dashboard');
                         break;
                     case 'vendor':
                         $redirect = route('vendor.dashboard');
                         break;
                     case 'customer':
                         $redirect = route('dashboard');
                         break;
                     default:
                         $redirect = route('dashboard');
                 }
            }

            return response()->json([
                'success' => true,
                'redirect' => $redirect
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function switchRole(Request $request)
    {
        try {
            $request->validate([
                'role' => 'required|string',
            ]);

            $user = auth()->user();

            // Check if user has this role before switching
            if (!$user->hasRole($request->role)) {
                return response()->json([
                    'success' => false,
                    'error' => 'You do not have access to this role. Please purchase it first.'
                ], 403);
            }

            // Update current role (for dashboard view only, not assigning new role)
            $user->update(['current_role' => $request->role]);

             // Get redirect URL based on role
             switch ($request->role) {
                 case 'client':
                     $redirect = route('client.dashboard');
                     break;
                 case 'freelancer':
                     $redirect = route('freelancer.dashboard');
                     break;
                 case 'vendor':
                     $redirect = route('vendor.dashboard');
                     break;
                 case 'customer':
                     $redirect = route('dashboard');
                     break;
                 case 'admin':
                 case 'super_admin':
                     $redirect = route('admin.dashboard');
                     break;
                 case 'support':
                     $redirect = route('support.dashboard');
                     break;
                 default:
                     $redirect = route('dashboard');
             }

            return response()->json([
                'success' => true,
                'redirect' => $redirect,
                'message' => 'Switched to ' . $request->role . ' dashboard'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateRoles(Request $request)
    {
        $request->validate([
            'client_role_cost' => 'required|numeric|min:0',
            'freelancer_role_cost' => 'required|numeric|min:0',
            'vendor_role_cost' => 'required|numeric|min:0',
            'require_approval_for_roles' => 'boolean',
            'allow_free_roles' => 'boolean',
        ]);

        // Save to database
        Setting::set('client_role_cost', $request->client_role_cost, 'float', 'roles');
        Setting::set('freelancer_role_cost', $request->freelancer_role_cost, 'float', 'roles');
        Setting::set('vendor_role_cost', $request->vendor_role_cost, 'float', 'roles');
        Setting::set('require_approval_for_roles', $request->boolean('require_approval_for_roles'), 'boolean', 'roles');
        Setting::set('allow_free_roles', $request->boolean('allow_free_roles'), 'boolean', 'roles');

        // Clear cache
        Cache::forget('role_settings');

        // Clear config cache
        Artisan::call('config:clear');

        return redirect()->route('admin.settings.index')->with('success', 'Role settings updated successfully.');
    }

    public function checkout($role)
    {
        $user = auth()->user();

        // Check if user already has this role (one-time purchase)
        if ($user->hasRole($role)) {
            return redirect()->route('dashboard')->with('info', 'You already have this role. You can switch to it from the dashboard.');
        }

         $costs = [
             'client' => config('settings.client_role_cost', 0),
             'freelancer' => config('settings.freelancer_role_cost', 0),
             'vendor' => config('settings.vendor_role_cost', 0),
             'customer' => 0, // Customer role is free
         ];

        $cost = $costs[$role] ?? 0;

        if ($cost == 0) {
            // Free role - assign directly
            $user->assignRole($role);
            $user->update(['current_role' => $role]);

            // Redirect based on role
            switch ($role) {
                case 'customer':
                    return redirect()->route('dashboard')->with('success', 'Role assigned successfully!');
                default:
                    return redirect()->route($role . '.dashboard')->with('success', 'Role assigned successfully!');
            }
        }

        return view('checkout', compact('role', 'cost'));
    }

    public function processPayment(Request $request, $role)
    {
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal',
            'terms' => 'accepted',
        ]);

        $user = auth()->user();

        // Check if user already has this role (prevent duplicate purchase)
        if ($user->hasRole($role)) {
            return redirect()->route('dashboard')->with('info', 'You already have this role.');
        }

        // Simulate payment processing
        $cost = config('settings.' . $role . '_role_cost', 0);

        if ($cost > 0) {
            // Here you would process the actual payment
            // For demo, we'll just assign the role
            // TODO: Integrate with Stripe/PayPal
        }

        // Assign the role (one-time only)
        $user->assignRole($role);
        $user->update(['current_role' => $role]);

        // Redirect based on role
        switch ($role) {
            case 'customer':
                return redirect()->route('dashboard')->with('success', 'Role purchased and assigned successfully!');
            default:
                return redirect()->route($role . '.dashboard')->with('success', 'Role purchased and assigned successfully!');
        }
    }
}
