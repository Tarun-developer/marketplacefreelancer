<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Wallet\Models\WalletTransaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletTransaction::with(['user', 'wallet']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(WalletTransaction $transaction)
    {
        $transaction->load(['user', 'wallet']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function approve(WalletTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Only pending transactions can be approved');
        }

        $transaction->update(['status' => 'completed']);

        // Process the transaction (update wallet balance, etc.)
        if ($transaction->type === 'withdrawal') {
            // Add withdrawal processing logic
        }

        return redirect()->back()
            ->with('success', 'Transaction approved successfully');
    }

    public function reject(Request $request, WalletTransaction $transaction)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $transaction->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()
            ->with('success', 'Transaction rejected successfully');
    }
}
