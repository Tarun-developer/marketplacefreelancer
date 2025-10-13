@extends('layouts.admin')

@section('title', 'SPM Projects Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SPM Projects</h4>
                    <p class="card-title-desc">Manage all SPM projects in the system</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Project #</th>
                                    <th>Title</th>
                                    <th>Client</th>
                                    <th>Freelancer</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                <tr>
                                    <td>{{ $project->project_number }}</td>
                                    <td>{{ Str::limit($project->title, 50) }}</td>
                                    <td>{{ $project->client->name ?? 'N/A' }}</td>
                                    <td>{{ $project->freelancer->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($project->budget, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'warning') }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $project->progress_percentage }}%" aria-valuenow="{{ $project->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        {{ $project->progress_percentage }}%
                                    </td>
                                    <td>{{ $project->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.spm.show', $project) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="{{ route('admin.spm.edit', $project) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <form action="{{ route('admin.spm.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No projects found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection