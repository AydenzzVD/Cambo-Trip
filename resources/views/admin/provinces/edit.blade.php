@extends('layouts.admin')

@section('title', 'Edit Province — VisitKhmer')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Edit Province: {{ $province->name }}</h1>
    <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.provinces.update', $province->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Province ID (Slug)</label>
          <input type="text" class="form-control" value="{{ $province->id }}" disabled />
          <span style="font-size: 0.75rem; color: var(--color-text-muted);">The database ID/Slug cannot be modified because it is a primary relationship key.</span>
        </div>

        <div class="form-group">
          <label class="form-label" for="name">Province Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Battambang, Sihanoukville" value="{{ old('name', $province->name) }}" required />
          @error('name')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="tagline">Tagline</label>
          <input type="text" id="tagline" name="tagline" class="form-control" placeholder="e.g. A Riverside Retreat" value="{{ old('tagline', $province->tagline) }}" required />
          @error('tagline')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="image">Banner Image URL</label>
          <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="{{ old('image', $province->image) }}" required />
          @error('image')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>

        <div class="form-group form-full">
          <label class="form-label" for="description">Description</label>
          <textarea id="description" name="description" class="form-control" rows="6" placeholder="Provide a detailed description..." required>{{ old('description', $province->description) }}</textarea>
          @error('description')
            <p class="form-error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div style="margin-top: 24px; border-top: 1px solid var(--color-border); padding-top: 20px;">
        <button type="submit" class="btn btn-primary">Update Province 📝</button>
        <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
