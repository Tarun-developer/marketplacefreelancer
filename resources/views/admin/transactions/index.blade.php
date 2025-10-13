@extends('layouts.admin')

@section('title', 'Transactions Management')
@section('page-title', 'Transactions Management')

@section('content')
<div class="container-fluid">
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.transactions.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" placeholder="Search transactions..." value="{{ request('search') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Transactions</h6>
                    <h3 class="mt-2">{{ $transactions->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Completed</h6>
                    <h3 class="mt-2 text-success">{{ \App\Modules\Wallet\Models\WalletTransaction::where('status', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Pending</h6>
                    <h3 class="mt-2 text-warning">{{ \App\Modules\Wallet\Models\WalletTransaction::where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Failed</h6>
                    <h3 class="mt-2 text-danger">{{ \App\Modules\Wallet\Models\WalletTransaction::where('status', 'failed')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>ID</th>
                             <th>User</th>
                             <th>Amount</th>
                             <th>Currency</th>
                             <th>Status</th>
                             <th>Type</th>
                             <th>Description</th>
                             <th>Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse($transactions as $transaction)
                             <tr>
                                 <td>#{{ $transaction->id }}</td>
                                 <td>{{ $transaction->wallet->user->name }}</td>
                                 <td>${{ number_format($transaction->amount, 2) }}</td>
                                 <td>{{ $transaction->currency }}</td>
                                 <td>
                                     <span class="badge @if($transaction->status === 'completed') bg-success @elseif($transaction->status === 'pending') bg-warning @elseif($transaction->status === 'failed') bg-danger @else bg-info @endif">
                                         {{ ucfirst($transaction->status) }}
                                     </span>
                                 </td>
                                 <td>
                                     <span class="badge {{ $transaction->type === 'credit' ? 'bg-primary' : 'bg-secondary' }}">
                                         {{ ucfirst($transaction->type) }}
                                     </span>
                                 </td>
                                 <td>{{ $transaction->description ?? 'N/A' }}</td>
                                 <td>
                                     <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-primary">View</a>
                                     @if($transaction->status === 'pending')
                                         <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="d-inline">
                                             @csrf
                                             <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                         </form>
                                         <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="d-inline">
                                             @csrf
                                             <input type="hidden" name="rejection_reason" value="Rejected by admin">
                                             <button type="submit" class="btn btn-sm btn-warning">Reject</button>
                                         </form>
                                     @endif
                                 </td>
                             </tr>
                         @empty
                             <tr>
                                 <td colspan="8" class="text-center text-muted py-4">No transactions found</td>
                             </tr>
                         @endforelse
                     </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection