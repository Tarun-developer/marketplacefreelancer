<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()
            ->with('category')
            ->select(['id', 'name', 'slug', 'price', 'standard_price', 'professional_price', 'ultimate_price', 'status', 'is_approved', 'created_at', 'category_id', 'product_type', 'version'])
            ->latest()
            ->paginate(20);
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
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'product_type' => 'required|in:script,plugin,template,graphic,course,service',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'demo_url' => 'nullable|url',
            'documentation_url' => 'nullable|url',
            'video_preview' => 'nullable|url',
            'standard_price' => 'nullable|numeric|min:0',
            'professional_price' => 'nullable|numeric|min:0',
            'ultimate_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_flash_sale' => 'boolean',
            'is_free' => 'boolean',
            'money_back_guarantee' => 'boolean',
            'refund_days' => 'nullable|integer|min:0|max:365',
            'version' => 'nullable|string|max:50',
            'changelog' => 'nullable|string',
            'feature_update_available' => 'boolean',
            'item_support_available' => 'boolean',
            'support_duration' => 'nullable|in:6_months,12_months,lifetime',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'search_keywords' => 'nullable|array',
            'compatible_with' => 'nullable|string|max:255',
            'files_included' => 'nullable|array',
            'requirements' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'co_authors' => 'nullable|array',
            'support_email' => 'nullable|email',
            'team_name' => 'nullable|string|max:255',
            'estimated_delivery_time' => 'nullable|integer|min:1|max:365',
            'status' => 'required|in:active,inactive',
        ]);

        $productData = array_merge($validated, [
            'slug' => \Str::slug($validated['name']),
            'file_path' => 'placeholder',
            'price' => $validated['standard_price'] ?? 0,
            'currency' => 'USD',
            'license_type' => 'single',
            'is_approved' => false,
            'is_featured' => false,
            'download_count' => 0,
            'sales_count' => 0,
            'views_count' => 0,
        ]);

        $product = auth()->user()->products()->create($productData);

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
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'product_type' => 'required|in:script,plugin,template,graphic,course,service',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'demo_url' => 'nullable|url',
            'documentation_url' => 'nullable|url',
            'video_preview' => 'nullable|url',
            'standard_price' => 'nullable|numeric|min:0',
            'professional_price' => 'nullable|numeric|min:0',
            'ultimate_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_flash_sale' => 'boolean',
            'is_free' => 'boolean',
            'money_back_guarantee' => 'boolean',
            'refund_days' => 'nullable|integer|min:0|max:365',
            'version' => 'nullable|string|max:50',
            'changelog' => 'nullable|string',
            'feature_update_available' => 'boolean',
            'item_support_available' => 'boolean',
            'support_duration' => 'nullable|in:6_months,12_months,lifetime',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'search_keywords' => 'nullable|array',
            'compatible_with' => 'nullable|string|max:255',
            'files_included' => 'nullable|array',
            'requirements' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'co_authors' => 'nullable|array',
            'support_email' => 'nullable|email',
            'team_name' => 'nullable|string|max:255',
            'estimated_delivery_time' => 'nullable|integer|min:1|max:365',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $productData = array_merge($validated, [
            'slug' => \Str::slug($validated['name']),
            'price' => $validated['standard_price'] ?? $product->price,
        ]);

        $product->update($productData);

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
