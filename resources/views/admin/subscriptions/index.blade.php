@extends('layouts.admin')

@section('title', 'Subscriptions Management')
@section('page-title', 'Subscriptions Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search subscriptions..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Subscriptions</h6>
                    <h3 class="mt-2">{{ $subscriptions->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Active</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Subscriptions\Models\Subscription::where('status', 'active')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Cancelled</h6>
                    <h3 class="mt-2 text-warning">{{ \App\Modules\Subscriptions\Models\Subscription::where('status', 'cancelled')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Expired</h6>
                    <h3 class="mt-2 text-danger">{{ \App\Modules\Subscriptions\Models\Subscription::where('status', 'expired')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Ends At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>#{{ $subscription->id }}</td>
                                <td>{{ $subscription->user->name }}</td>
                                <td>{{ $subscription->subscriptionPlan->name }}</td>
                                <td>
                                    <span class="badge @if($subscription->status === 'active') bg-success @elseif($subscription->status === 'cancelled') bg-warning @else bg-danger @endif">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge @if($subscription->payment_status === 'paid') bg-success @elseif($subscription->payment_status === 'pending') bg-warning @else bg-danger @endif">
                                        {{ ucfirst($subscription->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $subscription->ends_at ? $subscription->ends_at->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subscription?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No subscriptions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($subscriptions->hasPages())
                <div class="mt-3">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection