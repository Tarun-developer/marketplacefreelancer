@extends('layouts.admin')

@section('title', 'Users Management')
@section('page-title', 'Users Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
                        <option value="freelancer" {{ request('role') === 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                        <option value="vendor" {{ request('role') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                     <select name="is_active" class="form-select">
                         <option value="">All Status</option>
                         <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                         <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Suspended</option>
                     </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Users</h6>
                    <h3 class="mt-2">{{ $users->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Active</h6>
                    <h3 class="mt-2 text-success">{{ \App\Models\User::where('is_active', true)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Suspended</h6>
                     <h3 class="mt-2 text-warning">{{ \App\Models\User::where('is_active', false)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Banned</h6>
                    <h3 class="mt-2 text-danger">{{ \App\Models\User::where('status', 'banned')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') ?: asset('images/default-avatar.png') }}"
                                             alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            @if($user->profile)
                                                <small class="text-muted">{{ $user->profile->title ?? 'No title' }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                     <span class="badge @if($user->is_active) bg-success @else bg-danger @endif">
                                         {{ $user->is_active ? 'Active' : 'Suspended' }}
                                     </span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-primary" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('messages.start', $user->id) }}" class="btn btn-sm btn-info" title="Chat with User">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit User">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if($user->is_active)
                                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to suspend this user?')">
                                                Suspend
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection