@extends('layouts.client')

@section('title', 'Job Messages')

@section('page-title', 'Job Messages')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('client.jobs.show', $job->id) }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left me-1"></i>Back to Job
            </a>
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-2 fw-bold">{{ $job->title }}</h2>
                    <p class="text-muted mb-0">Chat with freelancers about this project</p>
                </div>
                @php
                    $statusColors = [
                        'open' => 'success',
                        'in_progress' => 'warning',
                        'completed' => 'info',
                        'closed' => 'danger',
                        'draft' => 'secondary'
                    ];
                    $statusColor = $statusColors[$job->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $statusColor }} px-3 py-2">
                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-dots me-2 text-primary"></i>Messages
                        </h5>
                        <span class="badge bg-secondary">{{ $messages->count() }} messages</span>
                    </div>
                </div>
                <div class="card-body" style="height: 500px; overflow-y: auto;" id="messagesContainer">
                    @forelse($messages as $message)
                        <div class="message-item mb-3 {{ $message->user_id === auth()->id() ? 'text-end' : '' }}">
                            <div class="d-inline-block" style="max-width: 70%;">
                                <div class="d-flex align-items-center gap-2 mb-1 {{ $message->user_id === auth()->id() ? 'justify-content-end' : '' }}">
                                    @if($message->user_id !== auth()->id())
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 12px;">
                                            {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <strong class="small">{{ $message->user->name }}</strong>
                                    <span class="text-muted small">{{ $message->created_at->format('M d, h:i A') }}</span>
                                    @if($message->user_id === auth()->id())
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 12px;">
                                            {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3 rounded {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                                    {{ $message->message }}
                                </div>
                                @if($message->is_read && $message->user_id === auth()->id())
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-check-all"></i> Read {{ $message->read_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat display-1 text-muted"></i>
                            <p class="text-muted mt-3">No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>
                <div class="card-footer bg-white border-top">
                    <form action="{{ route('client.jobs.sendMessage', $job->id) }}" method="POST" id="messageForm">
                        @csrf
                        <div class="input-group">
                            <textarea
                                class="form-control @error('message') is-invalid @enderror"
                                name="message"
                                id="messageInput"
                                rows="2"
                                placeholder="Type your message here..."
                                required
                            ></textarea>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send me-1"></i>Send
                            </button>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text mt-2">
                            <i class="bi bi-info-circle me-1"></i>Press Ctrl+Enter to send quickly
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.message-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#messagesContainer {
    scroll-behavior: smooth;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5568d3 0%, #65398b 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll to bottom on load
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }

    // Ctrl+Enter to send
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');

    messageInput.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            messageForm.submit();
        }
    });

    // Auto-focus on input
    messageInput.focus();
});
</script>
@endsection
