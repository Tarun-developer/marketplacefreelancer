@extends('onboarding.layout')

@section('title', 'Choose Your Role')

@section('content')
<div class="py-4">
    <div class="text-center mb-4">
        <h2 class="mb-3">Choose Your Primary Role</h2>
        <p class="text-muted">Select how you'll primarily use our platform. You can always add more roles later!</p>
    </div>

    <form method="POST" action="{{ route('onboarding.process') }}" class="row justify-content-center">
        @csrf

        <div class="col-lg-8">
            <div class="row g-4">
                <!-- Client Role -->
                <div class="col-md-4">
                    <div class="card h-100 border-2 role-card {{ old('role') === 'client' ? 'border-primary' : 'border-light' }}" data-role="client">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary text-white mb-3">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <h5 class="card-title mb-3">Client</h5>
                            <p class="card-text text-muted mb-4">Post jobs, hire freelancers, and manage projects</p>

                            <div class="mb-3">
                                <small class="text-muted">Perfect for:</small>
                                <div class="mt-2">
                                    <span class="badge bg-light text-dark me-1">Business Owners</span>
                                    <span class="badge bg-light text-dark">Project Managers</span>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="client" value="client" {{ old('role', $user->current_role) === 'client' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="client">
                                    Select Client Role
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Freelancer Role -->
                <div class="col-md-4">
                    <div class="card h-100 border-2 role-card {{ old('role') === 'freelancer' ? 'border-primary' : 'border-light' }}" data-role="freelancer">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success text-white mb-3">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h5 class="card-title mb-3">Freelancer</h5>
                            <p class="card-text text-muted mb-4">Offer services, find work, and build your portfolio</p>

                            <div class="mb-3">
                                <small class="text-muted">Perfect for:</small>
                                <div class="mt-2">
                                    <span class="badge bg-light text-dark me-1">Developers</span>
                                    <span class="badge bg-light text-dark">Designers</span>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="freelancer" value="freelancer" {{ old('role', $user->current_role) === 'freelancer' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="freelancer">
                                    Select Freelancer Role
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendor Role -->
                <div class="col-md-4">
                    <div class="card h-100 border-2 role-card {{ old('role') === 'vendor' ? 'border-primary' : 'border-light' }}" data-role="vendor">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-info text-white mb-3">
                                <i class="bi bi-shop"></i>
                            </div>
                            <h5 class="card-title mb-3">Vendor</h5>
                            <p class="card-text text-muted mb-4">Sell products, manage inventory, and grow your business</p>

                            <div class="mb-3">
                                <small class="text-muted">Perfect for:</small>
                                <div class="mt-2">
                                    <span class="badge bg-light text-dark me-1">Product Sellers</span>
                                    <span class="badge bg-light text-dark">Business Owners</span>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="vendor" value="vendor" {{ old('role', $user->current_role) === 'vendor' ? 'checked' : '' }}>
                                <label class="form-check-label w-100" for="vendor">
                                    Select Vendor Role
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-check-circle me-2"></i>Continue to Profile Setup
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', function() {
        // Remove active state from all cards
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('border-primary'));
        // Add active state to clicked card
        this.classList.add('border-primary');

        // Check the corresponding radio button
        const role = this.dataset.role;
        document.getElementById(role).checked = true;
    });
});
</script>

<style>
.role-card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.role-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.form-check-input:checked + .form-check-label {
    font-weight: 600;
}
</style>
@endsection