<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — VisitKhmer</title>
  <meta name="description" content="Log in to your VisitKhmer account to leave reviews and save your favorite destinations." />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div class="auth-page">
    <!-- Left: Background Image -->
    <div class="auth-bg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Angkor_Wat_2013.jpg/1280px-Angkor_Wat_2013.jpg" alt="Angkor Wat" />
      <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(74,155,155,0.6) 0%, rgba(26,26,46,0.7) 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 40px;">
        <h2 style="color: white; font-size: 2rem; font-weight: 900; text-shadow: 2px 3px 10px rgba(0,0,0,0.4); text-align: center; line-height: 1.3;">Welcome Back to<br>the Kingdom of Wonder</h2>
        <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; margin-top: 12px; text-align: center; max-width: 360px;">Sign in to leave reviews, track your adventures, and connect with the Cambodia travel community.</p>
      </div>
    </div>

    <!-- Right: Login Form -->
    <div class="auth-form-side">
      <div class="auth-card">
        <div class="auth-logo">
          <a href="{{ route('home') }}">
            <div class="logo-circle">
              <span class="logo-icon">🏛️</span>
            </div>
          </a>
        </div>
        <h1 class="auth-title">Sign In</h1>
        <p class="auth-subtitle">Enter your credentials to continue</p>

        @if(session('error'))
          <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 10px 14px; border-radius: var(--radius-sm); font-size: 0.85rem; margin-bottom: 18px; text-align: center;">
            {{ session('error') }}
          </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
              <span class="input-icon">✉️</span>
              <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" value="{{ old('email') }}" required autofocus />
            </div>
            @error('email')
              <p class="form-error">{{ $message }}</p>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
              <span class="input-icon">🔒</span>
              <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required />
              <button type="button" class="input-action" onclick="togglePassword(this)" aria-label="Toggle password visibility">👁️</button>
            </div>
            @error('password')
              <p class="form-error">{{ $message }}</p>
            @enderror
          </div>

          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
            <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; color: var(--color-muted); cursor: pointer;">
              <input type="checkbox" name="remember" style="accent-color: var(--color-accent);" /> Remember me
            </label>
          </div>

          <button type="submit" class="btn-auth">Sign In →</button>
        </form>

        <p class="auth-switch">Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
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
