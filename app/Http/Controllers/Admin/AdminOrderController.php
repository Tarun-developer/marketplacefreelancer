<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['buyer', 'seller', 'orderable']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['buyer', 'seller', 'orderable']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,refunded',
        ]);

        $order->update($validated);

        return redirect()->back()
            ->with('success', 'Order updated successfully');
    }

    public function refund(Order $order)
    {
        $order->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
        ]);

        // Here you would add logic to process the actual refund

        return redirect()->back()
            ->with('success', 'Order refunded successfully');
    }

    public function destroy(Order $order)
    {
        if ($order->status !== 'cancelled') {
            return redirect()->back()
                ->with('error', 'Only cancelled orders can be deleted');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}
