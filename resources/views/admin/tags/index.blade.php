@extends('layouts.admin')

@section('title', 'Manage Categories — VisitKhmer')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">🏷️ Categories (Tags)</h1>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">+ Add New Category</a>
  </div>

  <div class="table-container">
    @if($tags->count() > 0)
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Places Associated</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tags as $tag)
            <tr>
              <td>#{{ $tag->id }}</td>
              <td style="font-weight: 600;">{{ $tag->name }}</td>
              <td>
                <span class="badge badge-primary">{{ $tag->places_count }} {{ Str::plural('place', $tag->places_count) }}</span>
              </td>
              <td style="text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                
                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? (This will unlink it from any places it is assigned to)')" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div style="text-align: center; padding: 40px; color: var(--color-text-muted);">
        No categories found. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
