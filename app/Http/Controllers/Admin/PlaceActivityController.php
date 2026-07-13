<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Activity;
use Illuminate\Http\Request;

class PlaceActivityController extends Controller
{
    public function index($placeId)
    {
        $place = Place::findOrFail($placeId);
        $activities = $place->activities()->orderBy('name')->get();
        return view('admin.places.activities.index', compact('place', 'activities'));
    }

    public function create($placeId)
    {
        $place = Place::findOrFail($placeId);
        return view('admin.places.activities.create', compact('place'));
    }

    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $place->activities()->create([
            'name' => trim($request->name),
        ]);

        return redirect()->route('admin.places.activities.index', $place->id)
            ->with('success', 'Activity added successfully! 🚶');
    }

    public function edit($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $activity = Activity::where('place_id', $placeId)->findOrFail($id);
        return view('admin.places.activities.edit', compact('place', 'activity'));
    }

    public function update(Request $request, $placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $activity = Activity::where('place_id', $placeId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $activity->update([
            'name' => trim($request->name),
        ]);

        return redirect()->route('admin.places.activities.index', $place->id)
            ->with('success', 'Activity updated successfully! 📝');
    }

    public function destroy($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $activity = Activity::where('place_id', $placeId)->findOrFail($id);
        $activity->delete();

        return redirect()->route('admin.places.activities.index', $place->id)
            ->with('success', 'Activity removed successfully.');
    }
}
