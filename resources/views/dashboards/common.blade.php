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
                <!-- Client Role -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm role-card" data-role="client" style="cursor: pointer; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-person-check display-4 text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold">I'm a Client</h5>
                            <p class="card-text text-muted">Post jobs, hire freelancers, and get projects completed professionally.</p>
                            <button class="btn btn-primary select-role" data-role="client">
                                <i class="bi bi-arrow-right me-2"></i>Enter as Client
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Freelancer Role -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm role-card" data-role="freelancer" style="cursor: pointer; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-tools display-4 text-success"></i>
                            </div>
                            <h5 class="card-title fw-bold">I'm a Freelancer</h5>
                            <p class="card-text text-muted">Offer your services, bid on projects, and build your freelance career.</p>
                            <button class="btn btn-success select-role" data-role="freelancer">
                                <i class="bi bi-arrow-right me-2"></i>Enter as Freelancer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Vendor Role -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm role-card" data-role="vendor" style="cursor: pointer; transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-shop display-4 text-info"></i>
                            </div>
                            <h5 class="card-title fw-bold">I'm a Vendor</h5>
                            <p class="card-text text-muted">Sell digital products, templates, and creative assets to customers worldwide.</p>
                            <button class="btn btn-info select-role" data-role="vendor">
                                <i class="bi bi-arrow-right me-2"></i>Enter as Vendor
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Multi-Role Option -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-warning">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-diagram-3 display-4 text-warning"></i>
                            </div>
                            <h5 class="card-title fw-bold text-warning">I want to do multiple things</h5>
                            <p class="card-text text-muted">Switch between roles as needed - hire freelancers, sell products, and offer services all in one account.</p>
                            <button class="btn btn-warning select-role" data-role="multi">
                                <i class="bi bi-arrow-right me-2"></i>Enable Multi-Role Access
                            </button>
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
        const roleName = role === 'multi' ? 'Multi-Role' : role.charAt(0).toUpperCase() + role.slice(1);

        if (confirm(`Are you sure you want to select the ${roleName} role? You can always switch later.`)) {
            // Show loading
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
            this.disabled = true;

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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert('Error setting role: ' + (data.error || 'Please try again.'));
                    this.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Enter as ' + roleName;
                    this.disabled = false;
                }
            })
            .catch(error => {
                alert('Error setting role. Please try again.');
                this.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Enter as ' + roleName;
                this.disabled = false;
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