@extends('layouts.app')

@section('title', $product->meta_title ?? $product->name . ' - MarketFusion')
@section('description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))

@push('meta')
    <meta property="og:title" content="{{ $product->meta_title ?? $product->name }}" />
    <meta property="og:description" content="{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 160) }}" />
    <meta property="og:image" content="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : asset('images/default-product.png') }}" />
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta property="og:type" content="product" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $product->meta_title ?? $product->name }}" />
    <meta name="twitter:description" content="{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 160) }}" />
    <meta name="twitter:image" content="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : asset('images/default-product.png') }}" />

    <link rel="canonical" href="{{ request()->url() }}" />
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images Gallery -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <!-- Main Image -->
                    <div class="product-gallery-main mb-3">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid w-100" alt="{{ $product->name }}" style="max-height: 400px; object-fit: contain;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->screenshots && count($product->screenshots) > 0)
                        <div class="product-gallery-thumbnails d-flex gap-2 overflow-auto pb-2">
                            <div class="thumbnail-item active" onclick="changeMainImage('{{ asset('storage/' . $product->thumbnail) }}')">
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;" alt="Main">
                                @endif
                            </div>
                            @foreach($product->screenshots as $screenshot)
                                <div class="thumbnail-item" onclick="changeMainImage('{{ asset('storage/' . $screenshot) }}')">
                                    <img src="{{ asset('storage/' . $screenshot) }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;" alt="Screenshot">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Description -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Product Description</h4>
                </div>
                <div class="card-body">
                    <div class="product-description">
                        {!! $product->description !!}
                    </div>

                    @if($product->demo_url)
                        <div class="mt-3">
                            <a href="{{ $product->demo_url }}" class="btn btn-outline-primary" target="_blank">
                                <i class="bi bi-eye me-2"></i>View Live Demo
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Version History -->
            @if($product->versions && $product->versions->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Version History</h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="versionAccordion">
                            @foreach($product->versions as $version)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $version->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $version->id }}">
                                            Version {{ $version->version_number }} - {{ $version->release_date->format('M d, Y') }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $version->id }}" class="accordion-collapse collapse" data-bs-parent="#versionAccordion">
                                        <div class="accordion-body">
                                            @if($version->changelog)
                                                <h6>What's New:</h6>
                                                <div class="changelog-content">
                                                    {!! nl2br(e($version->changelog)) !!}
                                                </div>
                                            @endif
                                            <div class="mt-3">
                                                <strong>File Size:</strong> {{ number_format($version->file_size / 1024 / 1024, 2) }} MB<br>
                                                <strong>Downloads:</strong> {{ $version->download_count }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reviews Section -->
            @if($product->reviews && $product->reviews->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Customer Reviews</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h2 class="text-primary">{{ number_format($averageRating, 1) }}</h2>
                                    <div class="rating mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $averageRating ? '-fill text-warning' : ' text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted">{{ $product->reviews->count() }} reviews</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                @foreach($product->reviews->take(3) as $review)
                                    <div class="review-item mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $review->user->profile->avatar ?? asset('images/default-avatar.png') }}" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $review->user->name }}">
                                            <div>
                                                <strong>{{ $review->user->name }}</strong>
                                                <div class="rating small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted ms-auto">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                                @if($product->reviews->count() > 3)
                                    <a href="#all-reviews" class="btn btn-outline-primary btn-sm">View All Reviews</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Details Sidebar -->
        <div class="col-lg-4">
            <!-- Purchase Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <p class="text-muted small mb-3">by {{ $product->user->name }}</p>

                    <!-- Rating Display -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rating me-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $averageRating ? '-fill text-warning' : ' text-muted' }}"></i>
                            @endfor
                        </div>
                        <span>{{ number_format($averageRating, 1) }} ({{ $product->reviews->count() ?? 0 }} reviews)</span>
                    </div>

                    <!-- Pricing -->
                    @if($product->is_free)
                        <div class="mb-3">
                            <h2 class="text-success">FREE</h2>
                            <p class="text-muted">Download now at no cost</p>
                        </div>
                    @else
                        <div class="mb-3">
                            <h2 class="text-primary">
                                @if($product->standard_price)
                                    ${{ number_format($product->standard_price, 2) }}
                                @else
                                    ${{ number_format($product->price, 2) }}
                                @endif
                                @if($product->professional_price || $product->ultimate_price)
                                    <small class="text-muted">starting</small>
                                @endif
                            </h2>

                            @if($product->professional_price || $product->ultimate_price)
                                <div class="pricing-tiers mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="license_type" id="standard" value="standard" checked>
                                        <label class="form-check-label" for="standard">
                                            <strong>Standard License</strong> - ${{ number_format($product->standard_price ?? $product->price, 2) }}
                                            <small class="text-muted d-block">Single site usage</small>
                                        </label>
                                    </div>
                                    @if($product->professional_price)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="license_type" id="professional" value="professional">
                                            <label class="form-check-label" for="professional">
                                                <strong>Professional License</strong> - ${{ number_format($product->professional_price, 2) }}
                                                <small class="text-muted d-block">Multiple sites, extended use</small>
                                            </label>
                                        </div>
                                    @endif
                                    @if($product->ultimate_price)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="license_type" id="ultimate" value="ultimate">
                                            <label class="form-check-label" for="ultimate">
                                                <strong>Ultimate License</strong> - ${{ number_format($product->ultimate_price, 2) }}
                                                <small class="text-muted d-block">Unlimited use, SaaS ready</small>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Purchase Buttons -->
                    @auth
                        @if($product->is_free)
                            <a href="{{ route('products.download', $product) }}" class="btn btn-success btn-lg w-100 mb-2">
                                <i class="bi bi-download me-2"></i>Download Free
                            </a>
                        @else
                            <button class="btn btn-primary btn-lg w-100 mb-2" onclick="initiatePurchase()">
                                <i class="bi bi-credit-card me-2"></i>Purchase Now
                            </button>
                            <button class="btn btn-outline-primary w-100" onclick="addToCart()">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-2">Login to Purchase</a>
                        <p class="text-muted text-center small">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                    @endauth

                    <!-- Product Stats -->
                    <div class="product-stats mt-4 pt-3 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-value">{{ $product->sales_count ?? 0 }}</div>
                                <div class="stat-label">Sales</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-value">{{ $product->download_count ?? 0 }}</div>
                                <div class="stat-label">Downloads</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-value">{{ $product->views_count ?? 0 }}</div>
                                <div class="stat-label">Views</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Category:</strong></td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td><span class="badge bg-info">{{ ucfirst($product->product_type ?? 'script') }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Version:</strong></td>
                            <td>{{ $product->version ?? '1.0.0' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Released:</strong></td>
                            <td>{{ $product->release_date ? $product->release_date->format('M d, Y') : 'Not specified' }}</td>
                        </tr>
                        @if($product->compatible_with)
                            <tr>
                                <td><strong>Compatible With:</strong></td>
                                <td>{{ $product->compatible_with }}</td>
                            </tr>
                        @endif
                        @if($product->requirements)
                            <tr>
                                <td><strong>Requirements:</strong></td>
                                <td>{{ $product->requirements }}</td>
                            </tr>
                        @endif
                    </table>

                    @if($product->tags && count($product->tags) > 0)
                        <div class="mt-3">
                            <strong>Tags:</strong>
                            <div class="mt-2">
                                @foreach($product->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vendor Information -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Vendor Information</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $product->user->profile->avatar ?? asset('images/default-avatar.png') }}" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->user->name }}">
                        <div>
                            <h6 class="mb-0">{{ $product->user->name }}</h6>
                            <p class="text-muted mb-0">{{ $product->user->profile->bio ?? 'Professional creator' }}</p>
                        </div>
                    </div>

                    @if($product->support_email)
                        <p><strong>Support:</strong> <a href="mailto:{{ $product->support_email }}">{{ $product->support_email }}</a></p>
                    @endif

                    <div class="d-grid gap-2">
                        @auth
                            <a href="{{ route('messages.start', $product->user->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-chat-dots me-2"></i>Chat with Vendor
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-chat-dots me-2"></i>Login to Chat
                            </a>
                        @endauth
                        <a href="{{ route('vendor.profile', $product->user) }}" class="btn btn-outline-primary btn-sm">
                            View Vendor Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card product-card h-100 shadow-sm">
                                @if($relatedProduct->thumbnail)
                                    <img src="{{ asset('storage/' . $relatedProduct->thumbnail) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($relatedProduct->name, 40) }}</h6>
                                    <p class="text-primary mb-2">${{ number_format($relatedProduct->price, 2) }}</p>
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-primary btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.product-gallery-main img {
    border-radius: 8px;
}
.product-gallery-thumbnails {
    max-width: 100%;
}
.thumbnail-item {
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 4px;
    transition: border-color 0.2s;
}
.thumbnail-item.active,
.thumbnail-item:hover {
    border-color: #007bff;
}
.product-description {
    line-height: 1.6;
}
.product-description h1, .product-description h2, .product-description h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}
.product-description ul, .product-description ol {
    padding-left: 1.5rem;
}
.product-description code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
}
.pricing-tiers .form-check {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-bottom: 0.5rem;
    transition: border-color 0.2s;
}
.pricing-tiers .form-check-input:checked + .form-check-label {
    color: #007bff;
}
.pricing-tiers .form-check:hover {
    border-color: #007bff;
}
.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
}
.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script>
function changeMainImage(src) {
    document.querySelector('.product-gallery-main img').src = src;
    document.querySelectorAll('.thumbnail-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');
}

function initiatePurchase() {
    const selectedLicense = document.querySelector('input[name="license_type"]:checked').value;
    window.location.href = '{{ route("products.checkout", $product) }}?license_type=' + selectedLicense;
}

function addToCart() {
    const selectedLicense = document.querySelector('input[name="license_type"]:checked').value;
    const productId = {{ $product->id }};

    fetch('{{ route("products.add-to-cart") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            license_type: selectedLicense
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart successfully!');
            // You could update a cart counter here if you have one
        } else {
            alert('Error: ' + (data.error || 'Failed to add to cart'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add to cart. Please try again.');
    });
}
</script>
@endpush
@endsection