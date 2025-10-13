@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
    <div class="container-fluid">
        <h1 class="h4 mb-4">User Details</h1>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Basic Information</h5>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Role:</strong> {{ $user->getRoleNames()->first() ?? 'N/A' }}</p>
                        <p><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                        <p><strong>Last Updated:</strong> {{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Profile Information</h5>
                        @if($user->profile)
                            <p><strong>Bio:</strong> {{ $user->profile->bio ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $user->profile->phone ?? 'N/A' }}</p>
                            <p><strong>Address:</strong> {{ $user->profile->address ?? 'N/A' }}</p>
                        @else
                            <p>No profile information available.</p>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit User</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
@endsection