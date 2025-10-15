<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class PublicJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('status', 'open')
            ->with('client')
            ->latest()
            ->paginate(12);

        return view('public.jobs.index', compact('jobs'));
    }

    public function category($category)
    {
        $jobs = Job::where('status', 'open')
            ->where('category', $category)
            ->with('client')
            ->latest()
            ->paginate(12);

        return view('public.jobs.category', compact('jobs', 'category'));
    }

    public function show(Job $job)
    {
        $job->load('client');

        return view('public.jobs.show', compact('job'));
    }
}