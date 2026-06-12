<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Place;
use App\Models\Tag;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'provinces' => Province::count(),
            'places' => Place::count(),
            'tags' => Tag::count(),
            'reviews' => Review::count(),
            'users' => User::count(),
            'avg_rating' => round(Review::avg('rating') ?? 0, 1),
        ];

        $recentReviews = Review::with(['user', 'place'])
            ->latest()
            ->limit(5)
            ->get();

        $recentPlaces = Place::with('province')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReviews', 'recentPlaces'));
    }
}
