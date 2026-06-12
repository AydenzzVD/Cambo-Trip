<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function show($id)
    {
        $place = Place::with([
            'province', 'tags', 'activities', 'foods', 'hotels', 'restaurants', 'reviews.user'
        ])->where('id', $id)->firstOrFail();

        return view('place', compact('place'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $place = Place::findOrFail($id);
        $userId = auth()->id();

        // Check if the user has already reviewed this place
        $existingReview = Review::where('place_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this destination.');
        }

        Review::create([
            'place_id' => $id,
            'user_id' => $userId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your review has been submitted successfully! ⭐');
    }
}
