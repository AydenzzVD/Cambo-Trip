@extends('layouts.admin')

@section('title', 'Add Province — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Add New Province</h1>
    <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.provinces.store') }}" method="POST">
      @csrf

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label" for="id">Province ID (Slug URL format)</label>
          <input type="text" id="id" name="id" class="form-control" placeholder="e.g. battambang, sihanoukville" value="{{ old('id') }}" required autofocus />
          <span style="font-size: 0.75rem; color: var(--color-text-muted);">Lowercase letters, numbers, and dashes only. This becomes the URL: /destination/sihanoukville</span>
          @error('id')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="name">Province Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Battambang, Sihanoukville" value="{{ old('name') }}" required />
          @error('name')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="tagline">Tagline</label>
          <input type="text" id="tagline" name="tagline" class="form-control" placeholder="e.g. A Riverside Retreat or An Ancient Capital Escape" value="{{ old('tagline') }}" required />
          @error('tagline')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="image">Banner Image URL</label>
          <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image') }}" required />
          @error('image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="description">Description</label>
          <textarea id="description" name="description" class="form-control" rows="6" placeholder="Provide a detailed description of the province's historical significance, environment, and tourist spots..." required>{{ old('description') }}</textarea>
          @error('description')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Create Province 🗺️</button>
        <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
