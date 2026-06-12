@extends('layouts.app')

@section('title', 'VisitKhmer — Welcome to the Kingdom of Wonder')

@section('content')
  <!-- Hero Section -->
  <div class="hero-dual" style="position: relative;">
    <img class="hero-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Angkor_Wat_2013.jpg/1280px-Angkor_Wat_2013.jpg" alt="Angkor Wat sunrise" />
    <img class="hero-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Koh_Rong_beach.jpg/1280px-Koh_Rong_beach.jpg" alt="Koh Rong island" />
    <div class="hero-overlay" style="position: absolute; border-radius: var(--radius-lg);">
      <h1 class="hero-title">Welcome to the Kingdom of Wonder</h1>
    </div>
  </div>

  <!-- Top Destinations Section -->
  <div class="section">
    <h2 class="section-title">Top Destination</h2>
    <div class="cards-row" id="top-destinations">
      @foreach($topPlaces as $place)
        <div class="card place-card" onclick="window.location.href='{{ route('place.show', $place->id) }}'" style="cursor: pointer;">
          <div class="card-img-wrap">
            <img src="{{ $place->image }}" alt="{{ $place->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=400&q=60'">
            <div class="card-tags">
              @foreach($place->tags->take(2) as $tag)
                <span class="tag">{{ $tag->name }}</span>
              @endforeach
            </div>
          </div>
          <div class="card-body">
            <h3 class="card-title">{{ $place->name }}</h3>
            @if($place->reviews_count > 0)
              <div class="rating-badge" style="font-size: 0.8rem; font-weight: 600; color: var(--color-accent2); margin-bottom: 6px; display: flex; align-items: center; gap: 4px;">
                ⭐ {{ $place->average_rating }} <span style="color: var(--color-muted); font-weight: normal;">({{ $place->reviews_count }} {{ Str::plural('review', $place->reviews_count) }})</span>
              </div>
            @endif
            <p class="card-desc">{{ $place->tagline }}</p>
          </div>
        </div>
      @endforeach
    </div>
    <a href="{{ route('destination.index') }}" class="view-all">View All Destination</a>
  </div>
@endsection
