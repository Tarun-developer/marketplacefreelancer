<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Modules\Products\Models\Product;
use App\Modules\Services\Models\Service;
use App\Modules\Jobs\Models\Job;
use App\Modules\Jobs\Models\Bid;
use App\Modules\Orders\Models\Order;
use App\Modules\Disputes\Models\Dispute;
use App\Modules\Support\Models\SupportTicket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('vendor')) {
            return $this->vendorDashboard($user);
        } elseif ($user->hasRole('freelancer')) {
            return $this->freelancerDashboard($user);
        } elseif ($user->hasRole('client')) {
            return $this->clientDashboard($user);
        } elseif ($user->hasRole('support')) {
            return $this->supportDashboard($user);
        }

        return redirect('/');
    }

    private function adminDashboard()
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

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_users'));
    }

    private function vendorDashboard($user)
    {
        $stats = [
            'total_products' => $user->products()->count(),
            'total_sales' => $user->orders()->where('status', 'completed')->sum('amount'),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'approved_products' => $user->products()->where('is_approved', true)->count(),
        ];

        $recent_orders = Order::where('seller_id', $user->id)
            ->with('buyer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.vendor', compact('stats', 'recent_orders'));
    }

    private function freelancerDashboard($user)
    {
        $stats = [
            'active_gigs' => $user->services()->where('status', 'active')->count(),
            'completed_jobs' => $user->orders()->where('status', 'completed')->count(),
            'total_earnings' => $user->orders()->where('status', 'completed')->sum('amount'),
            'pending_bids' => $user->bids()->where('status', 'pending')->count(),
        ];

        $active_jobs = Job::whereHas('bids', function($query) use ($user) {
            $query->where('user_id', $user->id)->where('status', 'accepted');
        })->with('client')->latest()->take(5)->get();

        return view('dashboards.freelancer', compact('stats', 'active_jobs'));
    }

    private function clientDashboard($user)
    {
        $stats = [
            'posted_jobs' => $user->jobs()->count(),
            'active_orders' => $user->orders()->whereIn('status', ['pending', 'processing'])->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('amount'),
        ];

        $recent_orders = Order::where('buyer_id', $user->id)
            ->with('seller')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.client', compact('stats', 'recent_orders'));
    }

    private function supportDashboard($user)
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
