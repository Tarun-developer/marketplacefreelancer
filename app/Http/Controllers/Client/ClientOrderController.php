<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;

class ClientOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->with(['seller', 'orderable'])
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user owns this order
        if ($order->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order');
        }

        $order->load(['seller', 'orderable']);

        return view('client.orders.show', compact('order'));
    }

    public function payments()
    {
        $payments = Order::where('buyer_id', auth()->id())
            ->where('status', 'completed')
            ->with(['seller', 'orderable'])
            ->latest()
            ->paginate(15);

        return view('client.payments', compact('payments'));
    }
}
