@extends('layouts.admin')

@section('title', 'Admin Dashboard — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Dashboard Overview</h1>
    <div style="font-weight: 500; font-size: 0.95rem; color: var(--color-text-muted);">
      Logged in as: <strong style="color: var(--color-sidebar);">{{ auth()->user()->name }}</strong>
    </div>
  </div>

  <!-- Metric Cards Grid -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['provinces'] }}</span>
        <span class="stat-label">Provinces</span>
      </div>
      <div class="stat-icon">🗺️</div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['places'] }}</span>
        <span class="stat-label">Places</span>
      </div>
      <div class="stat-icon">📍</div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['tags'] }}</span>
        <span class="stat-label">Categories</span>
      </div>
      <div class="stat-icon">🏷️</div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['reviews'] }}</span>
        <span class="stat-label">Reviews</span>
      </div>
      <div class="stat-icon">⭐</div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['users'] }}</span>
        <span class="stat-label">Registered Users</span>
      </div>
      <div class="stat-icon">👤</div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <span class="stat-value">{{ $stats['avg_rating'] }} / 5.0</span>
        <span class="stat-label">Average Rating</span>
      </div>
      <div class="stat-icon">📈</div>
    </div>
  </div>

  <!-- Activity Sections -->
  <div class="dashboard-sections">
    
    <!-- Left: Recent Reviews (Moderation Column) -->
    <div class="section-card">
      <div class="section-title">
        <span>⭐ Recent Reviews</span>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">Manage All</a>
      </div>
      
      @if($recentReviews->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 14px;">
          @foreach($recentReviews as $review)
            <div style="border-bottom: 1px solid var(--color-border); padding-bottom: 12px; display: flex; justify-content: space-between; align-items: flex-start;">
              <div style="max-width: 80%;">
                <div style="font-size: 0.9rem; font-weight: 600; color: var(--color-sidebar);">
                  {{ $review->user->name ?? 'User' }} <span style="font-weight: 400; color: var(--color-text-muted);">reviewed</span> 
                  <a href="{{ route('place.show', $review->place->id ?? '') }}" target="_blank" style="text-decoration: underline;">
                    {{ $review->place->name ?? 'Deleted Place' }}
                  </a>
                </div>
                <div style="color: var(--color-accent2); font-size: 0.8rem; margin: 4px 0;">
                  @for($s = 1; $s <= 5; $s++)
                    {{ $s <= $review->rating ? '★' : '☆' }}
                  @endfor
                </div>
                <p style="font-size: 0.85rem; color: var(--color-text); font-style: italic; line-height: 1.4;">
                  "{{ Str::limit($review->comment, 80) }}"
                </p>
                <span style="font-size: 0.75rem; color: var(--color-text-muted); display: block; margin-top: 4px;">
                  {{ $review->created_at->diffForHumans() }}
                </span>
              </div>
              <div>
                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" style="padding: 4px 8px; font-size: 0.72rem;">Delete</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p style="font-size: 0.9rem; color: var(--color-text-muted); text-align: center; padding: 20px 0;">No reviews left yet.</p>
      @endif
    </div>

    <!-- Right: Recently Added Places -->
    <div class="section-card">
      <div class="section-title">
        <span>📍 Recently Added Places</span>
        <a href="{{ route('admin.places.index') }}" class="btn btn-secondary btn-sm">Manage All</a>
      </div>

      @if($recentPlaces->count() > 0)
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="padding: 8px 12px; font-size: 0.78rem;">Place</th>
              <th style="padding: 8px 12px; font-size: 0.78rem;">Province</th>
              <th style="padding: 8px 12px; font-size: 0.78rem; text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentPlaces as $place)
              <tr>
                <td style="padding: 10px 12px; font-size: 0.85rem; font-weight: 500;">{{ $place->name }}</td>
                <td style="padding: 10px 12px; font-size: 0.85rem;">
                  <span class="badge badge-secondary">{{ $place->province->name ?? 'N/A' }}</span>
                </td>
                <td style="padding: 10px 12px; font-size: 0.85rem; text-align: right;">
                  <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-secondary btn-sm" style="padding: 4px 8px; font-size: 0.72rem;">Edit</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p style="font-size: 0.9rem; color: var(--color-text-muted); text-align: center; padding: 20px 0;">No places added yet.</p>
      @endif
    </div>
  </div>
@endsection
