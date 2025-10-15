@extends($layout)

@section('content')
<div class="container-fluid px-0" style="height: calc(100vh - 80px);">
    <div class="row g-0 h-100">
        <!-- Conversations Sidebar -->
        <div class="col-12 col-md-4 col-lg-3 border-end bg-white h-100 d-flex flex-column">
            <!-- Header -->
            <div class="p-3 border-bottom bg-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-chat-dots me-2 text-primary"></i>Messages
                    </h5>
                    <a href="{{ route('messages.create') }}" class="btn btn-sm btn-primary rounded-circle" title="New Message">
                        <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Search conversations..." id="searchConversations">
                </div>
            </div>

            <!-- Conversations List -->
            <div class="flex-fill overflow-auto" id="conversationsList">
                @forelse($conversations as $conv)
                    <a href="{{ route('messages.show', $conv['id']) }}"
                       class="conversation-item d-block text-decoration-none border-bottom p-3 {{ request()->route('conversation') && request()->route('conversation')->id == $conv['id'] ? 'active' : '' }}"
                       data-conversation-id="{{ $conv['id'] }}">
                        <div class="d-flex align-items-start">
                            <!-- Avatar -->
                            <div class="flex-shrink-0 me-3">
                                @if($conv['other_users']->first())
                                    @php $otherUser = $conv['other_users']->first(); @endphp
                                    @if($otherUser->getFirstMediaUrl('avatar'))
                                        <img src="{{ $otherUser->getFirstMediaUrl('avatar', 'thumb') }}"
                                             alt="{{ $otherUser->name }}"
                                             class="rounded-circle"
                                             style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                             style="width: 48px; height: 48px; font-size: 18px;">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold"
                                         style="width: 48px; height: 48px; font-size: 18px;">
                                        <i class="bi bi-people"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Conversation Info -->
                            <div class="flex-fill" style="min-width: 0;">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-semibold text-truncate" style="max-width: 180px;">
                                        {{ $conv['title'] }}
                                    </h6>
                                    @if($conv['latest_message'])
                                        <small class="text-muted">
                                            {{ $conv['latest_message']->created_at->diffForHumans(null, true) }}
                                        </small>
                                    @endif
                                </div>
                                @if($conv['latest_message'])
                                    <p class="mb-0 text-muted small text-truncate">
                                        @if($conv['latest_message']->user_id === auth()->id())
                                            <i class="bi bi-check-all {{ $conv['latest_message']->is_read ? 'text-primary' : '' }}"></i>
                                        @endif
                                        {{ Str::limit($conv['latest_message']->message, 50) }}
                                    </p>
                                @endif
                                @if($conv['unread_count'] > 0)
                                    <span class="badge bg-primary rounded-pill mt-1">
                                        {{ $conv['unread_count'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-chat-text display-1 text-muted"></i>
                        <p class="text-muted mt-3">No conversations yet</p>
                        <a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>Start a conversation
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Empty State / Instructions -->
        <div class="col-12 col-md-8 col-lg-9 bg-light d-flex align-items-center justify-content-center">
            <div class="text-center px-4">
                <div class="mb-4">
                    <i class="bi bi-chat-dots display-1 text-primary"></i>
                </div>
                <h3 class="mb-3 fw-bold">Welcome to Messages</h3>
                <p class="text-muted mb-4">
                    Select a conversation from the left to start chatting,<br>
                    or click the + button to start a new conversation.
                </p>
                <a href="{{ route('messages.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Message
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.conversation-item {
    transition: all 0.2s ease;
    background-color: white;
}

.conversation-item:hover {
    background-color: #f8f9fa;
}

.conversation-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196F3;
}

#conversationsList {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

#conversationsList::-webkit-scrollbar {
    width: 6px;
}

#conversationsList::-webkit-scrollbar-track {
    background: #f7fafc;
}

#conversationsList::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 3px;
}
</style>

<script>
// Search conversations
document.getElementById('searchConversations')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const conversations = document.querySelectorAll('.conversation-item');

    conversations.forEach(conv => {
        const text = conv.textContent.toLowerCase();
        conv.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

// Poll for new messages every 10 seconds
setInterval(async function() {
    try {
        const response = await fetch('{{ route('messages.unread-count') }}');
        const data = await response.json();

        // Update badge if exists
        const badge = document.getElementById('messagesBadge');
        if (badge && data.count > 0) {
            badge.textContent = data.count;
            badge.style.display = 'inline-block';
        } else if (badge) {
            badge.style.display = 'none';
        }
    } catch (error) {
        console.error('Failed to fetch unread count:', error);
    }
}, 10000);
</script>
@endsection
