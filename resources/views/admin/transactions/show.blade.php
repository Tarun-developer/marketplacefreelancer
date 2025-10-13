@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('page-title', 'Transaction Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Transaction #{{ $transaction->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>User:</strong></div>
                    <div class="col-sm-9">{{ $transaction->wallet->user->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Amount:</strong></div>
                    <div class="col-sm-9">${{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Type:</strong></div>
                    <div class="col-sm-9">{{ ucfirst($transaction->type) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge @if($transaction->status === 'completed') bg-success @elseif($transaction->status === 'pending') bg-warning @elseif($transaction->status === 'failed') bg-danger @else bg-info @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Description:</strong></div>
                    <div class="col-sm-9">{{ $transaction->description ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Created At:</strong></div>
                    <div class="col-sm-9">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                @if($transaction->status === 'pending')
                    <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="d-block mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Approve</button>
                    </form>
                    <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="d-block">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="rejection_reason" placeholder="Reason" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Reject</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection