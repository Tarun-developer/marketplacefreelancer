@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>Chat Conversations</h2>
    <div class="list-group">
        @foreach($conversations as $conversation)
            <a href="{{ route('chat.show', $conversation) }}" class="list-group-item list-group-item-action">
                <strong>{{ $conversation->title }}</strong>
                @if($conversation->messages->first())
                    <br><small class="text-muted">{{ $conversation->messages->first()->message }}</small>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endsection