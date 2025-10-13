@php
    $user = auth()->user();
    $userRoles = $user->roles->pluck('name')->toArray();
    $currentRole = $user->current_role;

     $roleIcons = [
         'client' => 'bi-person-badge',
         'freelancer' => 'bi-briefcase',
         'vendor' => 'bi-shop',
         'customer' => 'bi-person',
         'admin' => 'bi-shield-check',
         'super_admin' => 'bi-shield-fill-check',
         'support' => 'bi-headset',
     ];

     $roleLabels = [
         'client' => 'Client',
         'freelancer' => 'Freelancer',
         'vendor' => 'Vendor',
         'customer' => 'Customer',
         'admin' => 'Admin',
         'super_admin' => 'Super Admin',
         'support' => 'Support',
     ];

     $roleColors = [
         'client' => 'primary',
         'freelancer' => 'success',
         'vendor' => 'info',
         'customer' => 'secondary',
         'admin' => 'danger',
         'super_admin' => 'danger',
         'support' => 'warning',
     ];
@endphp

@if(count($userRoles) > 1)
<div class="dropdown">
    <button class="btn btn-outline-{{ $roleColors[$currentRole] ?? 'secondary' }} btn-sm dropdown-toggle d-flex align-items-center"
            type="button"
            id="roleSwitcherDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false">
        <i class="bi {{ $roleIcons[$currentRole] ?? 'bi-person' }} me-2"></i>
        <span class="d-none d-md-inline">{{ $roleLabels[$currentRole] ?? 'User' }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="roleSwitcherDropdown" style="min-width: 250px;">
        <li class="dropdown-header">
            <i class="bi bi-arrows-angle-expand me-2"></i>
            Switch Dashboard
        </li>
        <li><hr class="dropdown-divider"></li>

        @foreach($userRoles as $role)
            <li>
                <a class="dropdown-item d-flex align-items-center {{ $role === $currentRole ? 'active' : '' }}"
                   href="#"
                   onclick="switchRole('{{ $role }}'); return false;">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <i class="bi {{ $roleIcons[$role] ?? 'bi-person' }} me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">{{ $roleLabels[$role] ?? ucfirst($role) }}</div>
                                @if($role === $currentRole)
                                    <small class="text-muted">Current</small>
                                @endif
                            </div>
                        </div>
                        @if($role === $currentRole)
                            <i class="bi bi-check-circle-fill text-{{ $roleColors[$role] ?? 'success' }}"></i>
                        @endif
                    </div>
                </a>
            </li>
        @endforeach

        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item" href="{{ route('dashboard') }}?view=all">
                <i class="bi bi-speedometer2 me-2"></i>
                User Dashboard (Overview)
            </a>
        </li>
        <li>
            <a class="dropdown-item text-muted" href="{{ route('dashboard.select-role') }}">
                <i class="bi bi-plus-circle me-2"></i>
                Buy New Role
            </a>
        </li>
    </ul>
</div>

<script>
function switchRole(role) {
    // Show loading state
    const button = document.getElementById('roleSwitcherDropdown');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Switching...';
    button.disabled = true;

    fetch('{{ route("settings.switch-role") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ role: role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert('Error switching role: ' + (data.error || 'Unknown error'));
            button.innerHTML = originalHTML;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error switching role. Please try again.');
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}
</script>

<style>
.dropdown-item.active {
    background-color: var(--bs-primary);
    color: white;
}

.dropdown-item:hover {
    background-color: rgba(0, 123, 255, 0.1);
}

.dropdown-item .bi-check-circle-fill {
    font-size: 1.2rem;
}

.dropdown-menu {
    border-radius: 0.5rem;
    border: none;
}

.dropdown-header {
    font-weight: 600;
    color: var(--bs-dark);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
@endif
