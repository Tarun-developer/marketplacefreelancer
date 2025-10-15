@extends($layout)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-chat-dots me-2 text-primary"></i>New Message
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf

                        <!-- Recipient Selection -->
                        <div class="mb-4">
                            <label for="recipient_id" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Send to:
                            </label>
                            <select name="recipient_id" id="recipient_id" class="form-select @error('recipient_id') is-invalid @enderror" required>
                                <option value="">Select recipient...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ ($recipient && $recipient->id == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                        @if($user->roles->first())
                                            ({{ ucfirst($user->roles->first()->name) }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('recipient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message Input -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">
                                <i class="bi bi-chat-text me-1"></i>Message:
                            </label>
                            <textarea
                                name="message"
                                id="message"
                                rows="8"
                                class="form-control @error('message') is-invalid @enderror"
                                placeholder="Type your message here..."
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Maximum 5000 characters
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('messages.index') }}" class="btn btn-light">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send-fill me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="alert alert-info mt-4 border-0 shadow-sm">
                <h6 class="alert-heading fw-bold">
                    <i class="bi bi-lightbulb me-2"></i>Who Can You Message?
                </h6>
                <ul class="mb-0 small">
                    @php
                        $userRole = auth()->user()->getRoleNames()->first();
                    @endphp
                    @if(in_array($userRole, ['super_admin', 'admin']))
                        <li><strong>As Admin:</strong> You can message any user on the platform</li>
                    @elseif($userRole === 'client')
                        <li><strong>As Client:</strong> You can message:</li>
                        <li class="ms-3">• Freelancers who bid on your jobs</li>
                        <li class="ms-3">• Freelancers whose services you purchased</li>
                        <li class="ms-3">• Vendors whose products you purchased</li>
                        <li class="ms-3">• Platform administrators</li>
                    @elseif($userRole === 'freelancer')
                        <li><strong>As Freelancer:</strong> You can message:</li>
                        <li class="ms-3">• Clients whose jobs you bid on</li>
                        <li class="ms-3">• Clients who purchased your services</li>
                        <li class="ms-3">• Platform administrators</li>
                    @elseif($userRole === 'vendor')
                        <li><strong>As Vendor:</strong> You can message:</li>
                        <li class="ms-3">• Customers who purchased your products</li>
                        <li class="ms-3">• Platform administrators</li>
                    @endif
                    <li class="mt-2">Messages are private and only visible to you and the recipient</li>
                    <li>You can attach files in the conversation view</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5568d3 0%, #65398b 100%);
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter
    const messageTextarea = document.getElementById('message');
    const maxLength = 5000;

    messageTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        const formText = this.parentElement.querySelector('.form-text');

        if (remaining < 100) {
            formText.innerHTML = `<i class="bi bi-info-circle me-1"></i>${remaining} characters remaining`;
            formText.classList.add('text-warning');
        } else {
            formText.innerHTML = `<i class="bi bi-info-circle me-1"></i>Maximum 5000 characters`;
            formText.classList.remove('text-warning');
        }
    });

    // Select2 for better user selection (if available)
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#recipient_id').select2({
            placeholder: 'Search for a user...',
            allowClear: true,
            width: '100%'
        });
    }
});
</script>
@endsection
