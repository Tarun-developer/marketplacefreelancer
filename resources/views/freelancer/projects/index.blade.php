@extends('layouts.freelancer')

@section('title', 'My Projects')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Projects</h1>
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
                                    <th>Project Name</th>
                                    <th>Client</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Start Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                    <tr>
                                        <td>
                                            <strong>{{ $project->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                        </td>
                                        <td>{{ $project->client->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="width: 100px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $project->progress ?? 0 }}%" aria-valuenow="{{ $project->progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <small>{{ $project->progress ?? 0 }}%</small>
                                        </td>
                                        <td>{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('freelancer.projects.show', $project) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-3">No projects found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($projects->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $projects->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection