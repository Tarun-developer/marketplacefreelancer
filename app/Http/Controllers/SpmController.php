<?php

namespace App\Http\Controllers;

use App\Models\SpmProject;
use App\Models\SpmTask;
use App\Models\SpmMilestone;
use App\Models\SpmTimesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpmController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('client')) {
            $projects = SpmProject::where('client_id', $user->id)->with(['freelancer'])->latest()->get();
        } else {
            $projects = SpmProject::where('freelancer_id', $user->id)->with(['client'])->latest()->get();
        }

        return view('spm.index', compact('projects'));
    }

    public function create()
    {
        return view('spm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
        ]);

        $project = SpmProject::create([
            'project_number' => 'SPM-' . time(),
            'client_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'deadline' => $request->deadline,
            'status' => 'pending',
        ]);

        return redirect()->route('spm.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(SpmProject $project)
    {
        $this->authorize('view', $project);

        $project->load(['tasks', 'milestones', 'timesheets', 'files']);

        return view('spm.show', compact('project'));
    }

    public function edit(SpmProject $project)
    {
        $this->authorize('update', $project);

        return view('spm.edit', compact('project'));
    }

    public function update(Request $request, SpmProject $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'deadline' => 'required|date',
        ]);

        $project->update($request->only(['title', 'description', 'budget', 'deadline']));

        return redirect()->route('spm.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(SpmProject $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('spm.index')->with('success', 'Project deleted successfully.');
    }
}