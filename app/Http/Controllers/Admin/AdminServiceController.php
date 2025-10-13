<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Services\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('user')->latest()->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $service->load(['user', 'offers']);

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'delivery_time' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }

    public function approve(Service $service)
    {
        $service->update(['status' => 'active']);

        return redirect()->back()
            ->with('success', 'Service approved successfully');
    }

    public function suspend(Service $service)
    {
        $service->update(['status' => 'suspended']);

        return redirect()->back()
            ->with('success', 'Service suspended successfully');
    }
}
