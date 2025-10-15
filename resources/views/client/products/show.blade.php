@extends('layouts.client')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('client.products.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-2"></i>My Products
                </a>
            </li>
            <li class="breadcrumb-item active text-truncate">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-8">
            <!-- Product Header -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 150px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 100%; height: 150px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h1 class="h3 mb-2">{{ $product->name }}</h1>
                            <p class="text-muted mb-3">
                                <i class="bi bi-person me-2"></i>By {{ $product->user->name ?? 'Vendor' }}
                            </p>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">
                                    <i class="bi bi-check-circle me-1"></i>{{ ucfirst($product->status) }}
                                </span>
                                <div class="rating">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="ms-1">{{ number_format($averageRating, 1) }}</span>
                                    <span class="text-muted">({{ $product->reviews->count() }} reviews)</span>
                                </div>
                            </div>
                            <div class="d-flex gap-3 text-muted">
                                <span><i class="bi bi-eye me-1"></i>{{ number_format($product->views_count) }} views</span>
                                <span><i class="bi bi-download me-1"></i>{{ number_format($product->sales_count) }} purchases</span>
                                <span><i class="bi bi-calendar me-1"></i>{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">
                        <i class="bi bi-align-left me-2 text-primary"></i>Description
                    </h5>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            @if($product->reviews->count() > 0)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">
                        <i class="bi bi-star me-2 text-warning"></i>Customer Reviews ({{ $product->reviews->count() }})
                    </h5>
                    @foreach($product->reviews->take(5) as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                <span class="fw-bold">{{ strtoupper(substr($review->reviewer->name ?? 'U', 0, 1)) }}</span>
                            </div>
                            <div>
                                <strong>{{ $review->reviewer->name ?? 'Anonymous' }}</strong>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted ms-auto">{{ $review->created_at->format('M d, Y') }}</small>
                        </div>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Product Summary -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Product Details
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span><i class="bi bi-tag me-2"></i>Category:</span>
                                <strong>{{ $product->category->name ?? 'General' }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span><i class="bi bi-currency-dollar me-2"></i>Price:</span>
                                <strong>${{ number_format($product->price, 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                <span><i class="bi bi-person me-2"></i>Vendor:</span>
                                <strong>{{ $product->user->name ?? 'Vendor' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Section -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-cart me-2 text-primary"></i>Purchase Product
                    </h5>
                    <p class="text-muted mb-3">Secure payment via wallet</p>
                    <form action="{{ route('client.products.purchase', $product) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="license_type" class="form-label">License Type</label>
                            <select name="license_type" id="license_type" class="form-select" required>
                                <option value="standard" data-price="{{ $product->standard_price ?? $product->price }}">Standard License - ${{ number_format($product->standard_price ?? $product->price, 2) }}</option>
                                <option value="professional" data-price="{{ $product->professional_price ?? $product->price }}">Professional License - ${{ number_format($product->professional_price ?? $product->price, 2) }}</option>
                                <option value="ultimate" data-price="{{ $product->ultimate_price ?? $product->price }}">Ultimate License - ${{ number_format($product->ultimate_price ?? $product->price, 2) }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2">
                            <i class="bi bi-credit-card me-2"></i>Buy for ${{ number_format($product->price, 2) }}
                        </button>
                    </form>
                    <small class="text-muted d-block mt-2">Instant download after purchase</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating {
    font-size: 0.9rem;
}

.card {
    border-radius: 12px;
}
</style>
@endsection