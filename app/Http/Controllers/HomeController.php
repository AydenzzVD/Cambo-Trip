<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch top destinations based on average rating + number of reviews
        $places = Place::with('reviews')->get();

        // Sort by average rating desc, then reviews count desc
        $topPlaces = $places->sortByDesc(function ($place) {
            return ($place->average_rating * 1000) + $place->reviews_count;
        });

        // Fallback to original curated places if there are no reviews yet
        if ($topPlaces->first() && $topPlaces->first()->reviews_count === 0) {
            $curatedIds = ['angkor-wat', 'koh-rong', 'tatai-waterfall', 'bokor-mountain', 'elephant-valley'];
            $topPlaces = Place::whereIn('id', $curatedIds)
                ->get()
                ->sortBy(function ($place) use ($curatedIds) {
                    return array_search($place->id, $curatedIds);
                });
        } else {
            $topPlaces = $topPlaces->take(5);
        }

        return view('index', compact('topPlaces'));
    }
}
