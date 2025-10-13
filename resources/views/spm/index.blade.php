@extends('layouts.app')

@section('title', 'My SPM Projects')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>My SPM Projects</h2>
                @if(Auth::user()->has_spm_access)
                <a href="{{ route('spm.create') }}" class="btn btn-primary">Create New Project</a>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    You need SPM access to create projects. <a href="{{ route('spm.subscriptions.index') }}">Subscribe now</a>
                </div>
                @endif
            </div>

            @if($projects->count() > 0)
            <div class="row">
                @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                            <p class="text-muted">Project #{{ $project->project_number }}</p>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                                <small>{{ $project->progress_percentage }}% Complete</small>
                            </div>

                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $project->progress_percentage }}%" aria-valuenow="{{ $project->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Budget: ${{ number_format($project->budget, 2) }}</small>
                                <small class="text-muted">{{ $project->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('spm.show', $project) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                            @if($project->client_id == Auth::id())
                            <a href="{{ route('spm.edit', $project) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-folder-open display-4 text-muted mb-3"></i>
                <h4>No Projects Yet</h4>
                <p class="text-muted">You haven't created any SPM projects yet. Create your first project to get started!</p>
                @if(Auth::user()->has_spm_access)
                <a href="{{ route('spm.create') }}" class="btn btn-primary">Create Your First Project</a>
                @else
                <a href="{{ route('spm.subscriptions.index') }}" class="btn btn-primary">Subscribe to SPM</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection