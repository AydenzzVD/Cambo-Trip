@extends('layouts.admin')

@section('title', 'Things to Do for ' . $place->name . ' — CamboTrips')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">🚶 Things to Do for: {{ $place->name }}</h1>
    <div style="display: flex; gap: 8px;">
      <a href="{{ route('admin.places.activities.create', $place->id) }}" class="btn btn-primary">+ Add Activity</a>
      <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-secondary">Back to Place</a>
    </div>
  </div>

  <div class="table-container">
    @if($activities->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Activity (Thing to Do)</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($activities as $activity)
            <tr>
              <td style="font-weight: 600; font-size: 1.05rem; padding: 16px 20px;">{{ $activity->name }}</td>
              <td style="text-align: right; padding: 16px 20px;">
                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                  <a href="{{ route('admin.places.activities.edit', [$place->id, $activity->id]) }}" class="btn btn-secondary btn-sm">Edit</a>
                  
                  <form action="{{ route('admin.places.activities.destroy', [$place->id, $activity->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this activity?')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div style="text-align: center; padding: 40px; color: var(--color-text-muted);">
        No activities found for this place. Click the button above to add one.
      </div>
    @endif
  </div>
@endsection
