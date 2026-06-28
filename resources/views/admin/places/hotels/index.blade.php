@extends('layouts.admin')

@section('title', 'Hotels for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">🏨 Hotels (Where to Stay) for: {{ $place->name }}</h1>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('admin.places.hotels.create', $place->id) }}" class="btn btn-primary">+ Add New Hotel</a>
      <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-secondary">Back to Place</a>
    </div>
  </div>

  <div class="table-container">
    @if($hotels->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Hotel Name</th>
            <th>Price Range</th>
            <th>Description</th>
            <th>Map Link</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($hotels as $hotel)
            <tr>
              <td>
                @if($hotel->image)
                  <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" style="width: 60px; height: 40px; border-radius: var(--radius-sm); object-fit: cover;" onerror="this.style.display='none'" />
                @else
                  <span style="color: var(--color-text-muted); font-size: 0.8rem;">No image</span>
                @endif
              </td>
              <td style="font-weight: 600;">{{ $hotel->name }}</td>
              <td style="font-weight: 500; color: var(--color-accent);">{{ $hotel->price ?? 'N/A' }}</td>
              <td style="max-width: 300px; color: var(--color-text-muted); font-size: 0.9rem;">
                {{ Str::limit($hotel->description, 80, '...') }}
              </td>
              <td>
                @if($hotel->map_link)
                  <a href="{{ $hotel->map_link }}" target="_blank" rel="noopener" style="color: var(--color-accent); font-weight: 600; font-size: 0.85rem; text-decoration: underline;">📍 View map</a>
                @else
                  <span style="color: var(--color-text-muted); font-size: 0.8rem;">No map link</span>
                @endif
              </td>
              <td style="text-align: right;">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <a href="{{ route('admin.places.hotels.edit', [$place->id, $hotel->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                  
                  <form action="{{ route('admin.places.hotels.destroy', [$place->id, $hotel->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hotel?')" style="display: inline;">
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
        No hotels found for this place. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
