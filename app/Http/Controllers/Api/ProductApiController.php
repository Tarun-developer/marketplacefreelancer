<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->with('media')->paginate(10);

        return response()->json($products);
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

        $product = Product::create($request->only('name', 'description', 'price', 'category_id'));

        // Handle preview images
        if ($request->hasFile('preview_images')) {
            foreach ($request->file('preview_images') as $image) {
                $product->addMedia($image)->toMediaCollection('preview');
            }
        }

        // Handle files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $product->addMedia($file)->toMediaCollection('files');
            }
        }

        return response()->json($product->load('media'), 201);
    }

    public function show(Product $product)
    {
        $product->load('category', 'media');

        return response()->json($product);
    }

    public function update(Request $request, Product $product)
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

        $product->update($request->only('name', 'description', 'price', 'category_id'));

        // Handle preview images
        if ($request->hasFile('preview_images')) {
            $product->clearMediaCollection('preview');
            foreach ($request->file('preview_images') as $image) {
                $product->addMedia($image)->toMediaCollection('preview');
            }
        }

        // Handle files
        if ($request->hasFile('files')) {
            $product->clearMediaCollection('files');
            foreach ($request->file('files') as $file) {
                $product->addMedia($file)->toMediaCollection('files');
            }
        }

        return response()->json($product->load('media'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }

    public function categories()
    {
        $categories = Category::all();

        return response()->json($categories);
    }
}
