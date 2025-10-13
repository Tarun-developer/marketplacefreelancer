<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Chat\Models\Conversation;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function conversations(Request $request)
    {
        $conversations = $request->user()->conversations()->with('participants')->get();

        return response()->json($conversations);
    }

    public function conversation(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $conversation->load('messages', 'participants');

        return response()->json($conversation);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return response()->json($message, 201);
    }

    public function startConversation(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::create();
        $conversation->participants()->attach([$request->user()->id, $request->participant_id]);

        $message = $conversation->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return response()->json($conversation->load('messages', 'participants'), 201);
    }
}
