<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\Services\Models\Service;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['user', 'category', 'tags'])
            ->where('status', 'active')
            ->paginate(12);

        return view('client.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $service->load(['user', 'category', 'tags']);

        return view('client.services.show', compact('service'));
    }

    public function purchase(Request $request, Service $service)
    {
        $request->validate([
            'requirements' => 'required|string',
        ]);

        // Create service order
        $order = \App\Models\Order::create([
            'buyer_id' => auth()->id(),
            'seller_id' => $service->user_id,
            'orderable_type' => \App\Modules\Services\Models\Service::class,
            'orderable_id' => $service->id,
            'amount' => $service->price,
            'currency' => $service->currency,
            'status' => 'pending',
            'payment_status' => 'pending',
            'requirements' => $request->requirements,
        ]);

         return redirect()->route('client.orders.show', $order)->with('success', 'Service purchased successfully. Please complete payment.');
     }

     public function toggleFavorite(\App\Modules\Services\Models\Service $service)
     {
         $isFavorite = auth()->user()->toggleFavorite($service);

         return response()->json([
             'success' => true,
             'is_favorite' => $isFavorite,
             'message' => $isFavorite ? 'Added to favorites' : 'Removed from favorites',
         ]);
     }

     public function removeFavorite(\App\Modules\Services\Models\Service $service)
     {
         auth()->user()->favorites()->where('favorable_type', \App\Modules\Services\Models\Service::class)->where('favorable_id', $service->id)->delete();

         return response()->json([
             'success' => true,
             'message' => 'Removed from favorites',
         ]);
     }
 }