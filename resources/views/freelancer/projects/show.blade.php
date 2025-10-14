@extends('layouts.freelancer')

@section('title', $project->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('freelancer.projects.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>My Projects
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">{{ Str::limit($project->name, 30) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Project Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-project-diagram fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $project->name }}</h2>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>Client: {{ $project->client->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'primary' : 'secondary') }} me-2">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Description
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $project->description }}</p>
                                </div>
                            </div>

                            @if($project->tasks->count() > 0)
                                <div class="mt-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-tasks me-2 text-primary"></i>Tasks
                                    </h5>
                                    <div class="list-group">
                                        @foreach($project->tasks as $task)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $task->title }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                                </div>
                                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Project Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Project Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-calendar me-2"></i>Start Date:</span>
                                        <strong>{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-clock me-2"></i>End Date:</span>
                                        <strong>{{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-chart-line me-2"></i>Progress:</span>
                                        <strong>{{ $project->progress ?? 0 }}%</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-cogs me-2 text-primary"></i>Actions
                            </h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Update Progress
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-comments me-2"></i>View Comments
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection