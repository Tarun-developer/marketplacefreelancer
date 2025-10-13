@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('spm.index') }}">My Projects</a></li>
                    <li class="breadcrumb-item active">{{ $project->title }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>{{ $project->title }}</h3>
                    <div>
                        @if($project->client_id == Auth::id())
                        <a href="{{ route('spm.edit', $project) }}" class="btn btn-outline-secondary btn-sm">Edit Project</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Project Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Project Number</th>
                                    <td>{{ $project->project_number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $project->client_id == Auth::id() ? 'Freelancer' : 'Client' }}</th>
                                    <td>{{ $project->client_id == Auth::id() ? ($project->freelancer->name ?? 'Unassigned') : ($project->client->name ?? 'N/A') }}</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td>${{ number_format($project->budget, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'warning') }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Progress</th>
                                    <td>{{ $project->progress_percentage }}%</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th>Deadline</th>
                                    <td>{{ $project->deadline ? $project->deadline->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                            </table>

                            <h5>Description</h5>
                            <p>{{ $project->description }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Quick Actions</h5>
                            <button class="btn btn-outline-primary btn-block mb-2">Add Task</button>
                            <button class="btn btn-outline-secondary btn-block mb-2">Add Milestone</button>
                            <button class="btn btn-outline-info btn-block mb-2">Log Time</button>
                            <button class="btn btn-outline-success btn-block mb-2">Upload File</button>
                        </div>
                    </div>

                    @if($project->tasks->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Tasks ({{ $project->tasks->count() }})</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Assigned To</th>
                                            <th>Due Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ ucfirst($task->status) }}</td>
                                            <td>{{ ucfirst($task->priority) }}</td>
                                            <td>{{ $task->assignedTo->name ?? 'Unassigned' }}</td>
                                            <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">View</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection