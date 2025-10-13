<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpmProject;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSpmController extends Controller
{
    public function index()
    {
        $projects = SpmProject::with(['client', 'freelancer'])->latest()->paginate(20);

        return view('admin.spm.index', compact('projects'));
    }

    public function show(SpmProject $project)
    {
        $project->load(['client', 'freelancer', 'tasks', 'milestones', 'timesheets']);

        return view('admin.spm.show', compact('project'));
    }

    public function edit(SpmProject $project)
    {
        return view('admin.spm.edit', compact('project'));
    }

    public function update(Request $request, SpmProject $project)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,on_hold,completed,cancelled',
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $project->update($request->only(['status', 'progress_percentage']));

        return redirect()->route('admin.spm.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(SpmProject $project)
    {
        $project->delete();

        return redirect()->route('admin.spm.index')->with('success', 'Project deleted successfully.');
    }
}