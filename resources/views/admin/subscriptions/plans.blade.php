@extends('layouts.admin')

@section('title', 'Subscription Plans Management')
@section('page-title', 'Subscription Plans Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Subscription Plans</h1>
        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create New Plan
        </a>
    </div>

    <!-- Plans Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Billing Period</th>
                            <th>Status</th>
                            <th>Max Bids</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>#{{ $plan->id }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $plan->plan_type === 'freelancer' ? 'info' : ($plan->plan_type === 'spm' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($plan->plan_type) }}
                                    </span>
                                </td>
                                <td>${{ number_format($plan->price, 2) }}</td>
                                <td>{{ ucfirst($plan->billing_period) }}</td>
                                <td>
                                    <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $plan->max_bids ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No subscription plans found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection