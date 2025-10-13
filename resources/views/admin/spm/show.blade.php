@extends('layouts.admin')

@section('title', 'SPM Project Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Project: {{ $project->title }}</h4>
                    <p class="card-title-desc">Project #{{ $project->project_number }}</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Project Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Client</th>
                                    <td>{{ $project->client->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Freelancer</th>
                                    <td>{{ $project->freelancer->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Budget</th>
                                    <td>${{ number_format($project->budget, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Paid Amount</th>
                                    <td>${{ number_format($project->paid_amount, 2) }}</td>
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
                            <a href="{{ route('admin.spm.edit', $project) }}" class="btn btn-primary btn-block">Edit Project</a>
                            <button class="btn btn-secondary btn-block">View Tasks</button>
                            <button class="btn btn-secondary btn-block">View Milestones</button>
                            <button class="btn btn-secondary btn-block">View Timesheets</button>
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
                                            <th>Assigned To</th>
                                            <th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ ucfirst($task->status) }}</td>
                                            <td>{{ $task->assignedTo->name ?? 'Unassigned' }}</td>
                                            <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</td>
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