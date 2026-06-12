<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('places')->orderBy('name')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create([
            'name' => trim($request->name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Category tag created successfully! 🎉');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => trim($request->name),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Category tag updated successfully! 🏷️');
    }

    public function destroy(Tag $tag)
    {
        // Many-to-many pivot rows will cascade delete automatically
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Category tag deleted successfully.');
    }
}
