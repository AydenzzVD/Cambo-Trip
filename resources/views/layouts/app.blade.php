<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'CamboTrips — Welcome to the Kingdom of Wonder')</title>
  <meta name="description" content="@yield('meta_description', 'Discover Cambodia\'s most breathtaking destinations. Temples, islands, waterfalls, mountains and more await you in the Kingdom of Wonder.')" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  @yield('styles')
</head>
<body>

  <!-- Navbar -->
  <div id="navbar-placeholder">
    <nav class="navbar" id="navbar">
      <a href="{{ route('home') }}" class="nav-logo">
        <img src="{{ asset('images/logo.png') }}" alt="CamboTrips Logo" class="logo-img" />
        <span class="logo-text">CamboTrips</span>
      </a>
      <div class="nav-links">
        <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('destination.index') }}" class="nav-link {{ Route::is('destination.*') ? 'active' : '' }}">Destination</a>
        <a href="{{ route('explore') }}" class="nav-link {{ Route::is('explore') ? 'active' : '' }}">Explore</a>
        <a href="{{ route('search') }}" class="nav-link {{ Route::is('search') ? 'active' : '' }}">Search</a>
      </div>
      <div class="nav-actions" style="display: flex; align-items: center; gap: 10px;">
        @auth
          @if(auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" style="border-color: var(--color-accent2); color: var(--color-accent2); font-weight: 600;">🛠️ Admin Panel</a>
          @endif
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
  <footer class="main-footer">
    <div class="footer-top">
      <div class="footer-column footer-brand-column">
        <a href="{{ route('home') }}" class="footer-logo">
          <img src="{{ asset('images/logo.png') }}" alt="CamboTrips Logo" class="footer-logo-img" />
          <span class="footer-logo-text">CamboTrips</span>
        </a>
        <p class="footer-description">
          Discover Cambodia's most breathtaking destinations. Explore temples, pristine beaches, scenic waterfalls, and vibrant local cultures with CamboTrips — your ultimate guide to the Kingdom of Wonder.
        </p>
        <div class="social-links">
          <a href="#" aria-label="Facebook" class="social-link facebook">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <a href="#" aria-label="Instagram" class="social-link instagram">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
          <a href="#" aria-label="Twitter" class="social-link twitter">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
          </a>
          <a href="#" aria-label="YouTube" class="social-link youtube">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.41 19c1.71.46 8.59.46 8.59.46s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
          </a>
        </div>
      </div>

      <div class="footer-column">
        <h4 class="footer-title">Quick Links</h4>
        <ul class="footer-menu">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('destination.index') }}">Destinations</a></li>
          <li><a href="{{ route('explore') }}">Explore Places</a></li>
          <li><a href="{{ route('search') }}">Search trip</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h4 class="footer-title">Contact Us</h4>
        <ul class="footer-contact-info">
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Phnom Penh, Cambodia</span>
          </li>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <span>info@cambotrips.com</span>
          </li>
          <li>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>+855 12 345 678</span>
          </li>
        </ul>
      </div>

      <div class="footer-column">
        <h4 class="footer-title">Newsletter</h4>
        <p class="newsletter-text">Subscribe to get the latest travel guides, tips, and hidden gems of Cambodia.</p>
        <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
          <input type="email" placeholder="Your Email Address" required class="newsletter-input" />
          <button type="submit" class="newsletter-btn" aria-label="Subscribe">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
          </button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      <p class="copyright-text">&copy; {{ date('Y') }} CamboTrips. All rights reserved.</p>
      <a href="#navbar-placeholder" class="back-to-top" id="backToTop">
        <span>Back to Top</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
      </a>
    </div>
  </footer>

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
