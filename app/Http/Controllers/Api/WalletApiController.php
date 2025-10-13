<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletApiController extends Controller
{
    public function balance(Request $request)
    {
        $wallet = $request->user()->wallet;
        return response()->json(['balance' => $wallet ? $wallet->balance : 0]);
    }

    public function transactions(Request $request)
    {
        $query = $request->user()->walletTransactions();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->paginate(10);
        return response()->json($transactions);
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $wallet = $request->user()->wallet ?: Wallet::create(['user_id' => $request->user()->id]);

        $transaction = $wallet->transactions()->create([
            'amount' => $request->amount,
            'type' => 'credit',
            'description' => 'Deposit',
        ]);

        $wallet->increment('balance', $request->amount);

        return response()->json($transaction, 201);
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $wallet = $request->user()->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        $transaction = $wallet->transactions()->create([
            'amount' => $request->amount,
            'type' => 'debit',
            'description' => 'Withdrawal',
        ]);

        $wallet->decrement('balance', $request->amount);

        return response()->json($transaction, 201);
    }
}