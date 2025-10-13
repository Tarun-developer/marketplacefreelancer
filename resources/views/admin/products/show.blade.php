@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Product: {{ $product->name }}</h4>
                    <div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">Edit Product</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back to Products</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Product Information -->
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Product Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Type</th>
                                                    <td><span class="badge bg-info">{{ ucfirst($product->product_type ?? 'script') }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Category</th>
                                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Vendor</th>
                                                    <td>{{ $product->user->name ?? 'N/A' }} ({{ $product->user->email }})</td>
                                                </tr>
                                                <tr>
                                                    <th>Version</th>
                                                    <td>{{ $product->version ?? '1.0.0' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><span class="badge bg-{{ $product->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($product->status) }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Approval</th>
                                                    <td><span class="badge bg-{{ $product->is_approved ? 'success' : 'warning' }}">{{ $product->is_approved ? 'Approved' : 'Pending' }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Sales Count</th>
                                                    <td>{{ $product->sales_count ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Downloads</th>
                                                    <td>{{ $product->download_count ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Views</th>
                                                    <td>{{ $product->views_count ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Created</th>
                                                    <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    @if($product->short_description)
                                        <h6>Short Description</h6>
                                        <p>{{ $product->short_description }}</p>
                                    @endif

                                    <h6>Description</h6>
                                    <div class="border p-3 bg-light">
                                        {!! nl2br(e($product->description)) !!}
                                    </div>

                                    @if($product->tags && count($product->tags) > 0)
                                        <h6 class="mt-3">Tags</h6>
                                        <div>
                                            @foreach($product->tags as $tag)
                                                <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Pricing Information -->
                            <div class="card border-success mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Pricing & Licensing</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h6>Standard License</h6>
                                            <p class="h4 text-success">${{ number_format($product->standard_price ?? $product->price, 2) }}</p>
                                        </div>
                                        @if($product->professional_price)
                                            <div class="col-md-4">
                                                <h6>Professional License</h6>
                                                <p class="h4 text-primary">${{ number_format($product->professional_price, 2) }}</p>
                                            </div>
                                        @endif
                                        @if($product->ultimate_price)
                                            <div class="col-md-4">
                                                <h6>Ultimate License</h6>
                                                <p class="h4 text-warning">${{ number_format($product->ultimate_price, 2) }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($product->discount_percentage > 0)
                                        <div class="alert alert-info">
                                            <strong>Discount: {{ $product->discount_percentage }}%</strong>
                                        </div>
                                    @endif

                                    @if($product->is_free)
                                        <div class="alert alert-success">
                                            <strong>This product is FREE!</strong>
                                        </div>
                                    @endif

                                    @if($product->money_back_guarantee)
                                        <div class="alert alert-info">
                                            <strong>Money Back Guarantee: {{ $product->refund_days }} days</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Media Gallery -->
                            @if($product->thumbnail || ($product->screenshots && count($product->screenshots) > 0))
                                <div class="card border-info mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Media Gallery</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($product->thumbnail)
                                            <h6>Thumbnail</h6>
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 200px;">
                                        @endif

                                        @if($product->screenshots && count($product->screenshots) > 0)
                                            <h6>Screenshots ({{ count($product->screenshots) }})</h6>
                                            <div class="row">
                                                @foreach($product->screenshots as $screenshot)
                                                    <div class="col-md-4 mb-3">
                                                        <img src="{{ asset('storage/' . $screenshot) }}" alt="Screenshot" class="img-fluid rounded" style="max-height: 150px;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Version History -->
                            @if($product->versions && $product->versions->count() > 0)
                                <div class="card border-warning mb-4">
                                    <div class="card-header bg-warning">
                                        <h5 class="mb-0">Version History</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Version</th>
                                                        <th>Release Date</th>
                                                        <th>File Size</th>
                                                        <th>Downloads</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->versions as $version)
                                                        <tr>
                                                            <td>{{ $version->version_number }}</td>
                                                            <td>{{ $version->release_date->format('M d, Y') }}</td>
                                                            <td>{{ number_format($version->file_size / 1024 / 1024, 2) }} MB</td>
                                                            <td>{{ $version->download_count }}</td>
                                                            <td>
                                                                @if($version->is_active)
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Inactive</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Licenses -->
                            @if($product->licenses && $product->licenses->count() > 0)
                                <div class="card border-dark mb-4">
                                    <div class="card-header bg-dark text-white">
                                        <h5 class="mb-0">Licenses ({{ $product->licenses->count() }})</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>License Key</th>
                                                        <th>Buyer</th>
                                                        <th>Type</th>
                                                        <th>Activations</th>
                                                        <th>Status</th>
                                                        <th>Expires</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->licenses as $license)
                                                        <tr>
                                                            <td><code>{{ $license->license_key }}</code></td>
                                                            <td>{{ $license->buyer->name ?? 'N/A' }}</td>
                                                            <td><span class="badge bg-primary">{{ ucfirst($license->license_type) }}</span></td>
                                                            <td>{{ $license->activations_used }} / {{ $license->activation_limit }}</td>
                                                            <td><span class="badge bg-{{ $license->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($license->status) }}</span></td>
                                                            <td>{{ $license->expires_at ? $license->expires_at->format('M d, Y') : 'Never' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    @if($product->is_approved)
                                        <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="mb-3">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm w-100" onclick="return confirm('Are you sure you want to reject this product?')">Reject Product</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="mb-3">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">Approve Product</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm w-100 mb-2">Edit Product</a>

                                    <button class="btn btn-info btn-sm w-100 mb-2" onclick="viewProductPage()">View Public Page</button>

                                    <button class="btn btn-outline-primary btn-sm w-100" onclick="exportProductData()">Export Data</button>
                                </div>
                            </div>

                            <!-- Product Stats -->
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-primary">{{ $product->sales_count ?? 0 }}</h4>
                                            <small>Sales</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-success">{{ $product->download_count ?? 0 }}</h4>
                                            <small>Downloads</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4 class="text-info">{{ $product->views_count ?? 0 }}</h4>
                                            <small>Views</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-warning">{{ $product->reviews->count() ?? 0 }}</h4>
                                            <small>Reviews</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function viewProductPage() {
    // Open product public page in new tab
    window.open('/products/{{ $product->slug }}', '_blank');
}

function exportProductData() {
    // Implement export functionality
    alert('Export functionality coming soon!');
}
</script>
@endpush
@endsection