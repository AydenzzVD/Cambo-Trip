@extends('layouts.admin')

@section('title', 'Manage Places — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">📍 Places</h1>
    <a href="{{ route('admin.places.create') }}" class="btn btn-primary">+ Add New Place</a>
  </div>
  
  <div class="search-bar-container" style="background: var(--color-surface); padding: 18px 24px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border); margin-bottom: 24px;">
    <form action="{{ route('admin.places.index') }}" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
      <div style="flex-grow: 1; min-width: 250px; position: relative;">
        <input type="text" name="search" class="form-control" placeholder="Search places by name, province, category..." value="{{ $search ?? '' }}" style="width: 100%; padding-left: 38px;" />
        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted); font-size: 0.95rem;">🔍</span>
      </div>
      <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">Search</button>
      @if(!empty($search))
        <a href="{{ route('admin.places.index') }}" class="btn btn-secondary" style="padding: 10px 20px; display: inline-flex; align-items: center; text-decoration: none;">Clear</a>
      @endif
    </form>
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
            <th>Related Info</th>
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
              <td>
                <div style="display: flex; flex-direction: column; gap: 4px;">
                  <a href="{{ route('admin.places.activities.index', $place->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 4px 10px; justify-content: flex-start; gap: 6px; text-decoration: none; border-color: var(--color-border); color: var(--color-text);">🚶 Activities ({{ $place->activities->count() }})</a>
                  <a href="{{ route('admin.places.foods.index', $place->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 4px 10px; justify-content: flex-start; gap: 6px; text-decoration: none; border-color: var(--color-border); color: var(--color-text);">🍲 Foods ({{ $place->foods->count() }})</a>
                  <a href="{{ route('admin.places.hotels.index', $place->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 4px 10px; justify-content: flex-start; gap: 6px; text-decoration: none; border-color: var(--color-border); color: var(--color-text);">🏨 Hotels ({{ $place->hotels->count() }})</a>
                  <a href="{{ route('admin.places.restaurants.index', $place->id) }}" class="btn btn-secondary btn-sm" style="font-size: 0.75rem; padding: 4px 10px; justify-content: flex-start; gap: 6px; text-decoration: none; border-color: var(--color-border); color: var(--color-text);">🍽️ Eat ({{ $place->restaurants->count() }})</a>
                </div>
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
      
      @if($places->hasPages())
        <div class="pagination-container" style="padding: 16px 24px; border-top: 1px solid var(--color-border); display: flex; justify-content: center; align-items: center;">
          <div class="pagination">
            {{-- Previous Page Link --}}
            @if($places->onFirstPage())
              <span class="page-item disabled">&laquo;</span>
            @else
              <a href="{{ $places->appends(['search' => $search])->previousPageUrl() }}" class="page-item">&laquo;</a>
            @endif

            {{-- Page Numbers --}}
            @foreach($places->getUrlRange(1, $places->lastPage()) as $page => $url)
              @if($page == $places->currentPage())
                <span class="page-item active">{{ $page }}</span>
              @else
                <a href="{{ $places->appends(['search' => $search])->url($page) }}" class="page-item">{{ $page }}</a>
              @endif
            @endforeach

            {{-- Next Page Link --}}
            @if($places->hasMorePages())
              <a href="{{ $places->appends(['search' => $search])->nextPageUrl() }}" class="page-item">&raquo;</a>
            @else
              <span class="page-item disabled">&raquo;</span>
            @endif
          </div>
        </div>
      @endif
    @else
      <div style="text-align: center; padding: 40px; color: var(--color-text-muted);">
        No places found. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection

@section('styles')
  <style>
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 6px;
    }
    .page-item {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 34px;
      height: 34px;
      padding: 0 10px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--color-border);
      background: var(--color-surface);
      color: var(--color-text);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.85rem;
      transition: all var(--transition);
      cursor: pointer;
    }
    a.page-item:hover {
      border-color: var(--color-accent);
      color: var(--color-accent);
      background: rgba(74, 155, 155, 0.05);
    }
    .page-item.active {
      background: var(--color-accent);
      color: var(--color-white);
      border-color: var(--color-accent);
    }
    .page-item.disabled {
      color: var(--color-text-muted);
      opacity: 0.5;
      cursor: not-allowed;
      pointer-events: none;
    }
  </style>
@endsection

