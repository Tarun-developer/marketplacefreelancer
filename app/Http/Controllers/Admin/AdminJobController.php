<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Jobs\Models\Job;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
     public function index(Request $request)
     {
         $query = Job::with('client');

         if ($request->filled('search')) {
             $query->where('title', 'like', '%'.$request->search.'%');
         }

         if ($request->filled('status')) {
             $query->where('status', $request->status);
         }

         $jobs = $query->latest()->paginate(15);

         return view('admin.jobs.index', compact('jobs'));
     }

     public function show(Job $job)
     {
         $job->load(['client', 'bids.user']);

         return view('admin.jobs.show', compact('job'));
     }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

     public function update(Request $request, Job $job)
     {
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'budget_min' => 'required|numeric|min:0',
             'budget_max' => 'required|numeric|min:0',
             'status' => 'required|in:open,closed,in_progress,completed',
         ]);

         $job->update($validated);

         return redirect()->route('admin.jobs.index')
             ->with('success', 'Job updated successfully');
     }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully');
    }

    public function close(Job $job)
    {
        $job->update(['status' => 'closed']);

        return redirect()->back()
            ->with('success', 'Job closed successfully');
    }
}
