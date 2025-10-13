<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Payments\Models\PaymentGateway;
use App\Modules\Payments\Models\Transaction;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    public function gateways()
    {
        $gateways = PaymentGateway::all();
        return response()->json($gateways);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'gateway' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        // Simulate payment processing
        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'gateway' => $request->gateway,
            'status' => 'completed',
        ]);

        return response()->json($transaction, 201);
    }

    public function transactions(Request $request)
    {
        $query = $request->user()->transactions();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->paginate(10);
        return response()->json($transactions);
    }
}