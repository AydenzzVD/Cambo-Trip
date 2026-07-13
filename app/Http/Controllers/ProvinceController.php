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

        // Group places by their dedicated category column
        $groupedPlaces = [
            'Historical'        => collect(),
            'Culture'           => collect(),
            'Nature & Adventure'=> collect(),
            'Nightlife'         => collect(),
        ];

        foreach ($province->places as $place) {
            if ($place->category && isset($groupedPlaces[$place->category])) {
                $groupedPlaces[$place->category]->push($place);
            }
        }

        return view('province', compact('province', 'groupedPlaces'));
    }
}
