@extends('layouts.admin')

@section('title', 'Disputes Management')
@section('page-title', 'Disputes Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.disputes.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search disputes..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.disputes.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Disputes</h6>
                    <h3 class="mt-2">{{ $disputes->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Open</h6>
                    <h3 class="mt-2 text-warning">{{ \App\Modules\Disputes\Models\Dispute::where('status', 'open')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Resolved</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Disputes\Models\Dispute::where('status', 'resolved')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Closed</h6>
                    <h3 class="mt-2 text-info">{{ \App\Modules\Disputes\Models\Dispute::where('status', 'closed')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Disputes Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order</th>
                            <th>Raised By</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disputes as $dispute)
                            <tr>
                                <td>#{{ $dispute->id }}</td>
                                <td>#{{ $dispute->order->id }}</td>
                                <td>{{ $dispute->raisedBy->name }}</td>
                                <td>{{ ucfirst($dispute->reason) }}</td>
                                <td>
                                    <span class="badge @if($dispute->status === 'open') bg-warning @elseif($dispute->status === 'in_progress') bg-info @elseif($dispute->status === 'resolved') bg-success @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $dispute->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.disputes.show', $dispute) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.disputes.edit', $dispute) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.disputes.destroy', $dispute) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this dispute?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No disputes found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($disputes->hasPages())
                <div class="mt-3">
                    {{ $disputes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection