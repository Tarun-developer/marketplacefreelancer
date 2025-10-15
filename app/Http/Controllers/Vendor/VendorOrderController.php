<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;

class VendorOrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereHas('product', function ($query) {
            $query->where('user_id', auth()->id());
        })->paginate(10);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure the order belongs to the vendor
        if ($order->product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('vendor.orders.show', compact('order'));
    }

    public function earnings()
    {
        $user = auth()->user();

        // Get all product IDs for this vendor
        $productIds = $user->products()->pluck('id');

        // Calculate total revenue from completed orders
        $totalRevenue = Order::whereIn('orderable_id', $productIds)
            ->where('orderable_type', \App\Modules\Products\Models\Product::class)
            ->where('status', 'completed')
            ->sum('amount');

        // Calculate commission (assuming 15% platform fee)
        $commissionRate = 15;
        $netEarnings = $totalRevenue * (1 - $commissionRate / 100);

        // Calculate monthly revenue
        $monthlyRevenue = Order::whereIn('orderable_id', $productIds)
            ->where('orderable_type', \App\Modules\Products\Models\Product::class)
            ->where('status', 'completed')
            ->whereYear('completed_at', now()->year)
            ->whereMonth('completed_at', now()->month)
            ->sum('amount');

        // Count total sales
        $totalSales = Order::whereIn('orderable_id', $productIds)
            ->where('orderable_type', \App\Modules\Products\Models\Product::class)
            ->where('status', 'completed')
            ->count();

        // Get top products by revenue
        $topProducts = \App\Modules\Products\Models\Product::where('user_id', $user->id)
            ->withCount(['orders as orders_count' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['orders as total_revenue' => function ($query) {
                $query->where('status', 'completed');
            }], 'amount')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::whereIn('orderable_id', $productIds)
            ->where('orderable_type', \App\Modules\Products\Models\Product::class)
            ->with(['buyer', 'orderable'])
            ->latest()
            ->take(10)
            ->get();

        return view('vendor.earnings', compact(
            'totalRevenue',
            'netEarnings',
            'commissionRate',
            'monthlyRevenue',
            'totalSales',
            'topProducts',
            'recentOrders'
        ));
    }
}
