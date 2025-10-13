<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Reviews\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'reviewable']);

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('flagged')) {
            $query->where('is_flagged', true);
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'reviewable']);
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Review approved successfully');
    }

    public function flag(Request $request, Review $review)
    {
        $validated = $request->validate([
            'flag_reason' => 'required|string',
        ]);

        $review->update([
            'is_flagged' => true,
            'flag_reason' => $validated['flag_reason'],
        ]);

        return redirect()->back()
            ->with('success', 'Review flagged successfully');
    }

    public function unflag(Review $review)
    {
        $review->update([
            'is_flagged' => false,
            'flag_reason' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Review unflagged successfully');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
    }
}
