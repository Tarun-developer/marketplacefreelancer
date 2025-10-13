@extends('layouts.admin')

@section('title', 'Edit Dispute')

@section('page-title', 'Edit Dispute')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Edit Dispute #{{ $dispute->id }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.disputes.update', $dispute) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="open" {{ $dispute->status == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ $dispute->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $dispute->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $dispute->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="resolution" class="form-label">Resolution</label>
                        <select class="form-control" id="resolution" name="resolution">
                            <option value="">Select Resolution</option>
                            <option value="favor_buyer" {{ $dispute->resolution == 'favor_buyer' ? 'selected' : '' }}>Favor Buyer</option>
                            <option value="favor_seller" {{ $dispute->resolution == 'favor_seller' ? 'selected' : '' }}>Favor Seller</option>
                            <option value="partial_refund" {{ $dispute->resolution == 'partial_refund' ? 'selected' : '' }}>Partial Refund</option>
                            <option value="no_action" {{ $dispute->resolution == 'no_action' ? 'selected' : '' }}>No Action</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="resolution_notes" class="form-label">Resolution Notes</label>
                        <textarea class="form-control" id="resolution_notes" name="resolution_notes" rows="3">{{ $dispute->resolution_notes ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Dispute</button>
                    <a href="{{ route('admin.disputes.show', $dispute) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection