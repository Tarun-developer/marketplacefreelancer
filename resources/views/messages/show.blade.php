@extends($layout)

@section('content')
<div class="container-fluid px-0" style="height: calc(100vh - 80px);">
    <div class="row g-0 h-100">
        <!-- Conversations Sidebar (Mobile Hidden) -->
        <div class="col-md-4 col-lg-3 border-end bg-white h-100 d-none d-md-flex flex-column">
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
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Search..." id="searchConversations">
                </div>
            </div>

            <!-- Conversations List -->
            <div class="flex-fill overflow-auto">
                @foreach(auth()->user()->conversations()->with(['users', 'messages'])->get() as $conv)
                    <a href="{{ route('messages.show', $conv) }}"
                       class="conversation-item d-block text-decoration-none border-bottom p-3 {{ $conv->id == $conversation->id ? 'active' : '' }}">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                @php $otherUser = $conv->users->where('id', '!=', auth()->id())->first(); @endphp
                                @if($otherUser)
                                    @if($otherUser->getFirstMediaUrl('avatar'))
                                        <img src="{{ $otherUser->getFirstMediaUrl('avatar', 'thumb') }}"
                                             alt="{{ $otherUser->name }}"
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="flex-fill" style="min-width: 0;">
                                <h6 class="mb-0 small fw-semibold text-truncate">
                                    {{ $otherUser ? $otherUser->name : 'Group Chat' }}
                                </h6>
                                @php $lastMsg = $conv->messages()->latest()->first(); @endphp
                                @if($lastMsg)
                                    <p class="mb-0 text-muted small text-truncate">
                                        {{ Str::limit($lastMsg->message, 30) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-12 col-md-8 col-lg-9 bg-white h-100 d-flex flex-column position-relative">
            <!-- Chat Header -->
            <div class="border-bottom p-3 bg-light">
                <div class="d-flex align-items-center">
                    <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light d-md-none me-2">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    @if($otherUsers->count() > 0)
                        @php $otherUser = $otherUsers->first(); @endphp
                        <div class="flex-shrink-0 me-3">
                            @if($otherUser->getFirstMediaUrl('avatar'))
                                <img src="{{ $otherUser->getFirstMediaUrl('avatar', 'thumb') }}"
                                     alt="{{ $otherUser->name }}"
                                     class="rounded-circle"
                                     style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-center fw-bold"
                                     style="width: 48px; height: 48px; font-size: 20px;">
                                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-fill">
                            <h6 class="mb-0 fw-bold">{{ $otherUser->name }}</h6>
                            <small class="text-muted">
                                @if($otherUser->roles->first())
                                    {{ ucfirst($otherUser->roles->first()->name) }}
                                @else
                                    User
                                @endif
                            </small>
                        </div>
                    @else
                        <div class="flex-fill">
                            <h6 class="mb-0 fw-bold">{{ $conversation->title ?? 'Group Chat' }}</h6>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('messages.destroy', $conversation) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this conversation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash me-2"></i>Delete Conversation
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="flex-fill overflow-auto p-4 position-relative" id="messagesContainer" style="background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);">
                <div id="messagesList">
                    @foreach($messages as $message)
                        <div class="message-bubble mb-3 {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}" data-message-id="{{ $message->id }}">
                            @if($message->user_id !== auth()->id())
                                <div class="d-flex align-items-end mb-2">
                                    <div class="flex-shrink-0 me-2">
                                        @if($message->user->getFirstMediaUrl('avatar'))
                                            <img src="{{ $message->user->getFirstMediaUrl('avatar', 'thumb') }}"
                                                 alt="{{ $message->user->name }}"
                                                 class="rounded-circle"
                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                 style="width: 32px; height: 32px; font-size: 14px;">
                                                {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="message-content bg-white border shadow-sm rounded-3 p-3" style="max-width: 70%;">
                                        <small class="text-primary fw-semibold d-block mb-1">{{ $message->user->name }}</small>
                                        <p class="mb-1">{{ $message->message }}</p>
                                        @if($message->file_path)
                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-paperclip"></i> Attachment
                                            </a>
                                        @endif
                                        <small class="text-muted d-block mt-1">{{ $message->created_at->format('g:i A') }}</small>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-end justify-content-end mb-2">
                                    <div class="message-content bg-primary text-white rounded-3 p-3 shadow-sm" style="max-width: 70%;">
                                        <p class="mb-1">{{ $message->message }}</p>
                                        @if($message->file_path)
                                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="btn btn-sm btn-light">
                                                <i class="bi bi-paperclip"></i> Attachment
                                            </a>
                                        @endif
                                        <div class="d-flex align-items-center justify-content-end mt-1">
                                            <small class="me-2">{{ $message->created_at->format('g:i A') }}</small>
                                            <i class="bi bi-check-all {{ $message->is_read ? '' : 'opacity-50' }}"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Message Input -->
            <div class="border-top p-3 bg-light">
                <form action="{{ route('messages.send', $conversation) }}" method="POST" id="messageForm" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <button type="button" class="btn btn-light" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="file" id="fileInput" name="file" class="d-none" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip">
                        <textarea
                            class="form-control border-0"
                            name="message"
                            id="messageInput"
                            rows="1"
                            placeholder="Type a message..."
                            required
                            style="resize: none; max-height: 120px;"
                        ></textarea>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                    <div id="filePreview" class="mt-2"></div>
                    @error('message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.conversation-item {
    transition: all 0.2s ease;
}

.conversation-item:hover {
    background-color: #f8f9fa;
}

.conversation-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196F3;
}

.message-bubble {
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
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

#messagesContainer::-webkit-scrollbar {
    width: 6px;
}

#messagesContainer::-webkit-scrollbar-track {
    background: #f7fafc;
}

#messagesContainer::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 3px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');

    // Auto-scroll to bottom
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    scrollToBottom();

    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // File preview
    fileInput.addEventListener('change', function() {
        if (this.files[0]) {
            filePreview.innerHTML = `
                <div class="alert alert-info py-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-paperclip me-2"></i>${this.files[0].name}</span>
                    <button type="button" class="btn-close btn-sm" onclick="document.getElementById('fileInput').value=''; document.getElementById('filePreview').innerHTML=''"></button>
                </div>
            `;
        }
    });

    // Poll for new messages every 5 seconds
    let lastMessageId = {{ $messages->last()->id ?? 0 }};

    setInterval(async function() {
        try {
            const response = await fetch(`{{ route('messages.get-new', $conversation) }}?last_message_id=${lastMessageId}`);
            const data = await response.json();

            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    addMessageToChat(msg);
                    lastMessageId = msg.id;
                });
                scrollToBottom();

                // Play notification sound
                playNotificationSound();
            }
        } catch (error) {
            console.error('Failed to fetch new messages:', error);
        }
    }, 5000);

    function addMessageToChat(message) {
        const messagesList = document.getElementById('messagesList');
        const isSent = message.user_id === {{ auth()->id() }};

        const messageHtml = `
            <div class="message-bubble mb-3 ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
                ${!isSent ? `
                <div class="d-flex align-items-end mb-2">
                    <div class="flex-shrink-0 me-2">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width: 32px; height: 32px; font-size: 14px;">
                            ${message.user.name.charAt(0).toUpperCase()}
                        </div>
                    </div>
                    <div class="message-content bg-white border shadow-sm rounded-3 p-3" style="max-width: 70%;">
                        <small class="text-primary fw-semibold d-block mb-1">${message.user.name}</small>
                        <p class="mb-1">${message.message}</p>
                        <small class="text-muted d-block mt-1">${new Date(message.created_at).toLocaleTimeString()}</small>
                    </div>
                </div>
                ` : `
                <div class="d-flex align-items-end justify-content-end mb-2">
                    <div class="message-content bg-primary text-white rounded-3 p-3 shadow-sm" style="max-width: 70%;">
                        <p class="mb-1">${message.message}</p>
                        <div class="d-flex align-items-center justify-content-end mt-1">
                            <small class="me-2">${new Date(message.created_at).toLocaleTimeString()}</small>
                            <i class="bi bi-check-all ${message.is_read ? '' : 'opacity-50'}"></i>
                        </div>
                    </div>
                </div>
                `}
            </div>
        `;

        messagesList.insertAdjacentHTML('beforeend', messageHtml);
    }

    function playNotificationSound() {
        // Simple beep sound
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTcIGWi77eeeTRAMUKfj8LZjHAY4ktfy' );
        audio.play().catch(() => {});
    }

    // Submit form on Enter (not Shift+Enter)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.submit();
        }
    });
});
</script>
@endsection
