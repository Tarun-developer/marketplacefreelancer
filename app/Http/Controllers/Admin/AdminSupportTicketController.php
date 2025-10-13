<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Support\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(20);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'messages']);
        $supportStaff = User::role('support')->get();

        return view('admin.tickets.show', compact('ticket', 'supportStaff'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->back()
            ->with('success', 'Ticket updated successfully');
    }

    public function assign(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->back()
            ->with('success', 'Ticket assigned successfully');
    }

    public function close(SupportTicket $ticket)
    {
        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Ticket closed successfully');
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // Add reply logic here (create message, send notification, etc.)

        return redirect()->back()
            ->with('success', 'Reply sent successfully');
    }
}
