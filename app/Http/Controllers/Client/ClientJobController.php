<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class ClientJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('user_id', auth()->id())->paginate(10);

        return view('client.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('client.jobs.create');
    }

    public function store(Request $request)
    {
        // Logic to store job
        return redirect()->route('client.jobs.index');
    }

    public function show(Job $job)
    {
        return view('client.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('client.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        // Logic to update job
        return redirect()->route('client.jobs.index');
    }

    public function destroy(Job $job)
    {
        // Logic to delete job
        return redirect()->route('client.jobs.index');
    }
}
