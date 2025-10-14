@extends('layouts.freelancer')

@section('title', 'Plan Purchase Checkout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Subscribe to {{ $plan->name }}</h2>
                    <p class="mb-0">{{ $plan->description }}</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('freelancer.process-plan-checkout', $plan->id) }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <!-- Order Summary -->
                            <div class="col-md-4 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Order Summary</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>{{ $plan->name }} Plan</span>
                                            <span class="fw-semibold">${{ number_format($cost, 2) }}</span>
                                        </div>
                                        <div id="fee-display" class="d-flex justify-content-between mb-2 text-muted" style="display: none !important;">
                                            <span>Processing Fee</span>
                                            <span id="fee-amount">$0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold fs-5">
                                            <span>Total</span>
                                            <span id="total-amount">${{ number_format($cost, 2) }}</span>
                                        </div>

                                        <div class="mt-4 p-3 bg-white rounded">
                                            <h6 class="mb-2">What You Get:</h6>
                                            <ul class="list-unstyled mb-0">
                                                @foreach($plan->features as $feature)
                                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Gateway Selection -->
                            <div class="col-md-8">
                                <h5 class="mb-3">Select Payment Gateway</h5>

                                @if($gateways->isEmpty())
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        No payment gateways are currently available. Please contact support.
                                    </div>
                                @else
                                    <div class="payment-gateways mb-4">
                                        @foreach($gateways as $gateway)
                                        <div class="card mb-3 gateway-card" data-gateway-id="{{ $gateway->id }}"
                                             data-fee-percentage="{{ $gateway->transaction_fee_percentage }}"
                                             data-fee-fixed="{{ $gateway->transaction_fee_fixed }}"
                                             data-currency="{{ $gateway->transaction_fee_currency ?? 'USD' }}">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input gateway-radio" type="radio"
                                                           name="gateway_id" id="gateway-{{ $gateway->id }}"
                                                           value="{{ $gateway->id }}" required>
                                                    <label class="form-check-label w-100" for="gateway-{{ $gateway->id }}">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    @if($gateway->logo)
                                                                    <img src="{{ asset('images/gateways/' . $gateway->logo) }}"
                                                                         alt="{{ $gateway->name }}"
                                                                         class="me-3"
                                                                         style="max-height: 30px; max-width: 80px;"
                                                                         onerror="this.style.display='none'">
                                                                    @endif
                                                                    <strong class="fs-5">{{ $gateway->name }}</strong>
                                                                    @if($gateway->test_mode)
                                                                    <span class="badge bg-warning ms-2">Test Mode</span>
                                                                    @endif
                                                                </div>

                                                                @if($gateway->description)
                                                                <p class="text-muted mb-2">{{ $gateway->description }}</p>
                                                                @endif

                                                                <div class="d-flex gap-2 flex-wrap">
                                                                    @if($gateway->type === 'fiat')
                                                                    <span class="badge bg-info bg-opacity-10 text-info">
                                                                        <i class="bi bi-cash me-1"></i>Fiat Currency
                                                                    </span>
                                                                    @elseif($gateway->type === 'crypto')
                                                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                                                        <i class="bi bi-currency-bitcoin me-1"></i>Cryptocurrency
                                                                    </span>
                                                                    @else
                                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                                        <i class="bi bi-wallet2 me-1"></i>Wallet
                                                                    </span>
                                                                    @endif

                                                                    @if($gateway->supported_currencies && is_array($gateway->supported_currencies))
                                                                    <span class="badge bg-light text-dark">
                                                                        {{ implode(', ', array_slice($gateway->supported_currencies, 0, 5)) }}
                                                                        @if(count($gateway->supported_currencies) > 5)
                                                                        +{{ count($gateway->supported_currencies) - 5 }} more
                                                                        @endif
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                                @if($gateway->user_instructions)
                                                                <div class="alert alert-info mt-2 mb-0 small">
                                                                    <i class="bi bi-info-circle me-1"></i>{{ $gateway->user_instructions }}
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="text-end ms-3">
                                                                @if($gateway->transaction_fee_percentage > 0 || $gateway->transaction_fee_fixed > 0)
                                                                <small class="text-muted d-block">Processing Fee:</small>
                                                                <strong class="text-primary">
                                                                    @if($gateway->transaction_fee_percentage > 0)
                                                                    {{ $gateway->transaction_fee_percentage }}%
                                                                    @endif
                                                                    @if($gateway->transaction_fee_percentage > 0 && $gateway->transaction_fee_fixed > 0)
                                                                    +
                                                                    @endif
                                                                    @if($gateway->transaction_fee_fixed > 0)
                                                                    ${{ number_format($gateway->transaction_fee_fixed, 2) }}
                                                                    @endif
                                                                </strong>
                                                                @else
                                                                <small class="badge bg-success">No Fees</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                                for subscribing to this plan.
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid gap-2">
                                        <div id="checkout-hint" class="alert alert-info small py-2 mb-2" style="display: none;">
                                            <i class="bi bi-info-circle me-1"></i>
                                            <span id="hint-text">Please select a payment gateway and accept the terms to continue</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg" id="submit-btn" disabled>
                                            <i class="bi bi-lock-fill me-2"></i>Subscribe Now
                                        </button>
                                        <a href="{{ route('freelancer.plans') }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-left me-2"></i>Back to Plans
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="text-center mt-4 text-muted">
                <i class="bi bi-shield-check me-2"></i>
                Your payment information is secured with industry-standard encryption
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Subscription Terms</h6>
                <p>By subscribing to this plan, you agree to:</p>
                <ul>
                    <li>Pay the specified amount for the subscription period</li>
                    <li>Automatic renewal unless cancelled</li>
                    <li>Use the platform responsibly and in accordance with our guidelines</li>
                    <li>Allow plan activation after payment confirmation</li>
                </ul>
                <h6 class="mt-3">Refund Policy</h6>
                <p>Refunds are available within 30 days of subscription if you are unsatisfied with the plan features.</p>
                <h6 class="mt-3">Payment Processing</h6>
                <p>Payments are processed securely through our trusted payment partners. We do not store your payment card information on our servers.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseCost = {{ $cost }};
    const submitBtn = document.getElementById('submit-btn');
    const termsCheckbox = document.getElementById('terms');
    const gatewayRadios = document.querySelectorAll('.gateway-radio');
    const feeDisplay = document.getElementById('fee-display');
    const feeAmount = document.getElementById('fee-amount');
    const totalAmount = document.getElementById('total-amount');
    const checkoutHint = document.getElementById('checkout-hint');
    const hintText = document.getElementById('hint-text');

    // Enable submit button only when gateway is selected and terms are accepted
    function updateSubmitButton() {
        const gatewaySelected = Array.from(gatewayRadios).some(radio => radio.checked);
        const termsAccepted = termsCheckbox.checked;
        const canProceed = gatewaySelected && termsAccepted;

        submitBtn.disabled = !canProceed;

        // Show helpful hint
        if (!canProceed) {
            checkoutHint.style.display = 'block';
            if (!gatewaySelected && !termsAccepted) {
                hintText.textContent = 'Please select a payment gateway and accept the terms to continue';
            } else if (!gatewaySelected) {
                hintText.textContent = 'Please select a payment gateway to continue';
            } else if (!termsAccepted) {
                hintText.textContent = 'Please accept the terms and conditions to continue';
            }
        } else {
            checkoutHint.style.display = 'none';
        }
    }

    // Calculate and display fees
    function updateFeeDisplay(gatewayCard) {
        const feePercentage = parseFloat(gatewayCard.dataset.feePercentage || 0);
        const feeFixed = parseFloat(gatewayCard.dataset.feeFixed || 0);
        const currency = gatewayCard.dataset.currency || 'USD';

        const percentageFee = (baseCost * feePercentage) / 100;
        const totalFee = percentageFee + feeFixed;
        const total = baseCost + totalFee;

        if (totalFee > 0) {
            feeDisplay.style.display = 'flex';
            feeAmount.textContent = '$' + totalFee.toFixed(2);
            totalAmount.textContent = '$' + total.toFixed(2);
        } else {
            feeDisplay.style.display = 'none';
            totalAmount.textContent = '$' + baseCost.toFixed(2);
        }
    }

    // Add event listeners
    gatewayRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update visual selection
            document.querySelectorAll('.gateway-card').forEach(card => {
                card.classList.remove('border-primary', 'bg-light');
            });
            if (this.checked) {
                const card = this.closest('.gateway-card');
                card.classList.add('border-primary', 'bg-light');
                updateFeeDisplay(card);
            }
            updateSubmitButton();
        });
    });

    // Make gateway cards clickable
    document.querySelectorAll('.gateway-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Only trigger if not clicking on interactive elements
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                return;
            }
            const radio = this.querySelector('.gateway-radio');
            if (radio && !radio.checked) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    termsCheckbox.addEventListener('change', updateSubmitButton);

    // Initial check - if only one gateway, auto-select it
    if (gatewayRadios.length === 1) {
        gatewayRadios[0].checked = true;
        gatewayRadios[0].dispatchEvent(new Event('change'));
    }

    // Show initial hint
    updateSubmitButton();

    // Form validation
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        if (!submitBtn.disabled) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        }
    });
});
</script>
@endpush

<style>
.gateway-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.gateway-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.gateway-card.border-primary {
    border-width: 2px;
}

.form-check-input:checked ~ .form-check-label {
    color: inherit;
}

.gateway-card .form-check-input {
    margin-top: 0.5rem;
}
</style>
@endsection