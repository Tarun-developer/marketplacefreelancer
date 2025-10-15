@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">🚀 Unlock New Features</h1>
                <p class="lead text-muted">Enhance your experience with premium addons and tools</p>
            </div>

            <!-- Features Grid -->
            <div class="row g-4">
                @foreach($availableFeatures as $key => $feature)
                    <div class="col-lg-6 col-xl-4">
                        <div class="card h-100 shadow-sm border-0 hover-lift {{ $feature['popular'] ?? false ? 'border-primary border-2' : '' }}">
                            @if($feature['popular'] ?? false)
                                <div class="position-absolute top-0 end-0 mt-2 me-2">
                                    <span class="badge bg-primary">Most Popular</span>
                                </div>
                            @endif

                            <div class="card-body text-center p-4">
                                <!-- Icon -->
                                <div class="mb-4">
                                    <div class="bg-{{ $feature['color'] }}-100 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="bi {{ $feature['icon'] }} fs-2 text-{{ $feature['color'] }}"></i>
                                    </div>
                                </div>

                                <!-- Title & Description -->
                                <h5 class="card-title mb-3">{{ $feature['name'] }}</h5>
                                <p class="card-text text-muted mb-4">{{ $feature['description'] }}</p>

                                <!-- Price -->
                                <div class="mb-4">
                                    <span class="h3 text-{{ $feature['color'] }} fw-bold">${{ number_format($feature['cost'], 2) }}</span>
                                    @if($feature['cost'] > 0)
                                        <small class="text-muted">one-time</small>
                                    @else
                                        <small class="text-success">FREE</small>
                                    @endif
                                </div>

                                <!-- Features List -->
                                <div class="mb-4">
                                    <ul class="list-unstyled text-start">
                                        @foreach($feature['features'] as $item)
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <small>{{ $item }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Purchase Button -->
                                <button class="btn btn-{{ $feature['color'] }} w-100"
                                        onclick="purchaseFeature('{{ $key }}', '{{ $feature['name'] }}', {{ $feature['cost'] }})">
                                    <i class="bi bi-cart-plus me-2"></i>
                                    @if($feature['cost'] > 0)
                                        Purchase Now
                                    @else
                                        Get Started
                                    @endif
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- FAQ Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Frequently Asked Questions</h5>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            How do I purchase a feature?
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Click the "Purchase Now" button on any feature card. You'll be redirected to our secure payment processor to complete your purchase.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            Can I cancel or get a refund?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Most features are one-time purchases. Contact our support team within 30 days for refund requests on eligible items.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                            Do features expire?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Most features are permanent unlocks. Subscription-based features (like SPM) renew monthly unless cancelled.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function purchaseFeature(key, name, cost) {
    if (cost === 0) {
        // Free feature - redirect to activation
        window.location.href = '{{ route("spm.subscriptions.plans") }}';
    } else {
        // Paid feature - redirect to checkout
        window.location.href = '{{ url("/checkout/feature") }}/' + key;
    }
}
</script>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.accordion-button:not(.collapsed) {
    background-color: var(--bs-primary);
    color: white;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endsection