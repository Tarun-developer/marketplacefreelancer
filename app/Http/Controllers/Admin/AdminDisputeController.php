<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Disputes\Models\Dispute;
use Illuminate\Http\Request;

class AdminDisputeController extends Controller
{
    public function index(Request $request)
    {
        $query = Dispute::with(['user', 'order']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $disputes = $query->latest()->paginate(15);

        return view('admin.disputes.index', compact('disputes'));
    }

    public function show(Dispute $dispute)
    {
        $dispute->load(['user', 'order', 'messages']);
        return view('admin.disputes.show', compact('dispute'));
    }

    public function update(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,investigating,resolved,closed',
            'resolution_notes' => 'nullable|string',
            'resolution' => 'nullable|in:favor_buyer,favor_seller,partial_refund,no_action',
        ]);

        $dispute->update($validated);

        if ($request->filled('resolution') && $dispute->status === 'resolved') {
            // Process the resolution (refund, notify parties, etc.)
            $this->processResolution($dispute, $request->resolution);
        }

        return redirect()->back()
            ->with('success', 'Dispute updated successfully');
    }

    public function resolve(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'resolution' => 'required|in:favor_buyer,favor_seller,partial_refund,no_action',
            'resolution_notes' => 'required|string',
        ]);

        $dispute->update([
            'status' => 'resolved',
            'resolution' => $validated['resolution'],
            'resolution_notes' => $validated['resolution_notes'],
            'resolved_at' => now(),
        ]);

        $this->processResolution($dispute, $validated['resolution']);

        return redirect()->route('admin.disputes.index')
            ->with('success', 'Dispute resolved successfully');
    }

    private function processResolution(Dispute $dispute, $resolution)
    {
        // Add logic here to process refunds, update orders, notify users, etc.
        // This would integrate with your payment and notification systems
    }
}
