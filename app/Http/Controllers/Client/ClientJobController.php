<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\Jobs\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('client_id', auth()->id())
            ->with('bids')
            ->latest()
            ->paginate(10);

        return view('client.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('client.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|min:1|gte:budget_min',
            'duration' => 'nullable|string|max:100',
            'skills_required' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
        ]);

        // Process skills
        if (!empty($validated['skills_required'])) {
            $skills = array_map('trim', explode(',', $validated['skills_required']));
            $validated['skills_required'] = $skills;
        } else {
            $validated['skills_required'] = [];
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

        // Set client ID
        $validated['client_id'] = auth()->id();

        // Set status based on submit button
        $validated['status'] = $request->input('status', 'open');

        // Set default currency
        $validated['currency'] = 'USD';

        $job = Job::create($validated);

        return redirect()->route('client.jobs.show', $job->id)
            ->with('success', 'Job posted successfully!');
    }

    public function show(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        $job->load('bids.freelancer');

        return view('client.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        return view('client.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|min:1|gte:budget_min',
            'duration' => 'nullable|string|max:100',
            'skills_required' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
            'status' => 'required|in:draft,open,in_progress,completed,closed',
        ]);

        // Process skills
        if (!empty($validated['skills_required'])) {
            $skills = array_map('trim', explode(',', $validated['skills_required']));
            $validated['skills_required'] = $skills;
        } else {
            $validated['skills_required'] = [];
        }

        // Update slug if title changed
        if ($job->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        $job->update($validated);

        return redirect()->route('client.jobs.show', $job->id)
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        // Don't allow deletion if there are accepted bids
        if ($job->bids()->where('status', 'accepted')->exists()) {
            return redirect()->route('client.jobs.index')
                ->with('error', 'Cannot delete job with accepted bids. Please complete or close the job first.');
        }

        $job->delete();

        return redirect()->route('client.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

    public function favorites()
    {
        // Placeholder for favorites functionality
        return view('client.favorites');
    }
}
