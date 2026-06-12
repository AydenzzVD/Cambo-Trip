@extends('layouts.app')

@section('title', $province->name . ' — VisitKhmer')

@section('content')
  <!-- Province Banner -->
  <div class="prov-banner">
    <img id="prov-img" src="{{ $province->image }}" alt="{{ $province->name }}" />
    <div class="prov-banner-overlay">
      <h1 class="prov-banner-name">{{ $province->name }}</h1>
    </div>
  </div>

  <p class="prov-desc">{{ $province->description }}</p>

  <!-- Grouped Sections -->
  <div id="prov-sections">
    @php
      $sectionDefs = [
        'Historical' => 'Historical Sites',
        'Culture' => 'Culture Site',
        'Nature & Adventure' => 'Nature & Adventure',
        'Nightlife' => 'Place to Visit at Night'
      ];
      $hasAnyPlace = false;
    @endphp

    @foreach($sectionDefs as $key => $label)
      @if(isset($groupedPlaces[$key]) && count($groupedPlaces[$key]) > 0)
        @php $hasAnyPlace = true; @endphp
        <div class="prov-section">
          <h2 class="prov-section-title">{{ $label }}</h2>
          <div class="prov-place-grid">
            @foreach($groupedPlaces[$key] as $place)
              <div class="prov-place-item" onclick="window.location.href='{{ route('place.show', $place->id) }}'" style="cursor: pointer;">
                <img src="{{ $place->image }}" alt="{{ $place->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=300&q=60'" />
                <p class="prov-place-name">{{ $place->name }}</p>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endforeach

    @if(!$hasAnyPlace)
      <p style="text-align: center; padding: 40px; color: var(--color-muted);">No places listed yet.</p>
    @endif
  </div>
@endsection
