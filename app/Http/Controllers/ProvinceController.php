<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('destination', compact('provinces'));
    }

    public function show($id)
    {
        $province = Province::with(['places.tags'])->where('id', $id)->firstOrFail();

        $groupedPlaces = [
            'Historical' => [],
            'Culture' => [],
            'Nature & Adventure' => [],
            'Nightlife' => []
        ];

        foreach ($province->places as $place) {
            foreach ($place->tags as $tag) {
                if (in_array($tag->name, ['Temple', 'Historical', 'History'])) {
                    $groupedPlaces['Historical'][] = $place;
                }
                if (in_array($tag->name, ['Culture', 'Local'])) {
                    $groupedPlaces['Culture'][] = $place;
                }
                if (in_array($tag->name, ['Nature', 'Mountain', 'Beach', 'WaterFall', 'Island', 'Hiking'])) {
                    $groupedPlaces['Nature & Adventure'][] = $place;
                }
                if (in_array($tag->name, ['Night', 'Nightlife'])) {
                    $groupedPlaces['Nightlife'][] = $place;
                }
            }
        }

        // De-duplicate places in groups
        foreach ($groupedPlaces as $key => $list) {
            $groupedPlaces[$key] = collect($list)->unique('id')->values();
        }

        return view('province', compact('province', 'groupedPlaces'));
    }
}
