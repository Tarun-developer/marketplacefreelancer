@extends('layouts.guest')

@section('title', 'Pricing Plans')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Choose Your Plan</h1>
            <p class="lead text-muted">Select the perfect plan for your freelancing or client needs</p>
        </div>
    </div>

    <!-- Plan Toggle -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card border-0 bg-light">
                <div class="card-body text-center">
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="plan-type" id="freelancer-toggle" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="freelancer-toggle">For Freelancers</label>

                        <input type="radio" class="btn-check" name="plan-type" id="client-toggle" autocomplete="off">
                        <label class="btn btn-outline-primary" for="client-toggle">For Clients</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Freelancer Plans -->
    <div id="freelancer-plans" class="plans-container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Freelancer Free</h5>
                        <h2 class="text-primary mb-3">$0<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>5 bids per month</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Basic profile</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Job browsing</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Email support</li>
                        </ul>

                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Get Started Free</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 border-primary">
                    <div class="card-body text-center">
                        <div class="badge bg-primary mb-2">Most Popular</div>
                        <h5 class="card-title">Freelancer Pro</h5>
                        <h2 class="text-primary mb-3">$29.99<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>50 bids per month</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Premium profile</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Featured listings</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Priority support</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Advanced analytics</li>
                        </ul>

                        <a href="{{ route('register') }}" class="btn btn-primary w-100">Start Pro Trial</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Freelancer Enterprise</h5>
                        <h2 class="text-primary mb-3">$99.99<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>100 bids per month</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Custom profile</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Dedicated support</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>API access</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>White-label options</li>
                        </ul>

                        <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Plans -->
    <div id="client-plans" class="plans-container" style="display: none;">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Client Free</h5>
                        <h2 class="text-primary mb-3">$0<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>5 projects per month</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Basic escrow</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Standard support</li>
                        </ul>

                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Get Started Free</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 border-primary">
                    <div class="card-body text-center">
                        <div class="badge bg-primary mb-2">Most Popular</div>
                        <h5 class="card-title">Client Pro</h5>
                        <h2 class="text-primary mb-3">$39.99<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Unlimited projects</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Premium escrow</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Verified badge</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Dedicated support</li>
                        </ul>

                        <a href="{{ route('register') }}" class="btn btn-primary w-100">Start Pro Trial</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Client Enterprise</h5>
                        <h2 class="text-primary mb-3">$99.99<small class="text-muted">/month</small></h2>

                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Everything in Pro</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Custom integrations</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Multi-team management</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>SLA guarantee</li>
                        </ul>

                        <a href="{{ route('contact') }}" class="btn btn-outline-primary w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Frequently Asked Questions</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="accordion" id="pricingFAQ">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                            Can I change my plan anytime?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately,
                            and we'll prorate any charges accordingly.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                            Is there a free trial?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            All plans include a free tier with basic features. Pro plans offer a 14-day free trial
                            for new users to experience premium features.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#pricingFAQ">
                        <div class="accordion-body">
                            We accept all major credit cards, PayPal, and bank transfers. All payments are processed
                            securely through our encrypted payment system.
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
    const freelancerToggle = document.getElementById('freelancer-toggle');
    const clientToggle = document.getElementById('client-toggle');
    const freelancerPlans = document.getElementById('freelancer-plans');
    const clientPlans = document.getElementById('client-plans');

    freelancerToggle.addEventListener('change', function() {
        if (this.checked) {
            freelancerPlans.style.display = 'block';
            clientPlans.style.display = 'none';
        }
    });

    clientToggle.addEventListener('change', function() {
        if (this.checked) {
            freelancerPlans.style.display = 'none';
            clientPlans.style.display = 'block';
        }
    });
});
</script>
@endpush
@endsection