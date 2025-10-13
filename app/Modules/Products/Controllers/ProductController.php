<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'user')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'slug' => 'nullable|string|max:255|unique:products',
             'short_description' => 'nullable|string|max:500',
             'description' => 'required|string',
             'product_type' => 'nullable|string|in:theme,plugin,template,other',
             'tags' => 'nullable|array',
             'framework_technology' => 'nullable|string|max:255',
             'demo_url' => 'nullable|url',
             'documentation_url' => 'nullable|url',
             'category_id' => 'required|exists:categories,id',
             'subcategory_id' => 'nullable|exists:categories,id',
             'standard_price' => 'nullable|numeric|min:0',
             'professional_price' => 'nullable|numeric|min:0',
             'extended_price' => 'nullable|numeric|min:0',
             'discount_percentage' => 'nullable|numeric|min:0|max:100',
             'is_flash_sale' => 'boolean',
             'is_free' => 'boolean',
             'version' => 'nullable|string|max:50',
             'release_date' => 'nullable|date',
             'changelog' => 'nullable|string',
             'has_feature_updates' => 'boolean',
             'auto_update_url' => 'nullable|url',
             'has_support' => 'boolean',
             'support_duration' => 'nullable|integer|min:1',
             'support_link' => 'nullable|url',
             'has_refund_guarantee' => 'boolean',
             'refund_days' => 'nullable|integer|min:1',
             'refund_terms' => 'nullable|string',
             'is_featured' => 'boolean',
             'visibility' => 'nullable|string|in:public,private,draft',
             'publish_date' => 'nullable|date',
             'author_commission' => 'nullable|numeric|min:0|max:100',
             'team_members' => 'nullable|array',
             'seo_title' => 'nullable|string|max:255',
             'seo_description' => 'nullable|string|max:500',
             'seo_keywords' => 'nullable|array',
             'status' => 'nullable|string|in:active,inactive,pending',
         ]);

         $product = Product::create($request->all());

         // Handle file uploads
         if ($request->has('thumbnail')) {
             $product->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
         }
         if ($request->has('screenshots')) {
             foreach ($request->file('screenshots') as $file) {
                 $product->addMedia($file)->toMediaCollection('screenshots');
             }
         }
         if ($request->has('main_file')) {
             $product->addMediaFromRequest('main_file')->toMediaCollection('main_file');
         }
         if ($request->has('preview_file')) {
             $product->addMediaFromRequest('preview_file')->toMediaCollection('preview_file');
         }
         if ($request->has('og_image')) {
             $product->addMediaFromRequest('og_image')->toMediaCollection('og_image');
         }

         return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
     }

    public function show(Product $product)
    {
        $product->load('category', 'user', 'media');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

     public function update(Request $request, Product $product)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
             'short_description' => 'nullable|string|max:500',
             'description' => 'required|string',
             'product_type' => 'nullable|string|in:theme,plugin,template,other',
             'tags' => 'nullable|array',
             'framework_technology' => 'nullable|string|max:255',
             'demo_url' => 'nullable|url',
             'documentation_url' => 'nullable|url',
             'category_id' => 'required|exists:categories,id',
             'subcategory_id' => 'nullable|exists:categories,id',
             'standard_price' => 'nullable|numeric|min:0',
             'professional_price' => 'nullable|numeric|min:0',
             'extended_price' => 'nullable|numeric|min:0',
             'discount_percentage' => 'nullable|numeric|min:0|max:100',
             'is_flash_sale' => 'boolean',
             'is_free' => 'boolean',
             'version' => 'nullable|string|max:50',
             'release_date' => 'nullable|date',
             'changelog' => 'nullable|string',
             'has_feature_updates' => 'boolean',
             'auto_update_url' => 'nullable|url',
             'has_support' => 'boolean',
             'support_duration' => 'nullable|integer|min:1',
             'support_link' => 'nullable|url',
             'has_refund_guarantee' => 'boolean',
             'refund_days' => 'nullable|integer|min:1',
             'refund_terms' => 'nullable|string',
             'is_featured' => 'boolean',
             'visibility' => 'nullable|string|in:public,private,draft',
             'publish_date' => 'nullable|date',
             'author_commission' => 'nullable|numeric|min:0|max:100',
             'team_members' => 'nullable|array',
             'seo_title' => 'nullable|string|max:255',
             'seo_description' => 'nullable|string|max:500',
             'seo_keywords' => 'nullable|array',
             'status' => 'nullable|string|in:active,inactive,pending',
         ]);

         $product->update($request->all());

         // Handle file uploads
         if ($request->has('thumbnail')) {
             $product->clearMediaCollection('thumbnail');
             $product->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnail');
         }
         if ($request->has('screenshots')) {
             $product->clearMediaCollection('screenshots');
             foreach ($request->file('screenshots') as $file) {
                 $product->addMedia($file)->toMediaCollection('screenshots');
             }
         }
         if ($request->has('main_file')) {
             $product->clearMediaCollection('main_file');
             $product->addMediaFromRequest('main_file')->toMediaCollection('main_file');
         }
         if ($request->has('preview_file')) {
             $product->clearMediaCollection('preview_file');
             $product->addMediaFromRequest('preview_file')->toMediaCollection('preview_file');
         }
         if ($request->has('og_image')) {
             $product->clearMediaCollection('og_image');
             $product->addMediaFromRequest('og_image')->toMediaCollection('og_image');
         }

         return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
     }

     public function destroy(Product $product)
     {
         $product->delete();

         return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
     }

     public function getSubcategories(Category $category)
     {
         return response()->json($category->children);
     }
 }
