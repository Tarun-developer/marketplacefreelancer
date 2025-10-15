<?php

namespace App\Http\Controllers;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

         return view('public.products.index', compact('products', 'categories'));
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

         return view('public.products.category', compact('products', 'category'));
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

          return view('public.products.show', compact('product', 'relatedProducts', 'averageRating'));
    }

    /**
     * Show the checkout page for a product
     */
    public function checkout(Product $product, Request $request)
    {
        // Check if product is active and approved
        if ($product->status !== 'active' || !$product->is_approved) {
            abort(404, 'Product not found or not available');
        }

        $licenseType = $request->get('license_type', 'standard');
        $price = $this->getPriceForLicense($product, $licenseType);

        if (!$price) {
            abort(400, 'Invalid license type');
        }

        return view('products.checkout', compact('product', 'licenseType', 'price'));
    }

    /**
     * Process product purchase
     */
    public function purchase(Product $product, Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to purchase products');
        }

        $request->validate([
            'license_type' => 'required|in:standard,professional,ultimate',
        ]);

        $licenseType = $request->license_type;
        $price = $this->getPriceForLicense($product, $licenseType);

        if (!$price) {
            return back()->with('error', 'Invalid license type or price');
        }

        // Here you would integrate with a payment gateway
        // For now, we'll simulate a successful purchase
        $order = \App\Models\Order::create([
            'user_id' => Auth::id(),
            'orderable_type' => Product::class,
            'orderable_id' => $product->id,
            'amount' => $price,
            'currency' => $product->currency ?? 'USD',
            'status' => 'completed', // In real implementation, this would be 'pending'
            'payment_method' => 'simulated',
            'metadata' => [
                'license_type' => $licenseType,
            ],
        ]);

        // Generate license if applicable
        if (in_array($licenseType, ['standard', 'professional', 'ultimate'])) {
            \App\Models\License::create([
                'product_id' => $product->id,
                'buyer_id' => Auth::id(),
                'license_key' => \App\Models\License::generateLicenseKey($product->id, Auth::id()),
                'license_type' => $licenseType,
                'activation_limit' => $this->getActivationLimit($licenseType),
                'status' => 'active',
            ]);
        }

        return redirect()->route('downloads')->with('success', 'Purchase completed successfully! Check your downloads page to access your product.');
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login to add to cart'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'license_type' => 'required|in:standard,professional,ultimate',
        ]);

        $product = Product::findOrFail($request->product_id);
        $licenseType = $request->license_type;
        $price = $this->getPriceForLicense($product, $licenseType);

        if (!$price) {
            return response()->json(['error' => 'Invalid license type or price'], 400);
        }

        // Here you would add to a cart system (session, database, etc.)
        // For now, we'll use session
        $cart = session()->get('cart', []);
        $cartItemKey = $product->id . '_' . $licenseType;

        $cart[$cartItemKey] = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'license_type' => $licenseType,
            'price' => $price,
            'currency' => $product->currency ?? 'USD',
        ];

        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    /**
     * Get price for a specific license type
     */
    private function getPriceForLicense(Product $product, string $licenseType): ?float
    {
        return match ($licenseType) {
            'standard' => $product->standard_price ?? $product->price,
            'professional' => $product->professional_price,
            'ultimate' => $product->ultimate_price,
            default => null,
        };
    }

    /**
     * Get activation limit for license type
     */
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