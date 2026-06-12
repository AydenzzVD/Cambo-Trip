<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'VisitKhmer — Welcome to the Kingdom of Wonder')</title>
  <meta name="description" content="@yield('meta_description', 'Discover Cambodia\'s most breathtaking destinations. Temples, islands, waterfalls, mountains and more await you in the Kingdom of Wonder.')" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  @yield('styles')
</head>
<body>

  <!-- Navbar -->
  <div id="navbar-placeholder">
    <nav class="navbar" id="navbar">
      <a href="{{ route('home') }}" class="nav-logo">
        <div class="logo-circle">
          <span class="logo-icon">🏛️</span>
        </div>
        <span class="logo-text">VisitKhmer</span>
      </a>
      <div class="nav-links">
        <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('destination.index') }}" class="nav-link {{ Route::is('destination.*') ? 'active' : '' }}">Destination</a>
        <a href="{{ route('explore') }}" class="nav-link {{ Route::is('explore') ? 'active' : '' }}">Explore</a>
        <a href="{{ route('search') }}" class="nav-link {{ Route::is('search') ? 'active' : '' }}">Search</a>
      </div>
      <div class="nav-actions">
        @auth
          <span class="user-name" style="font-weight: 500; font-size: 0.9rem; color: var(--color-dark); margin-right: 12px; display: inline-block;">👋 {{ auth()->user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline" style="cursor: pointer; padding: 8px 16px;">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
          <a href="{{ route('signup') }}" class="btn btn-dark">Sign Up</a>
        @endauth
      </div>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </nav>
  </div>

  <!-- Content -->
  @yield('content')

  <!-- Footer -->
  <div id="footer-placeholder">
    <footer class="footer">
      <span><a href="#">About</a></span>
      <span><a href="#">Contact</a></span>
      <span>@Copyright VisitKhmer 2025</span>
    </footer>
  </div>

  <!-- JavaScript -->
  <script src="{{ asset('js/app.js') }}"></script>
  
  <!-- Flash Notification Toasts -->
  @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        showToast("{{ session('success') }}", 'success');
      });
    </script>
  @endif

  @if (session('error'))
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        showToast("{{ session('error') }}", 'error');
      });
    </script>
  @endif

  @yield('scripts')
</body>
</html>
