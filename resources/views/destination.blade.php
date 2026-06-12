@extends('layouts.app')

@section('title', 'Destination — CamboTrips')

@section('meta_description', 'Explore Cambodia\'s rich provinces — from ancient temples in the north to relaxing beaches in the south.')

@section('content')
  <!-- Hero Section -->
  <div class="hero">
    <img class="hero-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Angkor_Wat_2013.jpg/1280px-Angkor_Wat_2013.jpg" alt="Cambodia destination" />
    <div class="hero-overlay">
      <h1 class="hero-title">Destination</h1>
      <p class="hero-subtitle">Explore the rich provinces of Cambodia. From ancient temples<br>in the North to relaxing beaches in the South.</p>
    </div>
  </div>

  <div class="divider"></div>

  <!-- Province Grid -->
  <div class="provinces-grid" id="province-grid">
    @foreach($provinces as $province)
      <div class="province-card" onclick="window.location.href='{{ route('destination.show', $province->id) }}'" style="cursor: pointer;">
        <div class="province-img-wrap">
          <img src="{{ $province->image }}" alt="{{ $province->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=600&q=60'">
          <div class="province-overlay">
            <span class="province-label">Province</span>
            <h2 class="province-name">{{ strtoupper($province->name) }}</h2>
            <p class="province-tagline">{{ $province->tagline }}</p>
          </div>
        </div>
        <p class="province-desc">{{ $province->description }}</p>
      </div>
    @endforeach
  </div>
@endsection
