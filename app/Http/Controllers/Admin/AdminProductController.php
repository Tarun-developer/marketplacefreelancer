<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['user', 'category', 'media', 'reviews']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_approved' => 'boolean',
        ]);

        $product->update($validated);

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
