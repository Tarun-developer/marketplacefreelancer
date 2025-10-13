@extends('layouts.app')

@section('title', 'Edit SPM Project')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Project: {{ $project->title }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('spm.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="title">Project Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="budget">Budget ($)</label>
                                    <input type="number" name="budget" id="budget" class="form-control" step="0.01" min="0" value="{{ old('budget', $project->budget) }}" required>
                                    @error('budget')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="deadline">Deadline</label>
                                    <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" required>
                                    @error('deadline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Project</button>
                            <a href="{{ route('spm.show', $project) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection