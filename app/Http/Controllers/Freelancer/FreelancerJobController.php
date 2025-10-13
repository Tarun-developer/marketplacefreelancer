<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Job;

class FreelancerJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('status', 'open')->paginate(10);

        return view('freelancer.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('freelancer.jobs.show', compact('job'));
    }
}
