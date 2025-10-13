@extends('layouts.admin')

@section('title', 'Services Management')
@section('page-title', 'Services Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.services.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search services..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Services</h6>
                    <h3 class="mt-2">{{ $services->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Active</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Services\Models\Service::where('status', 'active')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Inactive</h6>
                    <h3 class="mt-2 text-warning">{{ \App\Modules\Services\Models\Service::where('status', 'inactive')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Suspended</h6>
                    <h3 class="mt-2 text-danger">{{ \App\Modules\Services\Models\Service::where('status', 'suspended')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Freelancer</th>
                            <th>Price</th>
                            <th>Delivery</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>#{{ $service->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($service->title, 40) }}</div>
                                    <small class="text-muted">{{ Str::limit($service->description, 60) }}</small>
                                </td>
                                <td>{{ $service->user->name }}</td>
                                <td>${{ number_format($service->price, 2) }}</td>
                                <td>{{ $service->delivery_time }} days</td>
                                <td>
                                    <span class="badge @if($service->status === 'active') bg-success @elseif($service->status === 'inactive') bg-warning @else bg-danger @endif">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>

                                    @if($service->status !== 'active')
                                        <form action="{{ route('admin.services.approve', $service) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif

                                    @if($service->status !== 'suspended')
                                        <form action="{{ route('admin.services.suspend', $service) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to suspend this service?')">
                                                Suspend
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No services found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($services->hasPages())
                <div class="mt-3">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
