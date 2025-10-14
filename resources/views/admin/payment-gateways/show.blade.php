@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $paymentGateway->name }}</h1>
            <p class="text-muted">Payment Gateway Details</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.payment-gateways.edit', $paymentGateway) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Gateway
            </a>
            <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Gateway Info -->
        <div class="col-lg-8">
            <!-- Overview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-3">{{ $paymentGateway->name }}</h4>
                            <p class="text-muted">{{ $paymentGateway->description }}</p>

                            <div class="d-flex gap-2 mb-3">
                                @if($paymentGateway->type == 'fiat')
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    <i class="fas fa-dollar-sign me-1"></i>Fiat Currency
                                </span>
                                @elseif($paymentGateway->type == 'crypto')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                    <i class="fab fa-bitcoin me-1"></i>Cryptocurrency
                                </span>
                                @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                    <i class="fas fa-wallet me-1"></i>Wallet
                                </span>
                                @endif

                                @if($paymentGateway->is_active)
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </span>
                                @else
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>Inactive
                                </span>
                                @endif

                                @if($paymentGateway->test_mode)
                                <span class="badge bg-warning px-3 py-2">
                                    <i class="fas fa-flask me-1"></i>Test Mode
                                </span>
                                @else
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-bolt me-1"></i>Live Mode
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($paymentGateway->logo)
                            <img src="{{ asset('images/gateways/' . $paymentGateway->logo) }}" alt="{{ $paymentGateway->name }}"
                                 class="img-fluid rounded" style="max-height: 80px" onerror="this.style.display='none'">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-exchange-alt text-primary fs-2 mb-2"></i>
                            <h5 class="mb-0">{{ number_format($stats['total_transactions']) }}</h5>
                            <small class="text-muted">Total Transactions</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-check text-success fs-2 mb-2"></i>
                            <h5 class="mb-0">{{ number_format($stats['successful_transactions']) }}</h5>
                            <small class="text-muted">Successful</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-times text-danger fs-2 mb-2"></i>
                            <h5 class="mb-0">{{ number_format($stats['failed_transactions']) }}</h5>
                            <small class="text-muted">Failed</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-dollar-sign text-info fs-2 mb-2"></i>
                            <h5 class="mb-0">${{ number_format($stats['total_volume'], 2) }}</h5>
                            <small class="text-muted">Total Volume</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Configuration</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Slug</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->slug }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Sort Order</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->sort_order }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Processing Time</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->processing_time_minutes }} minutes</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Last Used</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->last_used_at ? $paymentGateway->last_used_at->diffForHumans() : 'Never' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fee Structure -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Fee Structure</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="text-muted small">Percentage Fee</label>
                            <p class="mb-0 fw-semibold fs-5">{{ $paymentGateway->transaction_fee_percentage }}%</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Fixed Fee</label>
                            <p class="mb-0 fw-semibold fs-5">{{ $paymentGateway->transaction_fee_currency }} {{ number_format($paymentGateway->transaction_fee_fixed, 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Example (for $100)</label>
                            <p class="mb-0 fw-semibold fs-5 text-primary">
                                ${{ number_format($paymentGateway->calculateFee(100), 2) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Minimum Amount</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->min_amount ? '$' . number_format($paymentGateway->min_amount, 2) : 'No limit' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Maximum Amount</label>
                            <p class="mb-0 fw-semibold">{{ $paymentGateway->max_amount ? '$' . number_format($paymentGateway->max_amount, 2) : 'No limit' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Instructions -->
            @if($paymentGateway->user_instructions)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">User Instructions</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $paymentGateway->user_instructions }}</p>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($paymentGateway->admin_notes)
            <div class="card border-0 shadow-sm mb-4 border-start border-warning border-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-sticky-note text-warning me-2"></i>Admin Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $paymentGateway->admin_notes }}</p>
                </div>
            </div>
            @endif

            <!-- Recent Transactions -->
            @if($paymentGateway->transactions->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Transactions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentGateway->transactions as $transaction)
                                <tr>
                                    <td><code>#{{ $transaction->id }}</code></td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        @if($transaction->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                        @elseif($transaction->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @else
                                        <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Quick Actions & Support Info -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment-gateways.toggle-status', $paymentGateway) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn {{ $paymentGateway->is_active ? 'btn-danger' : 'btn-success' }} w-100">
                            <i class="fas {{ $paymentGateway->is_active ? 'fa-times' : 'fa-check' }} me-2"></i>
                            {{ $paymentGateway->is_active ? 'Deactivate Gateway' : 'Activate Gateway' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.payment-gateways.toggle-test-mode', $paymentGateway) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn {{ $paymentGateway->test_mode ? 'btn-success' : 'btn-warning' }} w-100">
                            <i class="fas {{ $paymentGateway->test_mode ? 'fa-bolt' : 'fa-flask' }} me-2"></i>
                            {{ $paymentGateway->test_mode ? 'Switch to Live Mode' : 'Switch to Test Mode' }}
                        </button>
                    </form>

                    <hr>

                    <a href="{{ route('admin.payment-gateways.edit', $paymentGateway) }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Configuration
                    </a>

                    @if($paymentGateway->total_transactions == 0)
                    <form action="{{ route('admin.payment-gateways.destroy', $paymentGateway) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this gateway?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Gateway
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Supported Currencies -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Supported Currencies</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($paymentGateway->supported_currencies ?? [] as $currency)
                        <span class="badge bg-primary px-3 py-2">{{ $currency }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Supported Countries -->
            @if($paymentGateway->supported_countries && count($paymentGateway->supported_countries) > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Supported Countries</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($paymentGateway->supported_countries as $country)
                        <span class="badge bg-secondary px-3 py-2">{{ $country }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Webhook Configuration -->
            @if($paymentGateway->webhook_url)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Webhook Configuration</h5>
                </div>
                <div class="card-body">
                    <label class="text-muted small">Webhook URL</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" value="{{ url($paymentGateway->webhook_url) }}" readonly>
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    @if($paymentGateway->webhook_secret)
                    <label class="text-muted small">Webhook Secret</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-sm" value="{{ $paymentGateway->webhook_secret }}" readonly>
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="togglePassword(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(button) {
    const input = button.previousElementSibling;
    input.select();
    document.execCommand('copy');

    const icon = button.querySelector('i');
    icon.classList.remove('fa-copy');
    icon.classList.add('fa-check');
    button.classList.add('btn-success');

    setTimeout(() => {
        icon.classList.remove('fa-check');
        icon.classList.add('fa-copy');
        button.classList.remove('btn-success');
    }, 2000);
}

function togglePassword(button) {
    const input = button.previousElementSibling;
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection
