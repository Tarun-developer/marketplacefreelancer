@extends('layouts.freelancer')

@section('title', 'Available Jobs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Available Jobs</h1>
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
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Budget</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td>
                                            <strong>{{ $job->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($job->description, 50) }}</small>
                                        </td>
                                        <td>{{ $job->category }}</td>
                                        <td>
                                            ${{ number_format($job->budget_min, 2) }} - ${{ number_format($job->budget_max, 2) }} {{ $job->currency }}
                                        </td>
                                        <td>{{ $job->duration }} days</td>
                                        <td>
                                            <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('freelancer.jobs.show', $job) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-3">No jobs available.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($jobs->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection