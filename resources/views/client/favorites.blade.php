@extends('layouts.client')

@section('title', 'My Favorites')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Favorite Services</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                @forelse($favoriteServices as $service)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($service->description, 100) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary">{{ $service->category->name ?? 'Uncategorized' }}</span>
                                    <strong class="text-success">${{ number_format($service->price, 2) }} {{ $service->currency }}</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">By {{ $service->user->name }}</small>
                                    <small class="text-muted">{{ $service->delivery_time }} days</small>
                                </div>

                                @if($service->tags->count() > 0)
                                    <div class="mb-3">
                                        @foreach($service->tags->take(3) as $tag)
                                            <span class="badge bg-outline-secondary me-1">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="d-grid gap-2">
                                    <a href="{{ route('client.services.show', $service) }}" class="btn btn-outline-primary">View Details</a>
                                    <button type="button" class="btn btn-outline-danger w-100 remove-favorite-btn" data-service-id="{{ $service->id }}">
                                        <i class="fas fa-heart-broken me-2"></i>Remove from Favorites
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-heart display-1 text-muted"></i>
                            <p class="text-muted mt-3">No favorite services yet.</p>
                            <a href="{{ route('client.services.index') }}" class="btn btn-primary">Browse Services</a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($favoriteServices->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $favoriteServices->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const removeBtns = document.querySelectorAll('.remove-favorite-btn');

    removeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Remove from favorites?')) {
                return;
            }

            const serviceId = this.dataset.serviceId;
            const url = `/client/services/${serviceId}/favorite`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the card from the page
                    this.closest('.col-lg-4').remove();
                    showAlert(data.message, 'success');
                } else {
                    showAlert('An error occurred', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred', 'danger');
            });
        });
    });

    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
@endpush

@endsection