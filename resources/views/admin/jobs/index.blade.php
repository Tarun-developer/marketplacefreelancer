@extends('layouts.admin')

@section('title', 'Jobs Management')
@section('page-title', 'Jobs Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jobs.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search jobs..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Jobs</h6>
                    <h3 class="mt-2">{{ $jobs->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Open</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Jobs\Models\Job::where('status', 'open')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">In Progress</h6>
                    <h3 class="mt-2 text-warning">{{ \App\Modules\Jobs\Models\Job::where('status', 'in_progress')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Completed</h6>
                    <h3 class="mt-2 text-info">{{ \App\Modules\Jobs\Models\Job::where('status', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Budget</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr>
                                <td>#{{ $job->id }}</td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($job->title, 40) }}</div>
                                    <small class="text-muted">{{ Str::limit($job->description, 60) }}</small>
                                </td>
                                 <td>{{ $job->client->name }}</td>
                                <td>${{ number_format($job->budget_min, 2) }} - ${{ number_format($job->budget_max, 2) }}</td>
                                <td>{{ $job->duration }} days</td>
                                <td>
                                    <span class="badge @if($job->status === 'open') bg-success @elseif($job->status === 'in_progress') bg-warning @elseif($job->status === 'completed') bg-info @else bg-danger @endif">
                                        {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this job?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No jobs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="mt-3">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection