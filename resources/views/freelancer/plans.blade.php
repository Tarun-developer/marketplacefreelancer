@extends('layouts.freelancer')

@section('title', 'Freelancer Plans')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Freelancer Plans</h1>
                <p class="text-muted mb-0">Choose a plan that fits your freelancing needs</p>
            </div>

            <div class="row">
                @foreach($plans as $plan)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $plan->name }}</h5>
                                <h2 class="text-primary mb-3">${{ number_format($plan->price, 2) }}<small class="text-muted">/{{ $plan->billing_period }}</small></h2>

                                <ul class="list-unstyled text-start mb-4">
                                    @foreach($plan->features as $feature)
                                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>{{ $feature }}</li>
                                    @endforeach
                                </ul>

                                @if(auth()->user()->activeFreelancerSubscription() && auth()->user()->activeFreelancerSubscription()->subscription_plan_id === $plan->id)
                                    <button class="btn btn-success w-100" disabled>Current Plan</button>
                                @else
                                    <a href="{{ route('freelancer.show-plan-checkout', $plan->id) }}" class="btn btn-outline-primary w-100">Upgrade to {{ $plan->name }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <p class="text-muted">All plans include secure payment processing and instant activation.</p>
            </div>
        </div>
    </div>
</div>
@endsection