<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Reviews\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user', 'order');

        if ($request->has('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(10);
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = $request->user()->reviews()->create($request->all());
        return response()->json($review, 201);
    }

    public function show(Review $review)
    {
        $review->load('user', 'order');
        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review->update($request->all());
        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();
        return response()->json(null, 204);
    }
}