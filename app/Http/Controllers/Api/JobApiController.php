<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Jobs\Models\Job;
use Illuminate\Http\Request;

class JobApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('user');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $jobs = $query->paginate(10);

        return response()->json($jobs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        $job = $request->user()->jobs()->create($request->all());

        return response()->json($job, 201);
    }

    public function show(Job $job)
    {
        $job->load('user', 'bids');

        return response()->json($job);
    }

    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        $job->update($request->all());

        return response()->json($job);
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return response()->json(null, 204);
    }

    public function bids(Job $job)
    {
        $bids = $job->bids()->with('user')->get();

        return response()->json($bids);
    }

    public function placeBid(Request $request, Job $job)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'proposal' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        $bid = $job->bids()->create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'proposal' => $request->proposal,
            'duration' => $request->duration,
        ]);

        return response()->json($bid, 201);
    }
}
