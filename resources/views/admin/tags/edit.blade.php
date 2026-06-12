@extends('layouts.admin')

@section('title', 'Edit Category — VisitKhmer')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Edit Category Tag</h1>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group" style="max-width: 500px;">
        <label class="form-label" for="name">Category Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Eco-Tourism, Beach, Historical" value="{{ old('name', $tag->name) }}" required autofocus />
        @error('name')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="margin-top: 24px;">
        <button type="submit" class="btn btn-primary">Update Category 🏷️</button>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
