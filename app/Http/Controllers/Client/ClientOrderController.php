<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;

class ClientOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('client.orders.show', compact('order'));
    }
}
