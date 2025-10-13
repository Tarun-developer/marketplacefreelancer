@extends('layouts.vendor')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    <div>
                        <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-primary btn-sm">Back to Products</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Product Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $product->is_approved ? 'success' : 'warning' }}">
                                            {{ $product->is_approved ? 'Approved' : 'Pending Approval' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Downloads</th>
                                    <td>{{ $product->download_count }}</td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>

                            <h5>Description</h5>
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Quick Actions</h5>
                            <button class="btn btn-outline-primary btn-block mb-2">Upload Files</button>
                            <button class="btn btn-outline-secondary btn-block mb-2">View Sales</button>
                            <button class="btn btn-outline-info btn-block mb-2">Product Analytics</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection