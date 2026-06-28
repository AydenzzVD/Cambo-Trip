<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PlaceRestaurantController extends Controller
{
    public function index($placeId)
    {
        $place = Place::findOrFail($placeId);
        $restaurants = $place->restaurants()->orderBy('name')->get();
        return view('admin.places.restaurants.index', compact('place', 'restaurants'));
    }

    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('admin.places.restaurants.create', compact('place'));
    }

    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'map_link' => 'nullable|url|max:500',
        ]);

        $place->restaurants()->create([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        return redirect()->route('admin.places.restaurants.index', $place->id)
            ->with('success', 'Restaurant added successfully! 🍽️');
    }

    public function edit($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $restaurant = Restaurant::where('place_id', $placeId)->findOrFail($id);
        return view('admin.places.restaurants.edit', compact('place', 'restaurant'));
    }

    public function update(Request $request, $placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $restaurant = Restaurant::where('place_id', $placeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'map_link' => 'nullable|url|max:500',
        ]);

        $restaurant->update([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
            'map_link' => $request->map_link ? trim($request->map_link) : null,
        ]);

        return redirect()->route('admin.places.restaurants.index', $place->id)
            ->with('success', 'Restaurant updated successfully! 📝');
    }

    public function destroy($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $restaurant = Restaurant::where('place_id', $placeId)->findOrFail($id);
        $restaurant->delete();

        return redirect()->route('admin.places.restaurants.index', $place->id)
            ->with('success', 'Restaurant removed successfully.');
    }
}
