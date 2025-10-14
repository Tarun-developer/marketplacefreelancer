<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\SpmProject;
use Illuminate\Http\Request;

class FreelancerSpmController extends Controller
{
    public function index()
    {
        $projects = SpmProject::where('freelancer_id', auth()->id())
            ->with(['client', 'tasks'])
            ->latest()
            ->paginate(10);

        return view('freelancer.projects.index', compact('projects'));
    }

    public function show(SpmProject $project)
    {
        $project->load(['client', 'tasks', 'milestones']);

        return view('freelancer.projects.show', compact('project'));
    }
}