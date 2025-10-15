<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Modules\Services\Models\Service;
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
         $user = auth()->user();

         // Check service limit
         if ($user->services()->count() >= $user->getServiceLimit()) {
             return back()->with('error', 'You have reached your service limit. Upgrade your plan to create more services.');
         }

         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'category_id' => 'required|exists:categories,id',
             'price' => 'required|numeric|min:0',
             'currency' => 'required|string|in:USD,EUR,GBP',
             'delivery_time' => 'required|integer|min:1',
             'tags' => 'nullable|string',
         ]);

         $baseSlug = \Illuminate\Support\Str::slug($validated['title']);
         $slug = $baseSlug;
         $counter = 1;

         while (Service::where('slug', $slug)->exists()) {
             $slug = $baseSlug . '-' . $counter;
             $counter++;
         }

         $service = Service::create([
             'user_id' => $user->id,
             'title' => $validated['title'],
             'slug' => $slug,
             'description' => $validated['description'],
             'category_id' => $validated['category_id'],
             'price' => $validated['price'],
             'currency' => $validated['currency'],
             'delivery_time' => $validated['delivery_time'],
             'status' => 'active', // Assuming no approval needed for freelancers
         ]);

         // Handle tags if provided
         if ($validated['tags']) {
             $tagNames = array_map('trim', explode(',', $validated['tags']));
             foreach ($tagNames as $tagName) {
                 $tag = \App\Modules\Products\Models\Tag::firstOrCreate([
                     'name' => $tagName,
                     'slug' => \Illuminate\Support\Str::slug($tagName),
                 ]);
                 $service->tags()->attach($tag);
             }
         }

         return redirect()->route('freelancer.services.index')->with('success', 'Service created successfully.');
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
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'category_id' => 'required|exists:categories,id',
             'price' => 'required|numeric|min:0',
             'currency' => 'required|string|in:USD,EUR,GBP',
             'delivery_time' => 'required|integer|min:1',
             'tags' => 'nullable|string',
         ]);

         $service->update([
             'title' => $validated['title'],
             'slug' => \Illuminate\Support\Str::slug($validated['title']),
             'description' => $validated['description'],
             'category_id' => $validated['category_id'],
             'price' => $validated['price'],
             'currency' => $validated['currency'],
             'delivery_time' => $validated['delivery_time'],
         ]);

         // Update tags
         $service->tags()->detach();
         if ($validated['tags']) {
             $tagNames = array_map('trim', explode(',', $validated['tags']));
             foreach ($tagNames as $tagName) {
                 $tag = \App\Modules\Products\Models\Tag::firstOrCreate([
                     'name' => $tagName,
                     'slug' => \Illuminate\Support\Str::slug($tagName),
                 ]);
                 $service->tags()->attach($tag);
             }
         }

         return redirect()->route('freelancer.services.show', $service)->with('success', 'Service updated successfully.');
     }

     public function destroy(Service $service)
     {
         $service->delete();

         return redirect()->route('freelancer.services.index')->with('success', 'Service deleted successfully.');
     }

     public function profile()
     {
         $user = auth()->user();

         return view('freelancer.profile', compact('user'));
     }
}
