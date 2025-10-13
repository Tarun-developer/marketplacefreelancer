<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class FreelancerServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('user_id', auth()->id())->paginate(10);

        return view('freelancer.services.index', compact('services'));
    }

    public function create()
    {
        return view('freelancer.services.create');
    }

    public function store(Request $request)
    {
        // Logic to store service
        return redirect()->route('freelancer.services.index');
    }

    public function show(Service $service)
    {
        return view('freelancer.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('freelancer.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        // Logic to update service
        return redirect()->route('freelancer.services.index');
    }

    public function destroy(Service $service)
    {
        // Logic to delete service
        return redirect()->route('freelancer.services.index');
    }
}
