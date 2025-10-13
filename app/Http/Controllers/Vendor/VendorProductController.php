<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'screenshots' => 'nullable|array',
            'screenshots.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_file' => 'nullable|file|mimes:zip,rar|max:102400',
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

        // Handle file uploads
        $fileData = [];

        if ($request->hasFile('thumbnail')) {
            $fileData['thumbnail'] = $request->file('thumbnail')->store('product-thumbnails', 'public');
        }

        if ($request->hasFile('screenshots')) {
            $screenshots = [];
            foreach ($request->file('screenshots') as $screenshot) {
                $screenshots[] = $screenshot->store('product-screenshots', 'public');
            }
            $fileData['screenshots'] = $screenshots;
        }

        if ($request->hasFile('main_file')) {
            $fileData['file_path'] = $request->file('main_file')->store('product-files', 'public');
            $fileData['file_size'] = $request->file('main_file')->getSize();
        }

        $productData = array_merge($validated, $fileData, [
            'slug' => \Str::slug($validated['name']),
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

        $product->load(['versions', 'currentVersion', 'category']);
        return view('vendor.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $product->load(['versions', 'currentVersion', 'category']);
        $versions = $product->versions()->paginate(10);

        return view('vendor.products.edit', compact('product', 'versions'));
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'screenshots' => 'nullable|array',
            'screenshots.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_file' => 'nullable|file|mimes:zip,rar|max:102400',
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

        // Handle file uploads
        $fileData = [];

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $fileData['thumbnail'] = $request->file('thumbnail')->store('product-thumbnails', 'public');
        }

        if ($request->hasFile('screenshots')) {
            // Delete old screenshots if exists
            if ($product->screenshots) {
                foreach ($product->screenshots as $screenshot) {
                    Storage::disk('public')->delete($screenshot);
                }
            }
            $screenshots = [];
            foreach ($request->file('screenshots') as $screenshot) {
                $screenshots[] = $screenshot->store('product-screenshots', 'public');
            }
            $fileData['screenshots'] = $screenshots;
        }

        if ($request->hasFile('main_file')) {
            // Delete old main file if exists
            if ($product->file_path) {
                Storage::disk('public')->delete($product->file_path);
            }
            $fileData['file_path'] = $request->file('main_file')->store('product-files', 'public');
            $fileData['file_size'] = $request->file('main_file')->getSize();
        }

        $productData = array_merge($validated, $fileData, [
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

    /**
     * Create a new version for the product
     */
    public function createVersion(Request $request, Product $product)
    {
        // Check if the product belongs to the authenticated user
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'version_number' => 'required|string|max:50',
            'changelog' => 'required|string',
            'release_date' => 'required|date',
            'main_file' => 'required|file|mimes:zip,rar|max:102400', // 100MB max
        ]);

        $file = $request->file('main_file');
        $filePath = $file->store('product-files', 'public');

        $versionData = [
            'version_number' => $request->version_number,
            'changelog' => $request->changelog,
            'release_date' => $request->release_date,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'file_hashes' => [
                'md5' => md5_file($file->getRealPath()),
                'sha256' => hash_file('sha256', $file->getRealPath()),
            ],
        ];

        $product->createNewVersion($versionData);

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'New version created successfully');
    }

    /**
     * Update product status (Admin only)
     */
    public function updateStatus(Request $request, Product $product)
    {
        // Only admin can update status
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $product->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Product status updated successfully');
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
