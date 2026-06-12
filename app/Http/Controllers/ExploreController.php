<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Tag;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        // Get active tags from request query
        $activeTags = $request->input('tags', []);
        if (is_string($activeTags)) {
            $activeTags = array_filter(explode(',', $activeTags));
        }

        // Get all available tags for filters
        $allTags = Tag::orderBy('name')->get();

        $curatedIds = ['angkor-wat', 'koh-rong', 'tatai-waterfall', 'bokor-mountain', 'elephant-valley'];
        $popularIds = ['kep-crab-market', 'kampot-old-town', 'dak-dam-waterfall', 'pub-street', 'zipline-angkor'];

        // Curated query
        $curatedQuery = Place::with(['tags', 'reviews'])->whereIn('id', $curatedIds);
        // Popular query
        $popularQuery = Place::with(['tags', 'reviews'])->whereIn('id', $popularIds);

        if (!empty($activeTags)) {
            $curatedQuery->whereHas('tags', function ($q) use ($activeTags) {
                $q->whereIn('name', $activeTags);
            });
            $popularQuery->whereHas('tags', function ($q) use ($activeTags) {
                $q->whereIn('name', $activeTags);
            });
        }

        // Sort to preserve original order
        $curated = $curatedQuery->get()->sortBy(function ($p) use ($curatedIds) {
            return array_search($p->id, $curatedIds);
        })->values();

        $popular = $popularQuery->get()->sortBy(function ($p) use ($popularIds) {
            return array_search($p->id, $popularIds);
        })->values();

        return view('explore', compact('curated', 'popular', 'allTags', 'activeTags'));
    }
}
