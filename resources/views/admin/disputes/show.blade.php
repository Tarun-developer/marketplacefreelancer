@extends('layouts.admin')

@section('title', 'Dispute Details')

@section('page-title', 'Dispute Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Dispute #{{ $dispute->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Order:</strong></div>
                    <div class="col-sm-9">#{{ $dispute->order->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Raised By:</strong></div>
                    <div class="col-sm-9">{{ $dispute->raisedBy->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Reason:</strong></div>
                    <div class="col-sm-9">{{ ucfirst($dispute->reason) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Description:</strong></div>
                    <div class="col-sm-9">{{ $dispute->description }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge @if($dispute->status === 'open') bg-warning @elseif($dispute->status === 'in_progress') bg-info @elseif($dispute->status === 'resolved') bg-success @else bg-secondary @endif">
                            {{ ucfirst(str_replace('_', ' ', $dispute->status)) }}
                        </span>
                    </div>
                </div>
                @if($dispute->resolved_at)
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Resolved At:</strong></div>
                    <div class="col-sm-9">{{ $dispute->resolved_at->format('Y-m-d H:i:s') }}</div>
                </div>
                @endif
                @if($dispute->resolution)
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Resolution:</strong></div>
                    <div class="col-sm-9">{{ ucfirst(str_replace('_', ' ', $dispute->resolution)) }}</div>
                </div>
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
                <a href="{{ route('admin.disputes.edit', $dispute) }}" class="btn btn-primary">Edit Dispute</a>
                <form action="{{ route('admin.disputes.resolve', $dispute) }}" method="POST" class="mt-2">
                    @csrf
                    <div class="mb-2">
                        <select name="resolution" class="form-select" required>
                            <option value="">Select Resolution</option>
                            <option value="favor_buyer">Favor Buyer</option>
                            <option value="favor_seller">Favor Seller</option>
                            <option value="partial_refund">Partial Refund</option>
                            <option value="no_action">No Action</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <textarea name="resolution_notes" class="form-control" placeholder="Resolution Notes" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Resolve Dispute</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection