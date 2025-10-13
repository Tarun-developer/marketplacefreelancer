@extends('layouts.vendor')

@section('title', 'My Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Products</h1>
                <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Add New Product</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ ucfirst($product->product_type) }} • v{{ $product->version }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($product->standard_price)
                                                <div>Standard: ${{ number_format($product->standard_price, 2) }}</div>
                                            @endif
                                            @if($product->professional_price)
                                                <div>Pro: ${{ number_format($product->professional_price, 2) }}</div>
                                            @endif
                                            @if($product->ultimate_price)
                                                <div>Ultimate: ${{ number_format($product->ultimate_price, 2) }}</div>
                                            @endif
                                            @if($product->is_free)
                                                <span class="badge bg-success">FREE</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                            @if($product->is_approved)
                                                <br><small class="text-success">✓ Approved</small>
                                            @else
                                                <br><small class="text-warning">⏳ Pending</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('vendor.products.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <form action="{{ route('vendor.products.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-3">No products found.</p>
                                            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Create Your First Product</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection