@extends('layouts.admin')

@section('title', 'Edit Food for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Edit Food for: {{ $place->name }}</h1>
    <a href="{{ route('admin.places.foods.index', $place->id) }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.places.foods.update', [$place->id, $food->id]) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label" for="name">Food Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Fish Amok" value="{{ old('name', $food->name) }}" required />
        @error('name')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="image">Food Image URL</label>
        <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image', $food->image) }}" />
        @error('image')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Brief description of the food item..." maxlength="1000">{{ old('description', $food->description) }}</textarea>
        @error('description')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Update Food Item 📝</button>
        <a href="{{ route('admin.places.foods.index', $place->id) }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
