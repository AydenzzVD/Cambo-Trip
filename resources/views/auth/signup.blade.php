<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up — CamboTrips</title>
  <meta name="description" content="Create your free CamboTrips account to review destinations and join the Cambodia travel community." />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div class="auth-page">
    <!-- Left: Background Image -->
    <div class="auth-bg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Koh_Rong_beach.jpg/1280px-Koh_Rong_beach.jpg" alt="Koh Rong Beach" />
      <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(232,160,32,0.5) 0%, rgba(26,26,46,0.7) 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 40px;">
        <h2 style="color: white; font-size: 2rem; font-weight: 900; text-shadow: 2px 3px 10px rgba(0,0,0,0.4); text-align: center; line-height: 1.3;">Start Your<br>Cambodia Journey</h2>
        <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-top: 12px; text-align: center; max-width: 360px;">Create a free account to share reviews, discover hidden gems, and plan your next adventure.</p>
      </div>
    </div>

    <!-- Right: Signup Form -->
    <div class="auth-form-side">
      <div class="auth-card">
        <div class="auth-logo">
          <a href="{{ route('home') }}">
            <div class="logo-circle">
              <span class="logo-icon">🏛️</span>
            </div>
          </a>
        </div>
        <h1 class="auth-title">Create Account</h1>
        <p class="auth-subtitle">Join the CamboTrips community</p>

        @if(session('error'))
          <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 10px 14px; border-radius: var(--radius-sm); font-size: 0.85rem; margin-bottom: 18px; text-align: center;">
            {{ session('error') }}
          </div>
        @endif

        <form action="{{ route('signup') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <div class="input-wrap">
              <span class="input-icon">👤</span>
              <input type="text" id="name" name="name" class="form-input" placeholder="Your name" value="{{ old('name') }}" required autofocus />
            </div>
            @error('name')
              <p class="form-error">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
              <span class="input-icon">✉️</span>
              <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" value="{{ old('email') }}" required />
            </div>
            @error('email')
              <p class="form-error">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
              <span class="input-icon">🔒</span>
              <input type="password" id="password" name="password" class="form-input" placeholder="At least 6 characters" required minlength="6" />
              <button type="button" class="input-action" onclick="togglePassword(this)" aria-label="Toggle password visibility">👁️</button>
            </div>
            @error('password')
              <p class="form-error">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <div class="input-wrap">
              <span class="input-icon">🔒</span>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Re-enter your password" required minlength="6" />
            </div>
          </div>

          <button type="submit" class="btn-auth">Create Account 🎉</button>
        </form>

        <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
      </div>
    </div>
  </div>

  <script>
    function togglePassword(btn) {
      const input = btn.parentElement.querySelector('input');
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
      } else {
        input.type = 'password';
        btn.textContent = '👁️';
      }
    }
  </script>
</body>
</html>
