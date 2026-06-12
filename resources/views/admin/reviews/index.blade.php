@extends('layouts.admin')

@section('title', 'Manage Reviews — VisitKhmer')

@section('content')
  <div class="header-bar">
    <h1 class="page-title">⭐ Review Moderation</h1>
  </div>

  <div class="table-container">
    @if($reviews->count() > 0)
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Place</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reviews as $review)
            <tr>
              <td style="font-weight: 600;">{{ $review->user->name ?? 'User #' . $review->user_id }}</td>
              <td>
                @if($review->place)
                  <a href="{{ route('place.show', $review->place->id) }}" target="_blank" style="text-decoration: underline; color: var(--color-accent); font-weight: 500;">
                    {{ $review->place->name }}
                  </a>
                @else
                  <span style="color: var(--color-text-muted);">Deleted Place</span>
                @endif
              </td>
              <td>
                <span style="color: var(--color-accent2); font-weight: 700;">
                  @for($s = 1; $s <= 5; $s++)
                    {{ $s <= $review->rating ? '★' : '☆' }}
                  @endfor
                </span>
                <span style="font-size: 0.8rem; color: var(--color-text-muted); margin-left: 4px;">({{ $review->rating }}/5)</span>
              </td>
              <td style="max-width: 350px; font-style: italic; line-height: 1.4;">
                "{{ $review->comment }}"
              </td>
              <td style="font-size: 0.82rem; color: var(--color-text-muted);">
                {{ $review->created_at->format('M d, Y h:i A') }}
                <span style="font-size: 0.72rem; display: block;">({{ $review->created_at->diffForHumans() }})</span>
              </td>
              <td style="text-align: right;">
                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div style="text-align: center; padding: 40px; color: var(--color-text-muted);">
        No reviews left by users yet.
      </div>
    @endif
  </div>
@endsection
