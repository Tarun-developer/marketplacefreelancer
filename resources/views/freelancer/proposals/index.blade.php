@extends('layouts.freelancer')

@section('title', 'My Proposals')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Proposals</h1>
                <div class="text-end">
                    <p class="mb-1">Bids Used: {{ auth()->user()->bids_used_this_month }} / {{ auth()->user()->getBidLimit() }}</p>
                    <a href="{{ route('freelancer.buy-bids') }}" class="btn btn-sm btn-outline-primary">Buy Extra Bids</a>
                </div>
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
                                    <th>Job Title</th>
                                    <th>Proposal</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($proposals as $proposal)
                                    <tr>
                                        <td>
                                            <strong>{{ $proposal->job->title ?? 'N/A' }}</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($proposal->proposal, 50) }}</small>
                                        </td>
                                        <td>
                                            ${{ number_format($proposal->price, 2) }} {{ $proposal->currency }}
                                        </td>
                                        <td>{{ $proposal->duration }} days</td>
                                        <td>
                                            <span class="badge bg-{{ $proposal->status == 'accepted' ? 'success' : ($proposal->status == 'rejected' ? 'danger' : 'secondary') }}">
                                                {{ ucfirst($proposal->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('freelancer.proposals.show', $proposal) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-muted mb-3">No proposals found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($proposals->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $proposals->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection