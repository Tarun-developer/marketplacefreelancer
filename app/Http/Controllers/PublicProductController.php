<?php

namespace App\Http\Controllers;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Category;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user'])
            ->where('status', 'active')
            ->where('is_approved', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by product type
        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('download_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('products.public-index', compact('products', 'categories'));
    }

    /**
     * Display products by category
     */
    public function category(Category $category)
    {
        $products = Product::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->where('is_approved', true)
            ->latest()
            ->paginate(12);

        return view('products.public-category', compact('products', 'category'));
    }

    /**
     * Display the specified product
     */
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
                $query->with('user')->latest();
            }
        ]);

        // Increment view count
        $product->increment('views_count');

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

        return view('products.public-show', compact('product', 'relatedProducts', 'averageRating'));
    }
}