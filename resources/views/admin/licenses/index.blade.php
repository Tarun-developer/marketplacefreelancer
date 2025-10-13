@extends('layouts.admin')

@section('title', 'License Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">License Management</h4>
                    <a href="{{ route('admin.licenses.generate-manual') }}" class="btn btn-primary">Generate Manual License</a>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="revoked" {{ request('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="license_type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="standard" {{ request('license_type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="professional" {{ request('license_type') == 'professional' ? 'selected' : '' }}>Professional</option>
                                    <option value="ultimate" {{ request('license_type') == 'ultimate' ? 'selected' : '' }}>Ultimate</option>
                                    <option value="custom" {{ request('license_type') == 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by license key or buyer" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-secondary">Filter</button>
                                <a href="{{ route('admin.licenses.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>License Key</th>
                                    <th>Product</th>
                                    <th>Buyer</th>
                                    <th>Type</th>
                                    <th>Activations</th>
                                    <th>Status</th>
                                    <th>Expires</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($licenses as $license)
                                    <tr>
                                        <td>
                                            <code>{{ $license->license_key }}</code>
                                            <br>
                                            <small class="text-muted">Issued: {{ $license->issued_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>{{ $license->product->name ?? 'N/A' }}</td>
                                        <td>{{ $license->buyer->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $license->license_type == 'ultimate' ? 'success' : ($license->license_type == 'professional' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($license->license_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $license->activations_used }} / {{ $license->activation_limit }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $license->status == 'active' ? 'success' : ($license->status == 'expired' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($license->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $license->expires_at ? $license->expires_at->format('M d, Y') : 'Never' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.licenses.show', $license) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            @if($license->status == 'active')
                                                <form action="{{ route('admin.licenses.revoke', $license) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to revoke this license?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Revoke</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-muted mb-3">No licenses found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $licenses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection