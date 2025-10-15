<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Chat\Models\Conversation;
use App\Modules\Chat\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagingController extends Controller
{
    /**
     * Display all conversations for the authenticated user
     */
    public function index()
    {
        $user = auth()->user();

        // Get all conversations with latest message and unread count
        $conversations = $user->conversations()
            ->with(['users' => function ($query) use ($user) {
                $query->where('users.id', '!=', $user->id);
            }])
            ->withCount(['messages as unread_count' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id)
                      ->where('is_read', false);
            }])
            ->get()
            ->map(function ($conversation) use ($user) {
                // Get the other user(s) in the conversation
                $otherUsers = $conversation->users;

                // Get latest message
                $latestMessage = $conversation->messages()
                    ->with('user')
                    ->latest()
                    ->first();

                return [
                    'id' => $conversation->id,
                    'type' => $conversation->type,
                    'title' => $conversation->title ?: $otherUsers->pluck('name')->implode(', '),
                    'other_users' => $otherUsers,
                    'latest_message' => $latestMessage,
                    'unread_count' => $conversation->unread_count,
                    'updated_at' => $conversation->updated_at,
                ];
            })
            ->sortByDesc('updated_at');

        // Get layout based on user role
        $layout = $this->getLayoutForRole();

        return view('messages.index', compact('conversations', 'layout'));
    }

    /**
     * Show a specific conversation
     */
    public function show(Conversation $conversation)
    {
        $user = auth()->user();

        // Check if user is part of this conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403, 'Unauthorized access to this conversation');
        }

        // Get messages with user info
        $messages = $conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Get other users in conversation
        $otherUsers = $conversation->users()->where('users.id', '!=', $user->id)->get();

        $layout = $this->getLayoutForRole();

        return view('messages.show', compact('conversation', 'messages', 'otherUsers', 'layout'));
    }

    /**
     * Create a new conversation
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $recipientId = $request->query('user_id');

        $recipient = null;
        if ($recipientId) {
            $recipient = User::findOrFail($recipientId);
        }

        // Get eligible users based on role-based relationships
        $users = $this->getEligibleRecipients($user);

        $layout = $this->getLayoutForRole();

        return view('messages.create', compact('users', 'recipient', 'layout'));
    }

    /**
     * Get eligible recipients based on user role and relationships
     */
    private function getEligibleRecipients($user)
    {
        $userRole = $user->getRoleNames()->first();

        // Admin can chat with anyone
        if (in_array($userRole, ['super_admin', 'admin', 'manager'])) {
            return User::where('id', '!=', $user->id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        $eligibleUserIds = [];

        // Client can chat with:
        if ($user->hasRole('client')) {
            // 1. Freelancers who have submitted proposals/bids on their jobs
            $freelancerIds = DB::table('bids')
                ->join('marketplace_jobs', 'bids.job_id', '=', 'marketplace_jobs.id')
                ->where('marketplace_jobs.client_id', $user->id)
                ->distinct()
                ->pluck('bids.freelancer_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $freelancerIds);

            // 2. Freelancers whose services they have purchased
            $serviceSellerIds = DB::table('orders')
                ->where('orderable_type', 'App\\Modules\\Services\\Models\\Service')
                ->where('buyer_id', $user->id)
                ->join('services', 'orders.orderable_id', '=', 'services.id')
                ->distinct()
                ->pluck('services.user_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $serviceSellerIds);

            // 3. Vendors whose products they have purchased
            $productVendorIds = DB::table('orders')
                ->where('orderable_type', 'App\\Modules\\Products\\Models\\Product')
                ->where('buyer_id', $user->id)
                ->join('products', 'orders.orderable_id', '=', 'products.id')
                ->distinct()
                ->pluck('products.user_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $productVendorIds);

            // 4. Admins
            $adminIds = User::role(['super_admin', 'admin', 'manager'])->pluck('id')->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $adminIds);
        }

        // Freelancer can chat with:
        if ($user->hasRole('freelancer')) {
            // 1. Clients whose jobs they have bid on
            $clientIds = DB::table('bids')
                ->where('bids.freelancer_id', $user->id)
                ->join('marketplace_jobs', 'bids.job_id', '=', 'marketplace_jobs.id')
                ->distinct()
                ->pluck('marketplace_jobs.client_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $clientIds);

            // 2. Clients who have purchased their services
            $serviceBuyerIds = DB::table('orders')
                ->where('orderable_type', 'App\\Modules\\Services\\Models\\Service')
                ->join('services', 'orders.orderable_id', '=', 'services.id')
                ->where('services.user_id', $user->id)
                ->distinct()
                ->pluck('orders.buyer_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $serviceBuyerIds);

            // 3. Admins
            $adminIds = User::role(['super_admin', 'admin', 'manager'])->pluck('id')->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $adminIds);
        }

        // Vendor can chat with:
        if ($user->hasRole('vendor')) {
            // 1. Customers who have purchased their products
            $customerIds = DB::table('orders')
                ->where('orderable_type', 'App\\Modules\\Products\\Models\\Product')
                ->join('products', 'orders.orderable_id', '=', 'products.id')
                ->where('products.user_id', $user->id)
                ->distinct()
                ->pluck('orders.buyer_id')
                ->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $customerIds);

            // 2. Admins
            $adminIds = User::role(['super_admin', 'admin', 'manager'])->pluck('id')->toArray();
            $eligibleUserIds = array_merge($eligibleUserIds, $adminIds);
        }

        // Remove duplicates and current user
        $eligibleUserIds = array_unique($eligibleUserIds);
        $eligibleUserIds = array_diff($eligibleUserIds, [$user->id]);

        // Get users with role information
        return User::whereIn('id', $eligibleUserIds)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Store a new conversation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $user = auth()->user();
        $recipientId = $validated['recipient_id'];

        // Check if conversation already exists between these users
        $existingConversation = Conversation::whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->whereHas('users', function ($query) use ($recipientId) {
                $query->where('users.id', $recipientId);
            })
            ->where('type', 'direct')
            ->first();

        if ($existingConversation) {
            // Use existing conversation
            $conversation = $existingConversation;
        } else {
            // Create new conversation
            $conversation = Conversation::create([
                'type' => 'direct',
            ]);

            // Attach both users to the conversation
            $conversation->users()->attach([$user->id, $recipientId]);
        }

        // Create the message
        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message sent successfully!');
    }

    /**
     * Send a message in an existing conversation
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $user = auth()->user();

        // Check if user is part of this conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403, 'Unauthorized access to this conversation');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
            'file' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,zip',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('chat-files', 'public');
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
            'file_path' => $filePath,
            'is_read' => false,
        ]);

        // Update conversation timestamp
        $conversation->touch();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
            ]);
        }

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message sent successfully!');
    }

    /**
     * Get new messages for polling (AJAX)
     */
    public function getNewMessages(Conversation $conversation, Request $request)
    {
        $user = auth()->user();

        // Check if user is part of this conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        $lastMessageId = $request->query('last_message_id', 0);

        $newMessages = $conversation->messages()
            ->with('user')
            ->where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark new messages as read
        $conversation->messages()
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $newMessages,
        ]);
    }

    /**
     * Get unread message count (for navbar badge)
     */
    public function getUnreadCount()
    {
        $user = auth()->user();

        $unreadCount = Message::whereHas('conversation', function ($query) use ($user) {
                $query->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            })
            ->where('user_id', '!=', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'count' => $unreadCount,
        ]);
    }

    /**
     * Start conversation with a specific user
     */
    public function startConversation($userId)
    {
        $user = auth()->user();
        $recipient = User::findOrFail($userId);

        // Check if conversation already exists
        $conversation = Conversation::whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where('type', 'direct')
            ->first();

        if ($conversation) {
            return redirect()->route('messages.show', $conversation);
        }

        // Redirect to create with recipient pre-selected
        return redirect()->route('messages.create', ['user_id' => $userId]);
    }

    /**
     * Delete a conversation
     */
    public function destroy(Conversation $conversation)
    {
        $user = auth()->user();

        // Check if user is part of this conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403, 'Unauthorized access to this conversation');
        }

        // For now, just remove the user from the conversation
        // If all users leave, delete the conversation
        $conversation->users()->detach($user->id);

        if ($conversation->users()->count() === 0) {
            $conversation->messages()->delete();
            $conversation->delete();
        }

        return redirect()->route('messages.index')
            ->with('success', 'Conversation deleted successfully!');
    }

    /**
     * Get layout based on user role
     */
    private function getLayoutForRole()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('manager')) {
            return 'layouts.admin';
        } elseif ($user->hasRole('client')) {
            return 'layouts.client';
        } elseif ($user->hasRole('freelancer')) {
            return 'layouts.freelancer';
        } elseif ($user->hasRole('vendor')) {
            return 'layouts.vendor';
        }

        return 'layouts.dashboard';
    }
}
