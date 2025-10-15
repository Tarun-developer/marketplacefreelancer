<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use App\Modules\Orders\Models\Order;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->where('is_approved', true)
            ->with(['category', 'user'])
            ->latest()
            ->paginate(12);

        return view('client.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Check if product is active and approved
        if ($product->status !== 'active' || !$product->is_approved) {
            abort(404, 'Product not found or not available');
        }

        $product->load([
            'category',
            'user',
            'versions' => function ($query) {
                $query->where('is_active', true)->latest('version_number');
            },
            'currentVersion',
            'reviews' => function ($query) {
                $query->with('reviewer')->latest();
            }
        ]);

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->latest()
            ->take(4)
            ->get();

        // Calculate average rating
        $averageRating = $product->reviews->avg('rating') ?? 0;

        return view('client.products.show', compact('product', 'relatedProducts', 'averageRating'));
    }

    public function purchase(Product $product, Request $request)
    {
        $request->validate([
            'license_type' => 'required|in:standard,professional,ultimate',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        // Check if user is verified
        if (!$user->hasVerifiedEmail()) {
            return back()->with('error', 'Please verify your email before purchasing.');
        }

        // Get price based on license type
        $price = match ($request->license_type) {
            'standard' => $product->standard_price ?? $product->price,
            'professional' => $product->professional_price ?? $product->price,
            'ultimate' => $product->ultimate_price ?? $product->price,
            default => $product->price,
        };

        $totalAmount = $price * $request->quantity;

        // Check if user has sufficient balance
        if ($totalAmount > $user->wallet_balance) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        try {
            DB::transaction(function () use ($product, $user, $request, $totalAmount) {
                // Create order
                $order = Order::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $product->user_id,
                    'orderable_type' => Product::class,
                    'orderable_id' => $product->id,
                    'amount' => $totalAmount,
                    'currency' => $product->currency ?? 'USD',
                    'status' => 'pending',
                    'payment_status' => 'paid',
                ]);

                // Deduct from wallet
                $user->decrement('wallet_balance', $totalAmount);

                // Create transaction record
                \App\Models\Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $totalAmount,
                    'type' => 'product_purchase',
                    'status' => 'completed',
                    'description' => "Purchased {$product->name} ({$request->license_type} license)",
                ]);

                // Send notifications or emails here if needed
            });

             // Generate license
             License::create([
                 'product_id' => $product->id,
                 'buyer_id' => $user->id,
                 'license_key' => License::generateLicenseKey($product->id, $user->id),
                 'license_type' => $request->license_type,
                 'activation_limit' => $this->getActivationLimit($request->license_type),
                 'status' => 'active',
             ]);

             return redirect()->route('downloads')->with('success', 'Product purchased successfully! Check your downloads page to access your product.');
        } catch (\Exception $e) {
             return back()->with('error', 'Purchase failed. Please try again.');
        }
    }

    private function getActivationLimit(string $licenseType): int
    {
        return match ($licenseType) {
            'standard' => 1,
            'professional' => 5,
            'ultimate' => 999999, // Unlimited
            default => 1,
        };
    }
}