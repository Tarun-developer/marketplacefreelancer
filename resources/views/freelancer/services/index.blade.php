@extends('layouts.freelancer')

@section('title', 'My Services')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Services</h1>
                <a href="{{ route('freelancer.services.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Service
                </a>
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
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>
                                            <strong>{{ $service->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                        </td>
                                        <td>{{ $service->category->name ?? 'N/A' }}</td>
                                        <td>
                                            ${{ number_format($service->price, 2) }} {{ $service->currency }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $service->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('freelancer.services.show', $service) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('freelancer.services.edit', $service) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                            <form action="{{ route('freelancer.services.destroy', $service) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this service?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-3">No services found.</p>
                                            <a href="{{ route('freelancer.services.create') }}" class="btn btn-primary">Create Your First Service</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($services->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $services->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection