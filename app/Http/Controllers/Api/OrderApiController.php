<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $orders = $query->paginate(10);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:product,service,job',
            'item_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
        ]);

        $order = $request->user()->orders()->create($request->all());

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('user');

        return response()->json($order);
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled',
        ]);

        $order->update($request->only('status'));

        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return response()->json(null, 204);
    }
}
