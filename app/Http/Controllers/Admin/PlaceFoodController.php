<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Food;
use Illuminate\Http\Request;

class PlaceFoodController extends Controller
{
    public function index($placeId)
    {
        $place = Place::findOrFail($placeId);
        $foods = $place->foods()->orderBy('name')->get();
        return view('admin.places.foods.index', compact('place', 'foods'));
    }

    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('admin.places.foods.create', compact('place'));
    }

    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        $place->foods()->create([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
        ]);

        return redirect()->route('admin.places.foods.index', $place->id)
            ->with('success', 'Food item added successfully! 🍲');
    }

    public function edit($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $food = Food::where('place_id', $placeId)->findOrFail($id);
        return view('admin.places.foods.edit', compact('place', 'food'));
    }

    public function update(Request $request, $placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $food = Food::where('place_id', $placeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        $food->update([
            'name' => trim($request->name),
            'image' => $request->image ? trim($request->image) : null,
            'description' => $request->description ? trim($request->description) : null,
        ]);

        return redirect()->route('admin.places.foods.index', $place->id)
            ->with('success', 'Food item updated successfully! 📝');
    }

    public function destroy($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $food = Food::where('place_id', $placeId)->findOrFail($id);
        $food->delete();

        return redirect()->route('admin.places.foods.index', $place->id)
            ->with('success', 'Food item removed successfully.');
    }
}
