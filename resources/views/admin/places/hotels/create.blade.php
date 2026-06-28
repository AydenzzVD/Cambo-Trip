@extends('layouts.admin')

@section('title', 'Add Hotel for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Add Hotel for: {{ $place->name }}</h1>
    <a href="{{ route('admin.places.hotels.index', $place->id) }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.places.hotels.store', $place->id) }}" method="POST">
      @csrf

      <div class="form-group">
        <label class="form-label" for="name">Hotel Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Heritage Suites Hotel" value="{{ old('name') }}" required />
        @error('name')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="price">Price Range</label>
        <input type="text" id="price" name="price" class="form-control" placeholder="e.g. $40 – $60/night" value="{{ old('price') }}" />
        @error('price')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="image">Hotel Image URL</label>
        <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image') }}" />
        @error('image')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="map_link">Google Maps Location Link</label>
        <input type="url" id="map_link" name="map_link" class="form-control" placeholder="https://maps.google.com/..." value="{{ old('map_link') }}" />
        @error('map_link')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Brief description of the hotel..." maxlength="1000">{{ old('description') }}</textarea>
        @error('description')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Add Hotel 🏨</button>
        <a href="{{ route('admin.places.hotels.index', $place->id) }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
