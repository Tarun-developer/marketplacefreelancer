@extends('layouts.guest')

@section('title', 'Marketplace - Products')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="display-4 fw-bold text-gradient mb-3">Marketplace</h1>
            <p class="lead text-muted">Discover amazing products from our vendors</p>
        </div>
    </div>

    <!-- Controls Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <!-- View Toggle -->
            <div class="btn-group" role="group" aria-label="View toggle">
                <input type="radio" class="btn-check" name="viewMode" id="gridView" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="gridView">
                    <i class="bi bi-grid-3x3"></i> Grid
                </label>

                <input type="radio" class="btn-check" name="viewMode" id="listView" autocomplete="off">
                <label class="btn btn-outline-primary" for="listView">
                    <i class="bi bi-list"></i> List
                </label>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <!-- Sort Options (if needed) -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel me-2"></i>Sort by
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Latest</a></li>
                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                    <li><a class="dropdown-item" href="#">Popular</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="row products-container" id="productsContainer">
        @forelse($products ?? [] as $product)
            <!-- Grid View Item -->
            <div class="col-lg-4 col-md-6 mb-4 grid-item">
                <div class="card product-card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                        <div class="card-img-overlay d-flex align-items-start justify-content-end p-2">
                            <span class="badge bg-primary">{{ $product->category->name ?? 'General' }}</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2">{{ Str::limit($product->name, 50) }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->short_description ?? $product->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">By {{ $product->user->name ?? 'Vendor' }}</small>
                            <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong class="text-success fs-5">${{ number_format($product->price, 2) }}</strong>
                            <div class="rating">
                                <i class="bi bi-star-fill text-warning"></i>
                                <span class="ms-1">{{ number_format(rand(45, 50) / 10, 1) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary w-100 mt-auto">
                            <i class="bi bi-eye me-2"></i>View Product
                        </a>
                    </div>
                </div>
            </div>

            <!-- List View Item (Hidden by default) -->
            <div class="col-12 mb-3 list-item d-none">
                <div class="card product-card-list border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid rounded-start" alt="{{ $product->name }}" style="height: 200px; object-fit: cover; width: 100%;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-start" style="height: 200px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="card-body h-100 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                    <span class="badge bg-primary">{{ $product->category->name ?? 'General' }}</span>
                                </div>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->short_description ?? $product->description, 200) }}</p>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-person me-2 text-muted"></i>
                                            <small class="text-muted">By {{ $product->user->name ?? 'Vendor' }}</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar me-2 text-muted"></i>
                                            <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <div class="mb-2">
                                            <strong class="text-success fs-4">${{ number_format($product->price, 2) }}</strong>
                                        </div>
                                        <div class="rating mb-2">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="ms-1">{{ number_format(rand(45, 50) / 10, 1) }}</span>
                                        </div>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
                                            <i class="bi bi-eye me-2"></i>View Product
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-shop display-1 text-muted mb-3"></i>
                <h3 class="text-muted">No products available</h3>
                <p class="text-muted">Check back later for new products</p>
            </div>
        @endforelse
    </div>

    @if(isset($products) && $products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.product-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.product-card-list {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.product-card-list:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.rating {
    font-size: 0.9rem;
}

.btn-check:checked + .btn {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}

.btn-outline-primary:hover {
    background-color: #667eea;
    border-color: #667eea;
}

/* List/Grid Toggle Animation */
.products-container .grid-item,
.products-container .list-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.products-container.list-view .grid-item {
    display: none;
}

.products-container.list-view .list-item {
    display: block !important;
}

.products-container.grid-view .list-item {
    display: none !important;
}

.products-container.grid-view .grid-item {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const productsContainer = document.getElementById('productsContainer');

    gridViewBtn.addEventListener('change', function() {
        if (this.checked) {
            productsContainer.classList.remove('list-view');
            productsContainer.classList.add('grid-view');
        }
    });

    listViewBtn.addEventListener('change', function() {
        if (this.checked) {
            productsContainer.classList.remove('grid-view');
            productsContainer.classList.add('list-view');
        }
    });

    // Set initial state
    productsContainer.classList.add('grid-view');
});
</script>
@endsection