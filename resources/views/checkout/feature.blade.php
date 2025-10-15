@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.select-role') }}">Buy Features</a></li>
                    <li class="breadcrumb-item active">{{ $featureData['name'] }}</li>
                </ol>
            </nav>

            <!-- Feature Summary -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ $featureData['name'] }}</h2>
                            <p class="text-muted mb-3">{{ $featureData['description'] }}</p>

                            <div class="mb-3">
                                <h6 class="mb-2">What's included:</h6>
                                <ul class="list-unstyled">
                                    @foreach([
                                        'Unlimited projects',
                                        'Task management',
                                        'Time tracking',
                                        'File sharing',
                                        'Client collaboration',
                                        'Progress reports'
                                    ] as $item)
                                        <li class="mb-1">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>{{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 text-center">
                            <div class="border rounded p-3 bg-light">
                                <h3 class="text-primary mb-2">${{ number_format($featureData['cost'], 2) }}</h3>
                                <p class="text-muted mb-0">
                                    @if($featureData['type'] === 'subscription')
                                        per month
                                    @else
                                        one-time payment
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Complete Your Purchase</h5>
                </div>
                <div class="card-body">
                    <form id="payment-form" method="POST" action="{{ route('checkout.feature.purchase', $feature) }}">
                        @csrf

                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <label class="form-label">Payment Method</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" checked>
                                        <label class="form-check-label" for="stripe">
                                            <i class="bi bi-credit-card me-2"></i>Credit Card (Stripe)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <i class="bi bi-paypal me-2"></i>PayPal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Purchase Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="purchase-btn">
                                <i class="bi bi-lock me-2"></i>Complete Purchase - ${{ number_format($featureData['cost'], 2) }}
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Your payment information is secure and encrypted
                            </small>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Badges -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center align-items-center gap-4 text-muted">
                        <div class="text-center">
                            <i class="bi bi-shield-check fs-3 text-success mb-1"></i>
                            <small class="d-block">SSL Encrypted</small>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-credit-card fs-3 text-primary mb-1"></i>
                            <small class="d-block">Secure Payment</small>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-headset fs-3 text-info mb-1"></i>
                            <small class="d-block">24/7 Support</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple form validation and submission
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const purchaseBtn = document.getElementById('purchase-btn');
    const originalText = purchaseBtn.innerHTML;

    // Show loading state
    purchaseBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
    purchaseBtn.disabled = true;

    // Simulate payment processing
    setTimeout(() => {
        // In a real implementation, this would submit to payment gateway
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert('Purchase failed: ' + data.error);
                purchaseBtn.innerHTML = originalText;
                purchaseBtn.disabled = false;
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
            purchaseBtn.innerHTML = originalText;
            purchaseBtn.disabled = false;
        });
    }, 2000);
});
</script>
@endsection