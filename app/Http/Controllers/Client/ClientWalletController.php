<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientWalletController extends Controller
{
    public function index()
    {
        $wallet = auth()->user()->wallet;

        // Ensure wallet exists, create if not
        if (!$wallet) {
            $wallet = \App\Modules\Wallet\Models\Wallet::create([
                'user_id' => auth()->id(),
                'balance' => 0.00,
                'currency' => 'USD',
            ]);
        }

        $transactions = auth()->user()->walletTransactions()->latest()->paginate(10);

        return view('client.wallet.index', compact('wallet', 'transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        $user = auth()->user();
        $amount = $request->amount;

        // Here, integrate with payment gateway
        $paymentMethod = \App\Modules\Payments\Models\PaymentMethod::find($request->payment_method);

        if ($paymentMethod && $paymentMethod->user_id == $user->id) {
            // Simulate payment processing
            $paymentSuccess = true; // In real app, use gateway API

            if ($paymentSuccess) {
                $user->wallet->increment('balance', $amount);

                \App\Modules\Wallet\Models\WalletTransaction::create([
                    'wallet_id' => $user->wallet->id,
                    'type' => 'credit',
                    'amount' => $amount,
                    'description' => 'Wallet deposit',
                    'status' => 'completed',
                ]);

                return redirect()->route('client.wallet.index')->with('success', "Successfully deposited \${$amount} to your wallet.");
            }
        }

        return back()->with('error', 'Payment failed. Please try again.');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        $user = auth()->user();
        $amount = $request->amount;

        if ($user->wallet->balance < $amount) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        $paymentMethod = \App\Modules\Payments\Models\PaymentMethod::find($request->payment_method);

        if ($paymentMethod && $paymentMethod->user_id == $user->id) {
            // Simulate withdrawal processing
            $withdrawalSuccess = true; // In real app, use gateway API

            if ($withdrawalSuccess) {
                $user->wallet->decrement('balance', $amount);

                \App\Modules\Wallet\Models\WalletTransaction::create([
                    'wallet_id' => $user->wallet->id,
                    'type' => 'debit',
                    'amount' => $amount,
                    'description' => 'Wallet withdrawal',
                    'status' => 'completed',
                ]);

                return redirect()->route('client.wallet.index')->with('success', "Successfully withdrew \${$amount} from your wallet.");
            }
        }

        return back()->with('error', 'Withdrawal failed. Please try again.');
    }
}