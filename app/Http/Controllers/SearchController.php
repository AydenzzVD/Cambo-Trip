<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));
        $category = trim($request->input('category', ''));

        // Synonym mapping dictionary
        $synonymMap = [
            'sea' => 'beach',
            'mountain' => 'nature',
            'water' => 'waterfall',
            'temples' => 'temple',
            'islands' => 'island',
        ];

        // Gather all search queries, including synonyms
        $searchTerms = [];
        if (!empty($query)) {
            $searchTerms[] = $query;
            $lowerQuery = strtolower($query);
            foreach ($synonymMap as $synKey => $synVal) {
                if (str_contains($lowerQuery, $synKey)) {
                    $searchTerms[] = $synVal;
                }
            }
        }

        $placesQuery = Place::with(['province', 'tags', 'reviews']);

        // Filter by text search
        if (!empty($query)) {
            $placesQuery->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('name', 'like', "%{$term}%")
                      ->orWhere('tagline', 'like', "%{$term}%")
                      ->orWhere('about', 'like', "%{$term}%")
                      ->orWhereHas('province', function ($sub) use ($term) {
                          $sub->where('name', 'like', "%{$term}%");
                      })
                      ->orWhereHas('tags', function ($sub) use ($term) {
                          $sub->where('name', 'like', "%{$term}%");
                      });
                }
            });
        }

        // Filter by category tag directly
        if (!empty($category)) {
            $placesQuery->whereHas('tags', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }

        $places = $placesQuery->get();

        return view('search', compact('places', 'query', 'category'));
    }
}
