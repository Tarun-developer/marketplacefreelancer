@extends('layouts.admin')

@section('title', 'Reviews Management')
@section('page-title', 'Reviews Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search reviews..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="rating" class="form-select">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Reviews</h6>
                    <h3 class="mt-2">{{ $reviews->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Average Rating</h6>
                    <h3 class="mt-2">{{ number_format(\App\Modules\Reviews\Models\Review::avg('rating'), 1) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">5 Stars</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Reviews\Models\Review::where('rating', 5)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">1 Star</h6>
                    <h3 class="mt-2 text-danger">{{ \App\Modules\Reviews\Models\Review::where('rating', 1)->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reviewer</th>
                            <th>Reviewee</th>
                            <th>Order</th>
                            <th>Rating</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>#{{ $review->id }}</td>
                                <td>{{ $review->reviewer->name }}</td>
                                <td>{{ $review->reviewee->name }}</td>
                                <td>#{{ $review->order->id }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $review->rating }} Stars</span>
                                </td>
                                <td>{{ ucfirst($review->type) }}</td>
                                <td>
                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No reviews found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-3">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection