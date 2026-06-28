<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Hotel;
use Illuminate\Http\Request;

class PlaceHotelController extends Controller
{
    public function index($placeId)
    {
        $place = Place::findOrFail($placeId);
        $hotels = $place->hotels()->orderBy('name')->get();
        return view('admin.places.hotels.index', compact('place', 'hotels'));
    }

    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('admin.places.hotels.create', compact('place'));
    }

    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'price' => 'nullable|string|max:100',
            'map_link' => 'nullable|url|max:500',
        ]);

        $place->hotels()->create([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
            'price' => $request->price ? trim($request->price) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        return redirect()->route('admin.places.hotels.index', $place->id)
            ->with('success', 'Hotel added successfully! 🏨');
    }

    public function edit($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $hotel = Hotel::where('place_id', $placeId)->findOrFail($id);
        return view('admin.places.hotels.edit', compact('place', 'hotel'));
    }

    public function update(Request $request, $placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $hotel = Hotel::where('place_id', $placeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'price' => 'nullable|string|max:100',
            'map_link' => 'nullable|url|max:500',
        ]);

        $hotel->update([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
            'price' => $request->price ? trim($request->price) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        return redirect()->route('admin.places.hotels.index', $place->id)
            ->with('success', 'Hotel updated successfully! 📝');
    }

    public function destroy($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $hotel = Hotel::where('place_id', $placeId)->findOrFail($id);
        $hotel->delete();

        return redirect()->route('admin.places.hotels.index', $place->id)
            ->with('success', 'Hotel removed successfully.');
    }
}
