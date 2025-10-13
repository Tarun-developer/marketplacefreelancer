@extends('layouts.admin')

@section('title', 'Job Details')

@section('page-title', 'Job Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>{{ $job->title }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Description:</strong></p>
                <p>{{ $job->description }}</p>
                <p><strong>Budget:</strong> ${{ $job->budget_min }} - ${{ $job->budget_max }}</p>
                <p><strong>Status:</strong> <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">{{ ucfirst($job->status) }}</span></p>
                <p><strong>Posted by:</strong> {{ $job->client->name }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6>Bids ({{ $job->bids->count() }})</h6>
            </div>
            <div class="card-body">
                @if($job->bids->count() > 0)
                    @foreach($job->bids as $bid)
                        <div class="border-bottom pb-2 mb-2">
                            <p><strong>{{ $bid->user->name }}</strong> - ${{ $bid->price }}</p>
                            <p>{{ $bid->proposal }}</p>
                        </div>
                    @endforeach
                @else
                    <p>No bids yet.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-primary">Edit Job</a>
                <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Job</button>
                </form>
                @if($job->status == 'open')
                    <form action="{{ route('admin.jobs.close', $job) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">Close Job</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection