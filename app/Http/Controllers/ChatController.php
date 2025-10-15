<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Chat\Models\Conversation;
use App\Modules\Chat\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Auth::user()->conversations()->with(['users', 'messages' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($conversations->map(function ($conv) {
                return [
                    'id' => $conv->id,
                    'title' => $conv->title ?: $conv->users->where('id', '!=', auth()->id())->first()->name,
                    'last_message' => $conv->messages->first()->message ?? null,
                ];
            }));
        }

        return view('chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $conversation->load(['users', 'messages.user']);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'id' => $conversation->id,
                'title' => $conversation->title ?: $conversation->users->where('id', '!=', auth()->id())->first()->name,
                'messages' => $conversation->messages->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'user_id' => $msg->user_id,
                        'user' => ['name' => $msg->user->name],
                        'created_at' => $msg->created_at,
                    ];
                }),
            ]);
        }

        return view('chat.show', compact('conversation'));
    }

    public function store(Request $request)
    {
        \Log::info('Chat store request:', $request->all());

        $request->validate([
            'message' => 'required|string|max:1000',
            'conversation_id' => 'required|integer|exists:conversations,id',
        ]);

        $conversation = Conversation::where('id', $request->conversation_id)
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$conversation) {
            \Log::error('Conversation not found for user:', ['conversation_id' => $request->conversation_id, 'user_id' => Auth::id()]);
            return response()->json(['error' => 'Conversation not found or access denied.'], 403);
        }

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        \Log::info('Message created:', $message->toArray());

        return response()->json($message->load('user'));
    }

    public function getNewMessages(Request $request)
    {
        $conversationId = $request->route('conversation_id');
        $lastMessageId = $request->query('last_message_id');

        \Log::info('Polling request:', ['conversation_id' => $conversationId, 'last_message_id' => $lastMessageId]);

        try {
            $validated = $request->validate([
                'conversation_id' => 'required|integer|exists:conversations,id',
                'last_message_id' => 'nullable|numeric',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        }

        $conversation = Conversation::where('id', $conversationId)
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$conversation) {
            \Log::error('Conversation access denied:', ['conversation_id' => $conversationId, 'user_id' => Auth::id()]);
            return response()->json(['error' => 'Conversation not found or access denied.'], 403);
        }

        $query = Message::where('conversation_id', $conversationId)
            ->where('user_id', '!=', Auth::id())
            ->with('user');

        $lastMessageId = $lastMessageId ? (int) $lastMessageId : 0;
        if ($lastMessageId > 0) {
            $query->where('id', '>', $lastMessageId);
        }

        $newMessages = $query->orderBy('created_at')->get();

        \Log::info('Polling response:', ['count' => $newMessages->count()]);

        return response()->json($newMessages);
    }

    public function createConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $otherUser = User::find($request->user_id);

        // Check permissions based on roles
        if (!$this->canChatWith($otherUser)) {
            return back()->withErrors(['error' => 'You cannot start a conversation with this user.']);
        }

        // Check if conversation already exists
        $conversation = Auth::user()->conversations()
            ->whereHas('users', function ($query) use ($otherUser) {
                $query->where('user_id', $otherUser->id);
            })
            ->where('type', 'direct')
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create(['type' => 'direct']);
            $conversation->users()->attach([Auth::id(), $otherUser->id]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    private function canChatWith(User $otherUser)
    {
        $currentUser = Auth::user();

        // Admins and support can chat with anyone
        if ($currentUser->hasRole(['admin', 'super_admin', 'support'])) {
            return true;
        }

        // Clients can chat with freelancers, vendors, and support
        if ($currentUser->hasRole('client')) {
            return $otherUser->hasRole(['freelancer', 'vendor', 'support']);
        }

        // Freelancers can chat with clients, vendors, and support
        if ($currentUser->hasRole('freelancer')) {
            return $otherUser->hasRole(['client', 'vendor', 'support']);
        }

        // Vendors can chat with clients, freelancers, and support
        if ($currentUser->hasRole('vendor')) {
            return $otherUser->hasRole(['client', 'freelancer', 'support']);
        }

        return false;
    }
}