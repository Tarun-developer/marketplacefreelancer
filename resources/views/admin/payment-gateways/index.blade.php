@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Payment Gateways</h1>
            <p class="text-muted">Manage payment processors and their configurations</p>
        </div>
        <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Gateway
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded p-3">
                                <i class="fas fa-credit-card text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-0 small">Total Gateways</p>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <i class="fas fa-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-0 small">Active Gateways</p>
                            <h4 class="mb-0">{{ $stats['active'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <i class="fas fa-dollar-sign text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-0 small">Fiat</p>
                            <h4 class="mb-0">{{ $stats['fiat'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded p-3">
                                <i class="fab fa-bitcoin text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-0 small">Crypto</p>
                            <h4 class="mb-0">{{ $stats['crypto'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary bg-opacity-10 rounded p-3">
                                <i class="fas fa-wallet text-secondary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-0 small">Wallet</p>
                            <h4 class="mb-0">{{ $stats['wallet'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.payment-gateways.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search gateways..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="fiat" {{ request('type') == 'fiat' ? 'selected' : '' }}>Fiat</option>
                        <option value="crypto" {{ request('type') == 'crypto' ? 'selected' : '' }}>Crypto</option>
                        <option value="wallet" {{ request('type') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-5 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Gateways List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Gateway</th>
                            <th>Type</th>
                            <th>Currencies</th>
                            <th>Fees</th>
                            <th>Status</th>
                            <th>Mode</th>
                            <th>Stats</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gateways as $gateway)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($gateway->logo)
                                    <img src="{{ asset('images/gateways/' . $gateway->logo) }}" alt="{{ $gateway->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: contain;" onerror="this.style.display='none'">
                                    @endif
                                    <div>
                                        <strong class="d-block">{{ $gateway->name }}</strong>
                                        <small class="text-muted">{{ $gateway->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($gateway->type == 'fiat')
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-dollar-sign me-1"></i>Fiat
                                </span>
                                @elseif($gateway->type == 'crypto')
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="fab fa-bitcoin me-1"></i>Crypto
                                </span>
                                @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="fas fa-wallet me-1"></i>Wallet
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($gateway->supported_currencies ?? [], 0, 3) as $currency)
                                    <span class="badge bg-light text-dark">{{ $currency }}</span>
                                    @endforeach
                                    @if(count($gateway->supported_currencies ?? []) > 3)
                                    <span class="badge bg-light text-dark">+{{ count($gateway->supported_currencies) - 3 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <small>
                                    {{ $gateway->transaction_fee_percentage }}%
                                    @if($gateway->transaction_fee_fixed > 0)
                                    + {{ $gateway->transaction_fee_currency }} {{ number_format($gateway->transaction_fee_fixed, 2) }}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <form action="{{ route('admin.payment-gateways.toggle-status', $gateway) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-toggle {{ $gateway->is_active ? 'active' : '' }}" style="border: none; background: none;">
                                        @if($gateway->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        </span>
                                        @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle me-1"></i>Inactive
                                        </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.payment-gateways.toggle-test-mode', $gateway) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm" style="border: none; background: none;">
                                        @if($gateway->test_mode)
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="fas fa-flask me-1"></i>Test
                                        </span>
                                        @else
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-bolt me-1"></i>Live
                                        </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ number_format($gateway->total_transactions) }} txns<br>
                                    ${{ number_format($gateway->total_volume, 2) }}
                                </small>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.payment-gateways.show', $gateway) }}" class="btn btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payment-gateways.edit', $gateway) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($gateway->total_transactions == 0)
                                    <form action="{{ route('admin.payment-gateways.destroy', $gateway) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this gateway?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No payment gateways found</p>
                                <a href="{{ route('admin.payment-gateways.create') }}" class="btn btn-primary">Add Your First Gateway</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($gateways->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $gateways->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.btn-toggle:hover {
    opacity: 0.8;
}
</style>
@endpush
@endsection
