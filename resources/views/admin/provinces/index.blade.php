@extends('layouts.admin')

@section('title', 'Manage Provinces — VisitKhmer')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">🗺️ Provinces</h1>
    <a href="{{ route('admin.provinces.create') }}" class="btn btn-primary">+ Add New Province</a>
  </div>

  <div class="table-container">
    @if($provinces->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>ID / Slug</th>
            <th>Province Name</th>
            <th>Tagline</th>
            <th>Places</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($provinces as $province)
            <tr>
              <td>
                <img src="{{ $province->image }}" alt="{{ $province->name }}" style="width: 60px; height: 40px; border-radius: var(--radius-sm); object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=100&q=60'" />
              </td>
              <td style="font-family: monospace; font-size: 0.85rem;">{{ $province->id }}</td>
              <td style="font-weight: 600;">{{ $province->name }}</td>
              <td style="color: var(--color-text-muted); max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $province->tagline }}
              </td>
              <td>
                <span class="badge badge-primary">{{ $province->places_count }} {{ Str::plural('place', $province->places_count) }}</span>
              </td>
              <td style="text-align: right;">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <a href="{{ route('admin.provinces.edit', $province->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                  
                  <form action="{{ route('admin.provinces.destroy', $province->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this province? WARNING: This will cascade delete all places and reviews in this province!')" style="display: inline;">
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
        No provinces found. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
