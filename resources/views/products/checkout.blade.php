@extends('layouts.app')

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Checkout</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted">{{ $product->category->name }}</p>

                            <div class="license-selection mb-4">
                                <h6>Select License Type</h6>
                                @if($product->standard_price || $product->price)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="license_type" id="standard_checkout" value="standard" {{ $licenseType == 'standard' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="standard_checkout">
                                            <strong>Standard License</strong> - ${{ number_format($product->standard_price ?? $product->price, 2) }}
                                            <small class="text-muted d-block">Single site usage</small>
                                        </label>
                                    </div>
                                @endif
                                @if($product->professional_price)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="license_type" id="professional_checkout" value="professional" {{ $licenseType == 'professional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="professional_checkout">
                                            <strong>Professional License</strong> - ${{ number_format($product->professional_price, 2) }}
                                            <small class="text-muted d-block">Multiple sites, extended use</small>
                                        </label>
                                    </div>
                                @endif
                                @if($product->ultimate_price)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="license_type" id="ultimate_checkout" value="ultimate" {{ $licenseType == 'ultimate' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ultimate_checkout">
                                            <strong>Ultimate License</strong> - ${{ number_format($product->ultimate_price, 2) }}
                                            <small class="text-muted d-block">Unlimited use, SaaS ready</small>
                                        </label>
                                    </div>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('client.products.purchase', $product) }}">
                                @csrf
                                <input type="hidden" name="license_type" value="{{ $licenseType }}">

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="credit_card">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100" id="purchase-btn">
                                    Complete Purchase - $<span id="purchase-price">{{ number_format($price, 2) }}</span>
                                </button>
                            </form>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <h6>Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $product->name }}</span>
                                    <span id="summary-price">${{ number_format($price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>License Type</span>
                                    <span id="summary-license">{{ ucfirst($licenseType) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong id="summary-total">${{ number_format($price, 2) }}</strong>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    By completing your purchase, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const licenseRadios = document.querySelectorAll('input[name="license_type"]');
    const prices = {
        standard: {{ $product->standard_price ?? $product->price }},
        professional: {{ $product->professional_price ?? 'null' }},
        ultimate: {{ $product->ultimate_price ?? 'null' }}
    };

    licenseRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const selectedType = this.value;
            const price = prices[selectedType];
            
            if (price) {
                document.getElementById('summary-price').textContent = '$' + price.toFixed(2);
                document.getElementById('summary-total').textContent = '$' + price.toFixed(2);
                document.getElementById('purchase-price').textContent = price.toFixed(2);
                document.getElementById('summary-license').textContent = selectedType.charAt(0).toUpperCase() + selectedType.slice(1);
            }
        });
    });
});
</script>
@endpush
@endsection