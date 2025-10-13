@extends('layouts.app')

@section('title', $category->name . ' Products - MarketFusion')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-primary mb-3">{{ $category->name }}</h1>
            <p class="lead text-muted">{{ $category->description ?? 'Discover amazing products in this category' }}</p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @if($products->count() > 0)
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="col-12 text-center py-5">
                <i class="bi bi-search display-4 text-muted mb-3"></i>
                <h4>No Products Found</h4>
                <p class="text-muted">No products are available in this category yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse All Products</a>
            </div>
        @endif
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