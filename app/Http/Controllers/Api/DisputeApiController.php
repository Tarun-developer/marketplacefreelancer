<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Disputes\Models\Dispute;
use Illuminate\Http\Request;

class DisputeApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Dispute::with('user', 'order');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        $disputes = $query->paginate(10);
        return response()->json($disputes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        $dispute = $request->user()->disputes()->create($request->all());
        return response()->json($dispute, 201);
    }

    public function show(Dispute $dispute)
    {
        $this->authorize('view', $dispute);

        $dispute->load('user', 'order');
        return response()->json($dispute);
    }

    public function update(Request $request, Dispute $dispute)
    {
        $this->authorize('update', $dispute);

        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $dispute->update($request->only('status'));
        return response()->json($dispute);
    }

    public function destroy(Dispute $dispute)
    {
        $this->authorize('delete', $dispute);

        $dispute->delete();
        return response()->json(null, 204);
    }
}