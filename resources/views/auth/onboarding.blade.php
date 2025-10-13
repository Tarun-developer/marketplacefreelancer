@extends('layouts.guest')

@section('title', 'Choose Your Role')

@section('page-title', 'Welcome to MarketFusion')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h2>Welcome to MarketFusion!</h2>
                    <p class="mb-0">Choose how you'd like to use our platform</p>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-primary role-card" data-role="client" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-check display-4 text-primary mb-3"></i>
                                    <h5 class="card-title">I want to hire freelancers</h5>
                                    <p class="card-text">Post jobs, find skilled freelancers, and get projects done.</p>
                                    <button class="btn btn-primary select-role" data-role="client">Choose Client</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-success role-card" data-role="freelancer" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <i class="bi bi-tools display-4 text-success mb-3"></i>
                                    <h5 class="card-title">I want to find jobs</h5>
                                    <p class="card-text">Offer your services, bid on projects, and earn money.</p>
                                    <button class="btn btn-success select-role" data-role="freelancer">Choose Freelancer</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-info role-card" data-role="vendor" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <i class="bi bi-shop display-4 text-info mb-3"></i>
                                    <h5 class="card-title">I want to sell products</h5>
                                    <p class="card-text">Sell digital products, templates, and creative assets.</p>
                                    <button class="btn btn-info select-role" data-role="vendor">Choose Vendor</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-warning role-card" data-role="multi" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <i class="bi bi-diagram-3 display-4 text-warning mb-3"></i>
                                    <h5 class="card-title">I want to do multiple things</h5>
                                    <p class="card-text">Switch between roles as needed (hire, sell, freelance).</p>
                                    <button class="btn btn-warning select-role" data-role="multi">Choose Multi-Role</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <p class="text-muted">You can always change your role later in settings.</p>
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
        if (confirm(`Are you sure you want to select the ${role} role?`)) {
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
                    alert('Error setting role. Please try again.');
                }
            })
            .catch(error => {
                alert('Error setting role. Please try again.');
            });
        }
    });
});
</script>

<style>
.role-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
</style>
@endsection