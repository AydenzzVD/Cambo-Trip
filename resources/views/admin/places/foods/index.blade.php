@extends('layouts.admin')

@section('title', 'Foods for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">🍲 Foods for: {{ $place->name }}</h1>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('admin.places.foods.create', $place->id) }}" class="btn btn-primary">+ Add New Food</a>
      <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-secondary">Back to Place</a>
    </div>
  </div>

  <div class="table-container">
    @if($foods->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Food Name</th>
            <th>Description</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($foods as $food)
            <tr>
              <td>
                @if($food->image)
                  <img src="{{ $food->image }}" alt="{{ $food->name }}" style="width: 60px; height: 40px; border-radius: var(--radius-sm); object-fit: cover;" onerror="this.style.display='none'" />
                @else
                  <span style="color: var(--color-text-muted); font-size: 0.8rem;">No image</span>
                @endif
              </td>
              <td style="font-weight: 600;">{{ $food->name }}</td>
              <td style="max-width: 400px; color: var(--color-text-muted); font-size: 0.9rem;">
                {{ Str::limit($food->description, 100, '...') }}
              </td>
              <td style="text-align: right;">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <a href="{{ route('admin.places.foods.edit', [$place->id, $food->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                  
                  <form action="{{ route('admin.places.foods.destroy', [$place->id, $food->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this food item?')" style="display: inline;">
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
        No food items found for this place. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
