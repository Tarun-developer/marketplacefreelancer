@extends('layouts.freelancer')

@section('title', 'Buy Extra Bids')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4 text-center">Buy Extra Bids</h2>

                    <p class="text-muted text-center mb-4">Purchase additional bids to increase your monthly limit.</p>

                    @if((auth()->user()->wallet->balance ?? 0) >= 5)
                        <form action="{{ route('freelancer.purchase-bids') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Select Bid Pack</label>
                                <select class="form-select" name="bid_pack" required>
                                    <option value="">Choose a pack</option>
                                    <option value="5">5 Bids - $5</option>
                                    <option value="10">10 Bids - $10</option>
                                    <option value="20">20 Bids - $20</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <p class="mb-2">Current Balance: ${{ auth()->user()->wallet->balance ?? 0 }}</p>
                                <p class="mb-2">Current Limit: {{ auth()->user()->getBidLimit() }}</p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Purchase with Wallet</button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            Insufficient wallet balance. Please use a payment method to purchase bids.
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('freelancer.show-bid-checkout', 5) }}" class="btn btn-outline-primary w-100 mb-2">5 Bids - $5</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('freelancer.show-bid-checkout', 10) }}" class="btn btn-outline-primary w-100 mb-2">10 Bids - $10</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('freelancer.show-bid-checkout', 20) }}" class="btn btn-outline-primary w-100 mb-2">20 Bids - $20</a>
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <a href="{{ route('freelancer.proposals.index') }}" class="text-decoration-none">Back to Proposals</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection