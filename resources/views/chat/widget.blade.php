<div id="chat-widget" class="chat-widget minimized">
    <div class="chat-header" onclick="if(typeof toggleChat === 'function') toggleChat(); else console.error('toggleChat not defined');">
        <i class="bi bi-chat-dots"></i>
        <span class="chat-title">Chat</span>
        <span class="chat-badge" id="unread-count" style="display: none;">0</span>
    </div>
    <div class="chat-body" id="chat-body" style="display: none;">
        <div class="chat-conversations" id="conversations-list">
            <!-- Conversations will be loaded here -->
        </div>
        <div class="chat-messages" id="messages-container" style="display: none;">
            <div class="chat-messages-header">
                <span id="current-conversation-title">Select a conversation</span>
                <button onclick="closeChat()" class="btn btn-sm btn-outline-secondary">×</button>
            </div>
            <div class="chat-messages-body" id="messages-list">
                <!-- Messages will be loaded here -->
            </div>
            <div class="chat-input-container">
                <input type="text" id="message-input" class="form-control" placeholder="Type a message..." onkeypress="if(event.key==='Enter' && currentConversationId) sendMessage();">
                <button onclick="sendMessage()" class="btn btn-primary" id="send-button" disabled>Send</button>
            </div>
        </div>
    </div>
</div>

<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    max-height: 500px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    z-index: 1000;
    transition: all 0.3s ease;
}

.chat-widget.minimized {
    height: 60px;
}

.chat-widget.maximized {
    height: 500px;
}

.chat-header {
    padding: 15px;
    background: #007bff;
    color: white;
    border-radius: 10px 10px 0 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chat-badge {
    background: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: bold;
}

.chat-body {
    max-height: 440px;
    overflow: hidden;
}

.chat-conversations {
    max-height: 400px;
    overflow-y: auto;
}

.chat-messages {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.chat-messages-header {
    padding: 10px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-messages-body {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.chat-input-container {
    padding: 10px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    position: sticky;
    bottom: 0;
    background: white;
}

.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 18px;
    max-width: 80%;
}

.message.sent {
    background: #007bff;
    color: white;
    margin-left: auto;
    text-align: right;
}

.message.received {
    background: #f1f1f1;
    color: #333;
}

.conversation-item {
    padding: 10px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
}

.conversation-item:hover {
    background: #f8f9fa;
}

.conversation-item.active {
    background: #e3f2fd;
}
</style>

<script>
var currentConversationId = null;

if (typeof toggleChat === 'undefined') {
    function toggleChat() {
        const widget = document.getElementById('chat-widget');
        const body = document.getElementById('chat-body');
        
        if (widget.classList.contains('minimized')) {
            widget.classList.remove('minimized');
            widget.classList.add('maximized');
            body.style.display = 'block';
            loadConversations();
        } else {
            widget.classList.remove('maximized');
            widget.classList.add('minimized');
            body.style.display = 'none';
            document.getElementById('messages-container').style.display = 'none';
            document.getElementById('conversations-list').style.display = 'block';
        }
    }
}

function loadConversations() {
    fetch('{{ route("chat.index") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const list = document.getElementById('conversations-list');
            list.innerHTML = '';
            if (data.length === 0) {
                list.innerHTML = '<p class="text-center text-muted p-3">No conversations yet. <a href="#" onclick="alert(\'Feature to start new conversation coming soon!\')">Start a conversation</a></p>';
                return;
            }
            data.forEach(conv => {
                const item = document.createElement('div');
                item.className = 'conversation-item';
                item.onclick = () => openConversation(conv.id, conv.title);
                item.innerHTML = `
                    <strong>${conv.title}</strong><br>
                    <small>${conv.last_message || 'No messages yet'}</small>
                `;
                list.appendChild(item);
            });
        })
        .catch(error => {
            console.error('Error loading conversations:', error);
            document.getElementById('conversations-list').innerHTML = '<p class="text-center text-danger p-3">Error loading conversations</p>';
        });
}

function openConversation(id, title) {
    const conversationId = parseInt(id);
    if (isNaN(conversationId)) {
        alert('Invalid conversation ID');
        return;
    }
    
    currentConversationId = conversationId;
    console.log('Opening conversation:', conversationId, title);
    document.getElementById('current-conversation-title').textContent = title;
    document.getElementById('conversations-list').style.display = 'none';
    document.getElementById('messages-container').style.display = 'block';
    loadMessages(conversationId);
    startPolling(conversationId);
    
    // Enable send button
    document.getElementById('send-button').disabled = false;
}

function loadMessages(conversationId) {
    fetch(`{{ url('/chat') }}/${conversationId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('messages-list');
            list.innerHTML = '';
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message ${msg.user_id == {{ auth()->id() }} ? 'sent' : 'received'}`;
                    messageDiv.innerHTML = `
                        <strong>${msg.user.name}:</strong> ${msg.message}
                        <small>${new Date(msg.created_at).toLocaleTimeString()}</small>
                    `;
                    list.appendChild(messageDiv);
                    const msgId = parseInt(msg.id);
                    if (!isNaN(msgId)) {
                        lastMessageId = Math.max(lastMessageId, msgId);
                    }
                });
            } else {
                list.innerHTML = '<p class="text-center text-muted">No messages yet</p>';
            }
            list.scrollTop = list.scrollHeight;
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            document.getElementById('messages-list').innerHTML = '<p class="text-center text-danger">Error loading messages</p>';
        });
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    
    if (!message) {
        alert('Please enter a message.');
        return;
    }
    
    if (!currentConversationId) {
        alert('Please select a conversation first.');
        return;
    }
    
    const conversationId = parseInt(currentConversationId);
    if (isNaN(conversationId)) {
        alert('Invalid conversation selected.');
        return;
    }
    
    const payload = {
        message: message,
        conversation_id: conversationId
    };
    console.log('Sending message payload:', payload);

    fetch('{{ route("chat.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(err.message || 'Unknown error'); });
        }
        return response.json();
    })
    .then(data => {
        input.value = '';
        // Reload messages to show the sent message
        loadMessages(currentConversationId);
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Error sending message: ' + error.message);
    });
}

function closeChat() {
    document.getElementById('messages-container').style.display = 'none';
    document.getElementById('conversations-list').style.display = 'block';
    currentConversationId = null;
}

// Global variables
var currentConversationId = null;
let pollingInterval = null;
let lastMessageId = 0;

function startPolling(conversationId) {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }

    pollingInterval = setInterval(() => {
        const params = new URLSearchParams();
        if (lastMessageId && lastMessageId > 0 && !isNaN(lastMessageId)) {
            params.append('last_message_id', Math.floor(lastMessageId));
        }
        const url = `{{ url('/chat') }}/${conversationId}/new-messages${params.toString() ? '?' + params.toString() : ''}`;
        
        console.log('Polling URL:', url);
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    console.error('Polling response not ok:', response.status, response.statusText);
                    throw new Error(`Polling failed: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.length > 0) {
                    const list = document.getElementById('messages-list');
                    data.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message received`;
                        messageDiv.innerHTML = `
                            <strong>${msg.user.name}:</strong> ${msg.message}
                            <small>${new Date(msg.created_at).toLocaleTimeString()}</small>
                        `;
                        list.appendChild(messageDiv);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                    });
                    list.scrollTop = list.scrollHeight;
                }
            })
            .catch(error => console.error('Error polling messages:', error));
    }, 3000); // Poll every 3 seconds
}

function stopPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
}
</script>