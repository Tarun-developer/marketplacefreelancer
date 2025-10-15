@extends('layouts.client')

@section('title', 'My Wallet')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Wallet</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Wallet Balance -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h2 class="text-primary mb-3">${{ number_format($wallet->balance ?? 0, 2) }}</h2>
                            <p class="text-muted mb-0">Current Balance</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Quick Actions</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#depositModal">
                                        <i class="bi bi-plus-circle me-2"></i>Deposit Funds
                                    </button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                        <i class="bi bi-dash-circle me-2"></i>Withdraw Funds
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Transaction History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type == 'credit' ? 'success' : 'danger' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-{{ $transaction->type == 'credit' ? 'success' : 'danger' }}">
                                                ${{ number_format($transaction->amount, 2) }}
                                            </strong>
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-3">No transactions yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($transactions->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depositModalLabel">Deposit Funds</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('client.wallet.deposit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deposit_amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="deposit_amount" name="amount" step="0.01" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="deposit_payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="deposit_payment_method" name="payment_method" required>
                            <option value="">Choose payment method</option>
                            @foreach(\App\Modules\Payments\Models\PaymentMethod::where('user_id', auth()->id())->active()->get() as $method)
                                <option value="{{ $method->id }}">{{ $method->type }} - {{ $method->last_four }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Funds</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('client.wallet.withdraw') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="withdraw_amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="withdraw_amount" name="amount" step="0.01" min="1" max="{{ $wallet->balance ?? 0 }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="withdraw_payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="withdraw_payment_method" name="payment_method" required>
                            <option value="">Choose payment method</option>
                            @foreach(\App\Modules\Payments\Models\PaymentMethod::where('user_id', auth()->id())->active()->get() as $method)
                                <option value="{{ $method->id }}">{{ $method->type }} - {{ $method->last_four }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Withdraw</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection