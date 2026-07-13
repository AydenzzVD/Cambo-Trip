@extends('layouts.admin')

@section('title', 'Add Activity for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Add Activity for: {{ $place->name }}</h1>
    <a href="{{ route('admin.places.activities.index', $place->id) }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.places.activities.store', $place->id) }}" method="POST">
      @csrf

      <div class="form-group">
        <label class="form-label" for="name">Activity (Thing to Do) Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Cultural Immersion, Sunset Cruise, Jungle Trekking" value="{{ old('name') }}" required autofocus />
        @error('name')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Add Activity 🚶</button>
        <a href="{{ route('admin.places.activities.index', $place->id) }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
