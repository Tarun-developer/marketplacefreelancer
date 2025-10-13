@extends('layouts.guest')

@section('title', 'Checkout - ' . ucfirst($role))

@section('page-title', 'Complete Your Role Purchase')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Complete Your {{ ucfirst($role) }} Role Purchase</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Order Summary</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span>{{ ucfirst($role) }} Role Access</span>
                                <span>${{ number_format($cost, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>${{ number_format($cost, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5>Payment Method</h5>
                            <form action="{{ route('checkout.process', $role) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select class="form-select" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="stripe">Stripe</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Complete Payment</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                <h6>Role Purchase Terms</h6>
                <p>By completing this purchase, you agree to:</p>
                <ul>
                    <li>Pay the specified amount for role access</li>
                    <li>Use the platform responsibly</li>
                    <li>Follow all platform rules and guidelines</li>
                    <li>Allow role activation after payment confirmation</li>
                </ul>
                <p>Refunds are available within 30 days if unsatisfied.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection