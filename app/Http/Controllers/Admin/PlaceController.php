<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Province;
use App\Models\Tag;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with(['province', 'tags'])
            ->withCount('reviews')
            ->orderBy('name')
            ->get();
            
        return view('admin.places.index', compact('places'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.places.create', compact('provinces', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|alpha_dash|unique:places,id|max:100',
            'name' => 'required|string|max:100',
            'province_id' => 'required|string|exists:provinces,id',
            'tagline' => 'required|string|max:255',
            'image' => 'required|url|max:500',
            'location' => 'required|string|max:100',
            'best_time' => 'required|string|max:100',
            'entry_fee' => 'required|string|max:100',
            'quick_rating' => 'required|string|max:100',
            'about' => 'required|string',
            'about_image' => 'nullable|url|max:500',
            'map_link' => 'nullable|url|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ], [
            'id.alpha_dash' => 'The Place ID must be a slug format (e.g. angkor-wat) containing only letters, numbers, and dashes.',
        ]);

        $quick_info = [
            'location' => trim($request->location),
            'best_time' => trim($request->best_time),
            'entry_fee' => trim($request->entry_fee),
            'rating' => trim($request->quick_rating),
        ];

        $place = Place::create([
            'id' => strtolower($request->id),
            'name' => trim($request->name),
            'province_id' => $request->province_id,
            'tagline' => trim($request->tagline),
            'image' => trim($request->image),
            'quick_info' => $quick_info,
            'about' => trim($request->about),
            'about_image' => $request->about_image ? trim($request->about_image) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        if ($request->has('tags')) {
            $place->tags()->sync($request->tags);
        }

        return redirect()->route('admin.places.index')
            ->with('success', 'Place created successfully! 📍');
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        $provinces = Province::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.places.edit', compact('place', 'provinces', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $place = Place::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'province_id' => 'required|string|exists:provinces,id',
            'tagline' => 'required|string|max:255',
            'image' => 'required|url|max:500',
            'location' => 'required|string|max:100',
            'best_time' => 'required|string|max:100',
            'entry_fee' => 'required|string|max:100',
            'quick_rating' => 'required|string|max:100',
            'about' => 'required|string',
            'about_image' => 'nullable|url|max:500',
            'map_link' => 'nullable|url|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $quick_info = [
            'location' => trim($request->location),
            'best_time' => trim($request->best_time),
            'entry_fee' => trim($request->entry_fee),
            'rating' => trim($request->quick_rating),
        ];

        $place->update([
            'name' => trim($request->name),
            'province_id' => $request->province_id,
            'tagline' => trim($request->tagline),
            'image' => trim($request->image),
            'quick_info' => $quick_info,
            'about' => trim($request->about),
            'about_image' => $request->about_image ? trim($request->about_image) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        // Sync tags (if none selected, empty array to detach all)
        $place->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.places.index')
            ->with('success', 'Place updated successfully! 📝');
    }

    public function destroy($id)
    {
        $place = Place::findOrFail($id);
        
        // Pivot associations and child entities (reviews, hotels, foods, etc.) will cascade delete
        $place->delete();

        return redirect()->route('admin.places.index')
            ->with('success', 'Place deleted successfully.');
    }
}
