<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Category;
use App\Modules\Services\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch featured products
        $featuredProducts = Product::where('is_approved', true)
            ->where('is_featured', true)
            ->where('status', 'active')
            ->with(['user', 'category'])
            ->latest()
            ->take(8)
            ->get();

        // Fetch latest products if no featured ones
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::where('is_approved', true)
                ->where('status', 'active')
                ->with(['user', 'category'])
                ->latest()
                ->take(8)
                ->get();
        }

        // Fetch trending services
        $trendingServices = Service::where('status', 'active')
            ->where('is_active', true)
            ->with('user')
            ->latest()
            ->take(8)
            ->get();

        // Fetch product categories
        $productCategories = Category::whereNull('parent_id')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(12)
            ->get();

        // Stats
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::where('is_approved', true)->count(),
            'total_services' => Service::where('status', 'active')->count(),
            'total_freelancers' => User::role('Freelancer')->count(),
        ];

        return view('welcome', compact(
            'featuredProducts',
            'trendingServices',
            'productCategories',
            'stats'
        ));
    }
}
