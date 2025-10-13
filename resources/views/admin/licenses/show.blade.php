@extends('layouts.admin')

@section('title', 'License Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">License: {{ $license->license_key }}</h4>
                    <div>
                        <a href="{{ route('admin.licenses.index') }}" class="btn btn-secondary">Back to Licenses</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- License Information -->
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">License Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>License Key</th>
                                            <td><code>{{ $license->license_key }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Product</th>
                                            <td>{{ $license->product->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Buyer</th>
                                            <td>{{ $license->buyer->name ?? 'N/A' }} ({{ $license->buyer->email }})</td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td><span class="badge bg-primary">{{ ucfirst($license->license_type) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge bg-{{ $license->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($license->status) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Activations</th>
                                            <td>{{ $license->activations_used }} / {{ $license->activation_limit }}</td>
                                        </tr>
                                        <tr>
                                            <th>Issued</th>
                                            <td>{{ $license->issued_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Expires</th>
                                            <td>{{ $license->expires_at ? $license->expires_at->format('M d, Y H:i') : 'Never' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Activations -->
                            <div class="card border-info mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Activations ({{ $license->activations->count() }})</h5>
                                </div>
                                <div class="card-body">
                                    @if($license->activations->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Domain</th>
                                                        <th>IP Address</th>
                                                        <th>Activated</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($license->activations as $activation)
                                                        <tr>
                                                            <td>{{ $activation->domain ?? 'N/A' }}</td>
                                                            <td>{{ $activation->ip_address }}</td>
                                                            <td>{{ $activation->activated_at->format('M d, Y H:i') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $activation->status == 'active' ? 'success' : 'danger' }}">
                                                                    {{ ucfirst($activation->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No activations yet.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Activity Log -->
                            <div class="card border-warning mb-4">
                                <div class="card-header bg-warning">
                                    <h5 class="mb-0">Activity Log</h5>
                                </div>
                                <div class="card-body">
                                    @if($license->logs->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Message</th>
                                                        <th>Timestamp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($license->logs->take(10) as $log)
                                                        <tr>
                                                            <td>{{ $log->action }}</td>
                                                            <td>{{ $log->message }}</td>
                                                            <td>{{ $log->timestamp->format('M d, Y H:i') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No activity logs yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    @if($license->status == 'active')
                                        <form action="{{ route('admin.licenses.revoke', $license) }}" method="POST" class="mb-3">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <label for="reason" class="form-label">Revoke Reason</label>
                                                <textarea name="reason" id="reason" class="form-control form-control-sm" rows="2" placeholder="Reason for revocation"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to revoke this license?')">Revoke License</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.licenses.extend', $license) }}" method="POST" class="mb-3">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label for="expires_at" class="form-label">Extend Expiry</label>
                                            <input type="datetime-local" name="expires_at" id="expires_at" class="form-control form-control-sm" value="{{ $license->expires_at ? $license->expires_at->format('Y-m-d\TH:i') : '' }}">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm">Extend License</button>
                                    </form>

                                    <form action="{{ route('admin.licenses.change-limit', $license) }}" method="POST" class="mb-3">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label for="activation_limit" class="form-label">Change Activation Limit</label>
                                            <input type="number" name="activation_limit" id="activation_limit" class="form-control form-control-sm" min="1" value="{{ $license->activation_limit }}">
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-sm">Update Limit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection