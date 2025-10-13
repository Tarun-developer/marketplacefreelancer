@extends('layouts.guest')

@section('title', 'Welcome to MarketFusion')

@section('page-title', 'Choose Your Experience')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Welcome to MarketFusion</h1>
                <p class="lead text-muted">Your all-in-one marketplace platform. Choose how you'd like to get started today.</p>
            </div>

            <div class="row g-4">
                @php
                    $userRoles = auth()->user()->roles->pluck('name')->toArray();
                    $allRoles = ['client', 'freelancer', 'vendor'];
                    $roleCosts = [
                        'client' => config('settings.client_role_cost', 0),
                        'freelancer' => config('settings.freelancer_role_cost', 0),
                        'vendor' => config('settings.vendor_role_cost', 0),
                    ];
                @endphp

                @foreach($allRoles as $role)
                    @php
                        $hasRole = in_array($role, $userRoles);
                        $roleName = ucfirst($role);
                        $icon = $role === 'client' ? 'person-check' : ($role === 'freelancer' ? 'tools' : 'shop');
                        $color = $role === 'client' ? 'primary' : ($role === 'freelancer' ? 'success' : 'info');
                        $cost = $roleCosts[$role];
                        $isFree = $cost == 0;
                        $buttonText = $hasRole ? "Enter as $roleName" : ($isFree ? "Become $roleName (Free)" : "Become $roleName ($$cost)");
                        $buttonClass = $hasRole ? "btn-$color" : ($isFree ? "btn-outline-$color" : "btn-warning");
                    @endphp

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm role-card" data-role="{{ $role }}" style="cursor: pointer; transition: transform 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-{{ $icon }} display-4 text-{{ $color }}"></i>
                                </div>
                                <h5 class="card-title fw-bold">I'm a {{ $roleName }}</h5>
                                <p class="card-text text-muted">
                                    @if($role === 'client')
                                        Post jobs, hire freelancers, and get projects completed professionally.
                                    @elseif($role === 'freelancer')
                                        Offer your services, bid on projects, and build your freelance career.
                                    @else
                                        Sell digital products, templates, and creative assets to customers worldwide.
                                    @endif
                                </p>
                                @if(!$isFree)
                                    <p class="text-warning fw-bold">Cost: ${{ $cost }}</p>
                                @endif
                                <button class="btn {{ $buttonClass }} select-role" data-role="{{ $role }}" data-cost="{{ $cost }}" data-free="{{ $isFree ? '1' : '0' }}">
                                    <i class="bi bi-arrow-right me-2"></i>{{ $buttonText }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Multi-Role Option -->
                <div class="col-12 mt-4">
                    <div class="card border-warning">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-diagram-3 display-4 text-warning"></i>
                            </div>
                            <h5 class="card-title fw-bold text-warning">I want to do multiple things</h5>
                            <p class="card-text text-muted">Switch between roles as needed - hire freelancers, sell products, and offer services all in one account.</p>
                            <button class="btn btn-warning select-role" data-role="multi" data-cost="0" data-free="1">
                                <i class="bi bi-arrow-right me-2"></i>Enable Multi-Role Access (Free)
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Become <span id="modalRoleName"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="paymentForm">
                                @csrf
                                <input type="hidden" id="paymentRole" name="role">
                                <input type="hidden" id="paymentCost" name="cost">

                                <div class="mb-3">
                                    <h6>Payment Details</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="paymentMethod" class="form-label">Payment Method</label>
                                            <select class="form-select" id="paymentMethod" name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="stripe">Stripe</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="free">Free (Admin Approved)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="amount" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amount" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6>Payment Information</h6>
                                    <div id="stripeFields" style="display: none;">
                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="expiryDate" class="form-label">Expiry Date</label>
                                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" placeholder="123">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="paypalFields" style="display: none;">
                                        <p>You will be redirected to PayPal to complete the payment.</p>
                                    </div>

                                    <div id="freeFields" style="display: none;">
                                        <p>Your request will be sent to admin for approval.</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsAccepted" required>
                                        <label class="form-check-label" for="termsAccepted">
                                            I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Complete Payment</button>
                            </form>
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
                            <h6>Role Assignment Terms</h6>
                            <p>By accepting these terms, you agree to:</p>
                            <ul>
                                <li>Use the platform responsibly and follow community guidelines</li>
                                <li>Pay any applicable fees for role upgrades</li>
                                <li>Provide accurate information during registration</li>
                                <li>Respect intellectual property rights</li>
                                <li>Allow admin approval for certain role changes</li>
                            </ul>
                            <p>Platform reserves the right to suspend or terminate accounts for violations.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-5">
                <div class="col-md-3">
                    <div class="text-center">
                        <h2 class="text-primary">{{ \App\Models\User::count() }}</h2>
                        <p class="text-muted">Active Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h2 class="text-success">{{ \App\Modules\Services\Models\Service::count() }}</h2>
                        <p class="text-muted">Services Available</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h2 class="text-info">{{ \App\Modules\Products\Models\Product::count() }}</h2>
                        <p class="text-muted">Products Listed</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h2 class="text-warning">{{ \App\Modules\Jobs\Models\Job::count() }}</h2>
                        <p class="text-muted">Jobs Posted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.select-role').forEach(button => {
    button.addEventListener('click', function() {
        const role = this.getAttribute('data-role');
        const cost = parseFloat(this.getAttribute('data-cost'));
        const isFree = this.getAttribute('data-free') === '1';
        const roleName = role === 'multi' ? 'Multi-Role' : role.charAt(0).toUpperCase() + role.slice(1);

        if (isFree) {
            // Free role - direct assignment
            if (confirm(`Are you sure you want to select the ${roleName} role? You can always switch later.`)) {
                processRoleSelection(role, cost, isFree);
            }
        } else {
            // Paid role - show payment modal
            document.getElementById('modalRoleName').textContent = roleName;
            document.getElementById('paymentRole').value = role;
            document.getElementById('paymentCost').value = cost;
            document.getElementById('amount').value = `$${cost}`;

            // Show payment modal
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        }
    });
});

function processRoleSelection(role, cost, isFree) {
    const button = document.querySelector(`[data-role="${role}"]`);
    const roleName = role === 'multi' ? 'Multi-Role' : role.charAt(0).toUpperCase() + role.slice(1);

    // Show loading
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
    button.disabled = true;

    // Send AJAX request to set role
    fetch('{{ route("onboarding.set-role") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ role: role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert('Error setting role: ' + (data.error || 'Please try again.'));
            resetButton(button, role, cost, isFree, roleName);
        }
    })
    .catch(error => {
        alert('Error setting role. Please try again.');
        resetButton(button, role, cost, isFree, roleName);
    });
}

function resetButton(button, role, cost, isFree, roleName) {
    const buttonText = isFree ? `Become ${roleName} (Free)` : `Become ${roleName} ($${cost})`;
    button.innerHTML = '<i class="bi bi-arrow-right me-2"></i>' + buttonText;
    button.disabled = false;
}

// Payment form handling
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const role = document.getElementById('paymentRole').value;
    const cost = document.getElementById('paymentCost').value;
    const paymentMethod = document.getElementById('paymentMethod').value;

    if (!paymentMethod) {
        alert('Please select a payment method.');
        return;
    }

    // Simulate payment processing
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing Payment...';
    submitBtn.disabled = true;

    setTimeout(() => {
        // Simulate successful payment
        alert('Payment processed successfully!');

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        modal.hide();

        // Process role selection
        processRoleSelection(role, cost, false);
    }, 2000);
});

// Payment method change
document.getElementById('paymentMethod').addEventListener('change', function() {
    const method = this.value;
    document.getElementById('stripeFields').style.display = method === 'stripe' ? 'block' : 'none';
    document.getElementById('paypalFields').style.display = method === 'paypal' ? 'block' : 'none';
    document.getElementById('freeFields').style.display = method === 'free' ? 'block' : 'none';
});
        }
    });
});

// Add hover effects
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
        this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
    });

    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    });
});
</script>

<style>
.role-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.role-card:hover {
    border-color: var(--bs-primary);
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
</style>
@endsection