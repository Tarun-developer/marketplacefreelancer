<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Disputes\Models\Dispute;
use App\Modules\Jobs\Models\Bid;
use App\Modules\Jobs\Models\Job;
use App\Modules\Orders\Models\Order;
use App\Modules\Products\Models\Product;
use App\Modules\Services\Models\Service;
use App\Modules\Support\Models\SupportTicket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // If user has no roles, redirect to onboarding
        if ($user->roles->count() === 0) {
            return redirect()->route('onboarding');
        }

        // Always show common dashboard for role selection
        return $this->commonDashboard($user);
    }

    private function redirectToRoleDashboard($user)
    {
        $currentRole = $user->current_role;

        if ($currentRole === 'admin' || $currentRole === 'super_admin') {
            return $this->adminDashboard();
        } elseif ($currentRole === 'vendor') {
            return $this->vendorDashboard($user);
        } elseif ($currentRole === 'freelancer') {
            return $this->freelancerDashboard($user);
        } elseif ($currentRole === 'client') {
            return $this->clientDashboard($user);
        } elseif ($currentRole === 'support') {
            return $this->supportDashboard($user);
        }

        return $this->commonDashboard($user);
    }

    private function commonDashboard($user)
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_services' => \App\Modules\Services\Models\Service::count(),
            'total_products' => \App\Modules\Products\Models\Product::count(),
            'total_jobs' => \App\Modules\Jobs\Models\Job::count(),
        ];

        return view('dashboards.common', compact('stats'));
    }

    public function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('amount'),
            'revenue_this_month' => Order::where('status', 'completed')
                ->whereMonth('created_at', now()->month)->sum('amount'),
            'active_orders' => Order::whereIn('status', ['pending', 'processing'])->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'pending_disputes' => Dispute::where('status', 'pending')->count(),
            'resolved_disputes' => Dispute::where('status', 'resolved')->count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('is_approved', false)->count(),
            'active_services' => Service::where('status', 'active')->count(),
            'total_services' => Service::count(),
            'open_jobs' => Job::where('status', 'open')->count(),
            'total_bids' => Bid::count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'total_tickets' => SupportTicket::count(),
            'storage_used' => '12.5 GB',
        ];

        $recent_orders = Order::with(['buyer', 'seller'])
            ->latest()
            ->take(5)
            ->get();

        $recent_users = User::latest()
            ->take(5)
            ->get();

        return view('dashboards.admin', compact('stats', 'recent_orders', 'recent_users'));
    }

    public function vendorDashboard($user)
    {
        $stats = [
            'total_products' => $user->products()->count(),
            'total_sales' => $user->ordersAsSeller()->where('status', 'completed')->sum('amount'),
            'pending_orders' => $user->ordersAsSeller()->where('status', 'pending')->count(),
            'approved_products' => $user->products()->where('is_approved', true)->count(),
        ];

        $recent_orders = $user->ordersAsSeller()
            ->with('buyer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.vendor', compact('stats', 'recent_orders'));
    }

    public function freelancerDashboard($user)
    {
        $stats = [
            'active_gigs' => $user->services()->where('status', 'active')->count(),
            'completed_jobs' => $user->ordersAsSeller()->where('status', 'completed')->count(),
            'total_earnings' => $user->ordersAsSeller()->where('status', 'completed')->sum('amount'),
            'pending_bids' => $user->bids()->where('status', 'pending')->count(),
        ];

        $active_jobs = Job::whereHas('bids', function ($query) use ($user) {
            $query->where('freelancer_id', $user->id)->where('status', 'accepted');
        })->with('client')->latest()->take(5)->get();

        return view('dashboards.freelancer', compact('stats', 'active_jobs'));
    }

    public function clientDashboard($user)
    {
        $stats = [
            'posted_jobs' => $user->jobs()->count(),
            'active_orders' => $user->ordersAsBuyer()->whereIn('status', ['pending', 'processing'])->count(),
            'completed_orders' => $user->ordersAsBuyer()->where('status', 'completed')->count(),
            'total_spent' => $user->ordersAsBuyer()->where('status', 'completed')->sum('amount'),
        ];

        $recent_orders = $user->ordersAsBuyer()
            ->with('seller')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.client', compact('stats', 'recent_orders'));
    }

    public function supportDashboard($user)
    {
        $stats = [
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'my_tickets' => SupportTicket::where('assigned_to', $user->id)->count(),
            'resolved_today' => SupportTicket::where('status', 'resolved')
                ->whereDate('updated_at', today())->count(),
            'pending_disputes' => Dispute::where('status', 'pending')->count(),
        ];

        $recent_tickets = SupportTicket::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboards.support', compact('stats', 'recent_tickets'));
    }
}
