@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>{{ $conversation->title }}</h2>
    <div class="chat-messages" style="max-height: 400px; overflow-y: auto;">
        @foreach($conversation->messages as $message)
            <div class="message {{ $message->user_id == auth()->id() ? 'sent' : 'received' }}">
                <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                <small>{{ $message->created_at->format('M d, H:i') }}</small>
            </div>
        @endforeach
    </div>
    <form method="POST" action="{{ route('chat.store') }}">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        <div class="input-group mt-3">
            <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>

<style>
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
</style>
@endsection