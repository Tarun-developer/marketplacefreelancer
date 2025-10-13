<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Services\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('user');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $services = $query->paginate(10);

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'delivery_time' => 'required|integer|min:1',
        ]);

        $service = $request->user()->services()->create($request->all());

        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        $service->load('user');

        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'delivery_time' => 'required|integer|min:1',
        ]);

        $service->update($request->all());

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();

        return response()->json(null, 204);
    }
}
