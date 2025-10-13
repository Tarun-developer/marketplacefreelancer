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
}
