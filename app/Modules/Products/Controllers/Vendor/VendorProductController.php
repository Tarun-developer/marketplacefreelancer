<?php

namespace App\Modules\Products\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->products();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->with('category')->paginate(10);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'preview_images' => 'array',
            'preview_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'files' => 'array',
            'files.*' => 'file|max:10240',
        ]);

        $product = $request->user()->products()->create($request->only('name', 'description', 'price', 'category_id'));

        // Handle media
        if ($request->hasFile('preview_images')) {
            foreach ($request->file('preview_images') as $image) {
                $product->addMedia($image)->toMediaCollection('preview');
            }
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $product->addMedia($file)->toMediaCollection('files');
            }
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($request->only('name', 'description', 'price', 'category_id'));

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product deleted successfully.');
    }
}
