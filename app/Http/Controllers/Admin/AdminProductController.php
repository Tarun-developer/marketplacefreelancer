<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['user', 'category'])
            ->select(['id', 'name', 'slug', 'price', 'standard_price', 'professional_price', 'ultimate_price', 'status', 'is_approved', 'created_at', 'category_id', 'product_type', 'version', 'sales_count', 'download_count', 'is_featured', 'thumbnail'])
            ->latest()
            ->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['user', 'category', 'versions', 'licenses', 'reviews']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['category']);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'product_type' => 'required|in:script,plugin,template,graphic,course,service',
            'category_id' => 'nullable|exists:categories,id',
            'version' => 'nullable|string|max:50',
            'standard_price' => 'nullable|numeric|min:0',
            'professional_price' => 'nullable|numeric|min:0',
            'ultimate_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'is_free' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'search_keywords' => 'nullable|array',
            'compatible_with' => 'nullable|string|max:255',
            'files_included' => 'nullable|array',
            'requirements' => 'nullable|string',
            'estimated_delivery_time' => 'nullable|integer|min:1|max:365',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        // Handle file uploads
        $fileData = [];

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $fileData['thumbnail'] = $request->file('thumbnail')->store('product-thumbnails', 'public');
        }

        if ($request->hasFile('screenshots')) {
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    public function approve(Product $product)
    {
        $product->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Product approved successfully');
    }

    public function reject(Product $product)
    {
        $product->update(['is_approved' => false]);

        return redirect()->back()
            ->with('success', 'Product rejected successfully');
    }
}
