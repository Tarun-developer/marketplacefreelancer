<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->with('category')->latest()->paginate(20);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = auth()->user()->products()->create($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('vendor.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('vendor.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function analytics()
    {
        $user = auth()->user();
        $stats = [
            'total_products' => $user->products()->count(),
            'total_sales' => $user->ordersAsSeller()->where('status', 'completed')->sum('amount'),
            'monthly_sales' => $user->ordersAsSeller()
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        return view('vendor.analytics', compact('stats'));
    }
}
