@extends('layouts.client')

@section('title', 'My Products')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">My Products</h1>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($product->name, 50) }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->short_description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary">{{ $product->category->name ?? 'General' }}</span>
                            <div class="text-end">
                                <small class="text-muted d-block">From</small>
                                <strong>${{ number_format($product->standard_price ?? $product->price, 2) }}</strong>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('client.products.show', $product) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                            <a href="{{ route('client.products.purchase', $product) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-cart me-1"></i>Purchase
                            </a>
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

    @if($products->hasPages())
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection