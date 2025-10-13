@extends('layouts.admin')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Basic Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Description:</strong></td>
                                    <td>{{ $product->description }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Version:</strong></td>
                                    <td>{{ $product->version ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>License:</strong></td>
                                    <td>{{ ucfirst($product->license_type ?? 'regular') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Compatibility:</strong></td>
                                    <td>{{ $product->compatibility ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Additional Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Vendor:</strong></td>
                                    <td>{{ $product->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($product->is_approved ?? true)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sales Count:</strong></td>
                                    <td>{{ $product->sales_count ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Downloads:</strong></td>
                                    <td>{{ $product->download_count ?? 0 }}</td>
                                </tr>
                                @if($product->demo_url)
                                    <tr>
                                        <td><strong>Demo:</strong></td>
                                        <td><a href="{{ $product->demo_url }}" target="_blank" class="btn btn-sm btn-outline-primary">View Demo</a></td>
                                    </tr>
                                @endif
                                @if($product->tags)
                                    <tr>
                                        <td><strong>Tags:</strong></td>
                                        <td>
                                            @foreach($product->tags as $tag)
                                                <span class="badge bg-secondary">{{ $tag }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($product->media->count() > 0)
                        <div class="mt-4">
                            <h6 class="text-muted">Preview Images</h6>
                            <div class="row">
                                @foreach($product->media as $media)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ $media->getUrl('thumb') }}" class="img-fluid rounded" alt="Preview">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">Edit Product</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!($product->is_approved ?? true))
                            <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Approve Product</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.products.feature', $product) }}" class="btn btn-info w-100">Feature Product</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Delete Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection