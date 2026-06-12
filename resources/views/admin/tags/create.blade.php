@extends('layouts.admin')

@section('title', 'Add Category — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">Add New Category Tag</h1>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">← Back to List</a>
  </div>

  <div class="form-card">
    <form action="{{ route('admin.tags.store') }}" method="POST">
      @csrf

      <div class="form-group" style="max-width: 500px;">
        <label class="form-label" for="name">Category Name</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Eco-Tourism, Beach, Historical" value="{{ old('name') }}" required autofocus />
        @error('name')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <div style="margin-top: 24px;">
        <button type="submit" class="btn btn-primary">Create Category 🎉</button>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary" style="margin-left: 8px;">Cancel</a>
      </div>
    </form>
  </div>
@endsection
