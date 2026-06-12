<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::withCount('places')->orderBy('name')->get();
        return view('admin.provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.provinces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|alpha_dash|unique:provinces,id|max:100',
            'name' => 'required|string|max:100|unique:provinces,name',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|url|max:500',
        ], [
            'id.alpha_dash' => 'The Province ID must be a slug format (e.g. siem-reap, cambodia-coast) containing only letters, numbers, and dashes.',
        ]);

        Province::create([
            'id' => strtolower($request->id),
            'name' => trim($request->name),
            'tagline' => trim($request->tagline),
            'description' => trim($request->description),
            'image' => trim($request->image),
            'sections' => [], // Default empty array for JSON structure
        ]);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province created successfully! 🗺️');
    }

    public function edit($id)
    {
        $province = Province::findOrFail($id);
        return view('admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:provinces,name,' . $province->id,
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|url|max:500',
        ]);

        $province->update([
            'name' => trim($request->name),
            'tagline' => trim($request->tagline),
            'description' => trim($request->description),
            'image' => trim($request->image),
        ]);

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province updated successfully! 📝');
    }

    public function destroy($id)
    {
        $province = Province::findOrFail($id);
        
        // Cascade deleting places is supported by foreign keys at database level
        $province->delete();

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province and all associated places deleted successfully.');
    }
}
