@extends('layouts.app')

@section('title', 'Products - MarketFusion')

@section('content')
<div class="container-fluid py-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">Discover Amazing Products</h1>
            <p class="lead text-muted mb-4">Find scripts, plugins, templates, and digital assets from our talented creators</p>

            <!-- Search Bar -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-lg me-2" placeholder="Search products..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-lg">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <!-- Category Filter -->
                    <div class="mb-4">
                        <h6>Categories</h6>
                        <div class="list-group">
                            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('products.category', $category) }}" class="list-group-item list-group-item-action {{ request('category') == $category->id ? 'active' : '' }}">
                                    {{ $category->name }}
                                    <span class="badge bg-primary float-end">{{ $category->products->where('status', 'active')->where('is_approved', true)->count() }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Type Filter -->
                    <div class="mb-4">
                        <h6>Product Type</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_all" value="" {{ !request('type') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="type_all">All Types</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_script" value="script" {{ request('type') == 'script' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="type_script">Scripts</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_plugin" value="plugin" {{ request('type') == 'plugin' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="type_plugin">Plugins</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_template" value="template" {{ request('type') == 'template' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="type_template">Templates</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_graphic" value="graphic" {{ request('type') == 'graphic' ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="type_graphic">Graphics</label>
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="mb-4">
                        <h6>Sort By</h6>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Results Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    @if(request('search'))
                        Search Results for "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ $categories->find(request('category'))->name ?? 'Category' }} Products
                    @elseif(request('type'))
                        {{ ucfirst(request('type')) }} Products
                    @else
                        All Products
                    @endif
                    <small class="text-muted">({{ $products->total() }} products)</small>
                </h2>
            </div>

            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                <!-- Product Image -->
                                <div class="position-relative">
                                    @if($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif

                                    @if($product->is_featured)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">Featured</span>
                                    @endif

                                    @if($product->is_free)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">FREE</span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ Str::limit($product->name, 50) }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($product->short_description ?? strip_tags($product->description), 100) }}</p>

                                    <!-- Rating -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= ($product->average_rating ?? 0) ? '-fill text-warning' : ' text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted ms-2">({{ $product->reviews->count() ?? 0 }} reviews)</small>
                                        </div>
                                    </div>

                                    <!-- Pricing -->
                                    <div class="mt-auto">
                                        @if($product->is_free)
                                            <h4 class="text-success mb-2">FREE</h4>
                                        @else
                                            <h4 class="text-primary mb-2">
                                                @if($product->standard_price)
                                                    ${{ number_format($product->standard_price, 2) }}
                                                    @if($product->professional_price || $product->ultimate_price)
                                                        <small class="text-muted">starting</small>
                                                    @endif
                                                @else
                                                    ${{ number_format($product->price, 2) }}
                                                @endif
                                            </h4>
                                            @if($product->professional_price || $product->ultimate_price)
                                                <div class="text-muted small">
                                                    @if($product->professional_price)
                                                        <div>Professional: ${{ number_format($product->professional_price, 2) }}</div>
                                                    @endif
                                                    @if($product->ultimate_price)
                                                        <div>Ultimate: ${{ number_format($product->ultimate_price, 2) }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif

                                        <!-- Vendor Info -->
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $product->user->profile->avatar ?? asset('images/default-avatar.png') }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;" alt="{{ $product->user->name }}">
                                            <div>
                                                <small class="text-muted">by</small>
                                                <strong class="d-block">{{ $product->user->name }}</strong>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                                            @auth
                                                <button class="btn btn-outline-primary" onclick="addToCart({{ $product->id }})">
                                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login to Purchase</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-search display-4 text-muted mb-3"></i>
                    <h4>No Products Found</h4>
                    <p class="text-muted">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.rating {
    font-size: 0.9rem;
}
</style>
@endpush

@push('scripts')
<script>
function addToCart(productId) {
    // Implement add to cart functionality
    alert('Add to cart functionality coming soon!');
}
</script>
@endpush
@endsection