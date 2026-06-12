@extends('layouts.admin')

@section('title', 'Manage Places — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">📍 Places</h1>
    <a href="{{ route('admin.places.create') }}" class="btn btn-primary">+ Add New Place</a>
  </div>

  <div class="table-container">
    @if($places->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>ID / Slug</th>
            <th>Place Name</th>
            <th>Province</th>
            <th>Categories (Tags)</th>
            <th>Reviews</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($places as $place)
            <tr>
              <td>
                <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: 60px; height: 40px; border-radius: var(--radius-sm); object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=100&q=60'" />
              </td>
              <td style="font-family: monospace; font-size: 0.85rem;">{{ $place->id }}</td>
              <td style="font-weight: 600;">{{ $place->name }}</td>
              <td>
                <span class="badge badge-secondary">{{ $place->province->name ?? 'N/A' }}</span>
              </td>
              <td style="max-width: 200px;">
                @forelse($place->tags as $tag)
                  <span class="badge badge-primary" style="margin-bottom: 2px;">{{ $tag->name }}</span>
                @empty
                  <span style="color: var(--color-text-muted); font-size: 0.8rem;">No categories</span>
                @endforelse
              </td>
              <td>
                <span style="font-weight: 600; color: var(--color-sidebar);">
                  ⭐ {{ $place->average_rating }}
                </span>
                <span style="font-size: 0.8rem; color: var(--color-text-muted);">
                  ({{ $place->reviews_count }})
                </span>
              </td>
              <td style="text-align: right;">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                  
                  <form action="{{ route('admin.places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this place? (This will also delete associated reviews, activities, foods, hotels, and restaurants)')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div style="text-align: center; padding: 40px; color: var(--color-text-muted);">
        No places found. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
