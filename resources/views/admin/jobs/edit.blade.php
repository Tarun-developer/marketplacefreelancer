@extends('layouts.admin')

@section('title', 'Edit Job')

@section('page-title', 'Edit Job')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Edit Job</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $job->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $job->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="budget_min" class="form-label">Min Budget</label>
                        <input type="number" class="form-control" id="budget_min" name="budget_min" value="{{ $job->budget_min }}" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="budget_max" class="form-label">Max Budget</label>
                        <input type="number" class="form-control" id="budget_max" name="budget_max" value="{{ $job->budget_max }}" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="open" {{ $job->status == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ $job->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="in_progress" {{ $job->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $job->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Job</button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection