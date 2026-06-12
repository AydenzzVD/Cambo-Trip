@extends('layouts.admin')

@section('title', 'Add Place — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Add New Place</h1>
    <a href="{{ route('admin.places.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.places.store') }}" method="POST">
      @csrf

      <div class="form-grid">
        <!-- Core Fields -->
        <div class="form-group">
          <label class="form-label" for="id">Place ID (Slug URL format)</label>
          <input type="text" id="id" name="id" class="form-control" placeholder="e.g. angkor-wat, koh-rong" value="{{ old('id') }}" required autofocus />
          <span style="font-size: 0.75rem; color: var(--color-text-muted);">Lowercase letters, numbers, and dashes only. This becomes the URL: /place/angkor-wat</span>
          @error('id')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="name">Place Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Angkor Wat, Koh Rong" value="{{ old('name') }}" required />
          @error('name')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="province_id">Province Location</label>
          <select id="province_id" name="province_id" class="form-control" required>
            <option value="">-- Select Province --</option>
            @foreach($provinces as $prov)
              <option value="{{ $prov->id }}" {{ old('province_id') == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
            @endforeach
          </select>
          @error('province_id')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="tagline">Short Tagline</label>
          <input type="text" id="tagline" name="tagline" class="form-control" placeholder="e.g. Iconic ancient temple complex famous for..." value="{{ old('tagline') }}" required />
          @error('tagline')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="image">Main Image URL</label>
          <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image') }}" required />
          @error('image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Quick Info Fields -->
        <div class="form-full" style="margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
          <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--color-sidebar);">Quick Info Details (Renders in top bar)</h3>
        </div>

        <div class="form-group">
          <label class="form-label" for="location">Location (City / District)</label>
          <input type="text" id="location" name="location" class="form-control" placeholder="e.g. Siem Reap or Sihanoukville Coast" value="{{ old('location') }}" required />
          @error('location')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="best_time">Best Time to Visit</label>
          <input type="text" id="best_time" name="best_time" class="form-control" placeholder="e.g. November – February or All year" value="{{ old('best_time') }}" required />
          @error('best_time')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="entry_fee">Entry Fee</label>
          <input type="text" id="entry_fee" name="entry_fee" class="form-control" placeholder="e.g. $37/day or Free admission" value="{{ old('entry_fee') }}" required />
          @error('entry_fee')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="quick_rating">Difficulty / Rating Category</label>
          <input type="text" id="quick_rating" name="quick_rating" class="form-control" placeholder="e.g. Easy, Medium, Adventurous" value="{{ old('quick_rating') }}" required />
          @error('quick_rating')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Categories & Description -->
        <div class="form-full" style="margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
          <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--color-sidebar);">Scenery, Maps & Categories</h3>
        </div>

        <div class="form-group form-full">
          <label class="form-label">Category Tags</label>
          <div class="checkbox-grid">
            @foreach($tags as $tag)
              <label class="checkbox-item">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }} />
                <span>{{ $tag->name }}</span>
              </label>
            @endforeach
          </div>
          @error('tags')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="about_image">scenery/About Image URL (Optional)</label>
          <input type="url" id="about_image" name="about_image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('about_image') }}" />
          @error('about_image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="map_link">Google Maps Location Link (Optional)</label>
          <input type="url" id="map_link" name="map_link" class="form-control" placeholder="https://maps.google.com/..." value="{{ old('map_link') }}" />
          @error('map_link')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="about">Detailed Description (About)</label>
          <textarea id="about" name="about" class="form-control" rows="6" placeholder="Provide a detailed narrative of the site's history, attractions, climate, layout, and instructions for visitors..." required>{{ old('about') }}</textarea>
          @error('about')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Create Place 📍</button>
        <a href="{{ route('admin.places.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
