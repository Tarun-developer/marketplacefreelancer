<?php

namespace App\Http\Controllers;

use App\Modules\Services\Models\Service;
use Illuminate\Http\Request;

class PublicServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('status', 'active')
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(12);

        return view('public.services.index', compact('services'));
    }

    public function category($category)
    {
        $services = Service::where('status', 'active')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(12);

        return view('public.services.category', compact('services', 'category'));
    }

    public function show(Service $service)
    {
        $service->load(['user', 'category', 'tags']);

        return view('public.services.show', compact('service'));
    }
}