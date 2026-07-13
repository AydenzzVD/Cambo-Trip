@extends('layouts.admin')

@section('title', 'Edit Place — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Edit Place: {{ $place->name }}</h1>
    <a href="{{ route('admin.places.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div style="display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
    <a href="{{ route('admin.places.activities.index', $place->id) }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; border-color: var(--color-border); text-decoration: none; padding: 10px 20px;">
      🚶 Manage Things to Do ({{ $place->activities->count() }})
    </a>
    <a href="{{ route('admin.places.foods.index', $place->id) }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; border-color: var(--color-border); text-decoration: none; padding: 10px 20px;">
      🍲 Manage Local Foods ({{ $place->foods->count() }})
    </a>
    <a href="{{ route('admin.places.hotels.index', $place->id) }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; border-color: var(--color-border); text-decoration: none; padding: 10px 20px;">
      🏨 Manage Hotels ({{ $place->hotels->count() }})
    </a>
    <a href="{{ route('admin.places.restaurants.index', $place->id) }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; border-color: var(--color-border); text-decoration: none; padding: 10px 20px;">
      🍽️ Manage Restaurants ({{ $place->restaurants->count() }})
    </a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.places.update', $place->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <!-- Core Fields -->
        <div class="form-group">
          <label class="form-label">Place ID (Slug URL format)</label>
          <input type="text" class="form-control" value="{{ $place->id }}" disabled />
          <span style="font-size: 0.75rem; color: var(--color-text-muted);">The database ID/Slug cannot be modified.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="name">Place Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Angkor Wat" value="{{ old('name', $place->name) }}" required />
          @error('name')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="province_id">Province Location</label>
          <select id="province_id" name="province_id" class="form-control" required>
            <option value="">-- Select Province --</option>
            @foreach($provinces as $prov)
              <option value="{{ $prov->id }}" {{ old('province_id', $place->province_id) == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
            @endforeach
          </select>
          @error('province_id')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="tagline">Short Tagline</label>
          <input type="text" id="tagline" name="tagline" class="form-control" placeholder="e.g. Iconic ancient temple complex famous for..." value="{{ old('tagline', $place->tagline) }}" required />
          @error('tagline')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="image">Main Image URL</label>
          <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image', $place->image) }}" required />
          @error('image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Quick Info Fields -->
        <div class="form-full" style="margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
          <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--color-sidebar);">Quick Info Details (Renders in top bar)</h3>
        </div>

        @php
          $location = $place->quick_info['location'] ?? ($place->quick_info['Location'] ?? '');
          $best_time = $place->quick_info['best_time'] ?? ($place->quick_info['bestTime'] ?? ($place->quick_info['Best Time'] ?? ($place->quick_info['bestFor'] ?? '')));
          $entry_fee = $place->quick_info['entry_fee'] ?? ($place->quick_info['entryFee'] ?? ($place->quick_info['Entry Fee'] ?? ($place->quick_info['budget'] ?? '')));
          $quick_rating = $place->quick_info['rating'] ?? ($place->quick_info['Rating'] ?? ($place->quick_info['difficulty'] ?? ''));
        @endphp

        <div class="form-group">
          <label class="form-label" for="location">Location (City / District)</label>
          <input type="text" id="location" name="location" class="form-control" placeholder="e.g. Siem Reap" value="{{ old('location', $location) }}" required />
          @error('location')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="best_time">Best Time to Visit</label>
          <input type="text" id="best_time" name="best_time" class="form-control" placeholder="e.g. November – February" value="{{ old('best_time', $best_time) }}" required />
          @error('best_time')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="entry_fee">Entry Fee</label>
          <input type="text" id="entry_fee" name="entry_fee" class="form-control" placeholder="e.g. $37/day" value="{{ old('entry_fee', $entry_fee) }}" required />
          @error('entry_fee')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="quick_rating">Difficulty / Rating Category</label>
          <input type="text" id="quick_rating" name="quick_rating" class="form-control" placeholder="e.g. Easy, Medium, Adventurous" value="{{ old('quick_rating', $quick_rating) }}" required />
          @error('quick_rating')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <!-- Categories & Description -->
        <div class="form-full" style="margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">
          <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--color-sidebar);">Scenery, Maps & Categories</h3>
        </div>

        <div class="form-group">
          <label class="form-label" for="category">Province Section (Category) <span style="color:red">*</span></label>
          <select id="category" name="category" class="form-control" required>
            <option value="">-- Select one section --</option>
            @foreach(['Historical', 'Culture', 'Nature & Adventure', 'Nightlife'] as $cat)
              <option value="{{ $cat }}" {{ old('category', $place->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          <span style="font-size: 0.75rem; color: var(--color-text-muted);">This determines which section the place appears in on the province page.</span>
          @error('category')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label">Category Tags</label>
          <div class="checkbox-grid">
            @php
              $currentTagIds = $place->tags->pluck('id')->toArray();
            @endphp
            @foreach($tags as $tag)
              <label class="checkbox-item">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $currentTagIds)) ? 'checked' : '' }} />
                <span>{{ $tag->name }}</span>
              </label>
            @endforeach
          </div>
          @error('tags')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="about_image">Scenery/About Image URL 1 (Optional)</label>
          <input type="url" id="about_image" name="about_image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('about_image', $place->about_image) }}" />
          @error('about_image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="about_image_2">Scenery/About Image URL 2 (Optional)</label>
          <input type="url" id="about_image_2" name="about_image_2" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('about_image_2', $place->about_image_2) }}" />
          @error('about_image_2')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="about_image_3">Scenery/About Image URL 3 (Optional)</label>
          <input type="url" id="about_image_3" name="about_image_3" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('about_image_3', $place->about_image_3) }}" />
          @error('about_image_3')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="map_link">Google Maps Location Link (Optional)</label>
          <input type="url" id="map_link" name="map_link" class="form-control" placeholder="https://maps.google.com/..." value="{{ old('map_link', $place->map_link) }}" />
          @error('map_link')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="about">Detailed Description (About)</label>
          <textarea id="about" name="about" class="form-control" rows="6" placeholder="Provide a detailed narrative..." required>{{ old('about', $place->about) }}</textarea>
          @error('about')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Update Place 📝</button>
        <a href="{{ route('admin.places.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
