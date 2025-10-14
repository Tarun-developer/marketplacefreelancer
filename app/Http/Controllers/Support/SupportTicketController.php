<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Modules\Support\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::paginate(10);

        return view('support.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.tickets.create');
    }

    public function store(Request $request)
    {
        // Logic to store ticket
        return redirect()->route('support.tickets.index');
    }

    public function show(SupportTicket $ticket)
    {
        return view('support.tickets.show', compact('ticket'));
    }

    public function edit(SupportTicket $ticket)
    {
        return view('support.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        // Logic to update ticket
        return redirect()->route('support.tickets.index');
    }

    public function destroy(SupportTicket $ticket)
    {
        // Logic to delete ticket
        return redirect()->route('support.tickets.index');
    }
}
