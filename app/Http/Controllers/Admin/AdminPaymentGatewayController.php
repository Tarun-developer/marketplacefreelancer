<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Payments\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPaymentGatewayController extends Controller
{
    /**
     * Display a listing of payment gateways
     */
    public function index(Request $request)
    {
        $query = PaymentGateway::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $gateways = $query->orderBy('sort_order')->orderBy('name')->paginate(15);

        // Stats
        $stats = [
            'total' => PaymentGateway::count(),
            'active' => PaymentGateway::where('is_active', true)->count(),
            'fiat' => PaymentGateway::where('type', 'fiat')->count(),
            'crypto' => PaymentGateway::where('type', 'crypto')->count(),
            'wallet' => PaymentGateway::where('type', 'wallet')->count(),
        ];

        return view('admin.payment-gateways.index', compact('gateways', 'stats'));
    }

    /**
     * Show the form for creating a new gateway
     */
    public function create()
    {
        return view('admin.payment-gateways.create');
    }

    /**
     * Store a newly created gateway
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:payment_gateways',
            'type' => 'required|in:fiat,crypto,wallet',
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'supported_currencies' => 'nullable|array',
            'supported_countries' => 'nullable|array',
            'transaction_fee_percentage' => 'nullable|numeric|min:0|max:100',
            'transaction_fee_fixed' => 'nullable|numeric|min:0',
            'transaction_fee_currency' => 'nullable|string|size:3',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'processing_time_minutes' => 'nullable|integer|min:0',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'test_mode' => 'boolean',
            'sort_order' => 'nullable|integer',
            'user_instructions' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'is_active' => 'boolean',
            'config' => 'nullable|array',
            'sandbox_config' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        $gateway = PaymentGateway::create($validated);

        return redirect()
            ->route('admin.payment-gateways.show', $gateway)
            ->with('success', 'Payment gateway created successfully.');
    }

    /**
     * Display the specified gateway
     */
    public function show(PaymentGateway $paymentGateway)
    {
        $paymentGateway->load(['transactions' => function ($query) {
            $query->latest()->limit(10);
        }]);

        // Recent stats
        $stats = [
            'total_transactions' => $paymentGateway->transactions()->count(),
            'successful_transactions' => $paymentGateway->transactions()->completed()->count(),
            'failed_transactions' => $paymentGateway->transactions()->failed()->count(),
            'total_volume' => $paymentGateway->total_volume,
            'average_transaction' => $paymentGateway->total_transactions > 0
                ? $paymentGateway->total_volume / $paymentGateway->total_transactions
                : 0,
        ];

        return view('admin.payment-gateways.show', compact('paymentGateway', 'stats'));
    }

    /**
     * Show the form for editing the specified gateway
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        return view('admin.payment-gateways.edit', compact('paymentGateway'));
    }

    /**
     * Update the specified gateway
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:payment_gateways,slug,' . $paymentGateway->id,
            'type' => 'required|in:fiat,crypto,wallet',
            'description' => 'nullable|string',
            'logo' => 'nullable|string|max:255',
            'supported_currencies' => 'nullable|array',
            'supported_countries' => 'nullable|array',
            'transaction_fee_percentage' => 'nullable|numeric|min:0|max:100',
            'transaction_fee_fixed' => 'nullable|numeric|min:0',
            'transaction_fee_currency' => 'nullable|string|size:3',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'processing_time_minutes' => 'nullable|integer|min:0',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
            'test_mode' => 'boolean',
            'sort_order' => 'nullable|integer',
            'user_instructions' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'is_active' => 'boolean',
            'config' => 'nullable|array',
            'sandbox_config' => 'nullable|array',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);

        $paymentGateway->update($validated);

        return redirect()
            ->route('admin.payment-gateways.show', $paymentGateway)
            ->with('success', 'Payment gateway updated successfully.');
    }

    /**
     * Remove the specified gateway
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        // Check if gateway has transactions
        if ($paymentGateway->transactions()->exists()) {
            return redirect()
                ->route('admin.payment-gateways.index')
                ->with('error', 'Cannot delete gateway with existing transactions. Deactivate it instead.');
        }

        $paymentGateway->delete();

        return redirect()
            ->route('admin.payment-gateways.index')
            ->with('success', 'Payment gateway deleted successfully.');
    }

    /**
     * Toggle gateway status
     */
    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update([
            'is_active' => !$paymentGateway->is_active,
        ]);

        $status = $paymentGateway->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->back()
            ->with('success', "Payment gateway {$status} successfully.");
    }

    /**
     * Toggle test mode
     */
    public function toggleTestMode(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update([
            'test_mode' => !$paymentGateway->test_mode,
        ]);

        $mode = $paymentGateway->test_mode ? 'test' : 'live';

        return redirect()
            ->back()
            ->with('success', "Payment gateway switched to {$mode} mode successfully.");
    }

    /**
     * Update gateway configuration
     */
    public function updateConfig(Request $request, PaymentGateway $paymentGateway)
    {
        $validated = $request->validate([
            'config_type' => 'required|in:live,sandbox',
            'config' => 'required|array',
        ]);

        if ($validated['config_type'] === 'sandbox') {
            $paymentGateway->update([
                'sandbox_config' => $validated['config'],
            ]);
        } else {
            $paymentGateway->update([
                'config' => $validated['config'],
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Gateway configuration updated successfully.');
    }
}
