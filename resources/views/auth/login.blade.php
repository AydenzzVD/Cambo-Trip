<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In — CamboTrips</title>
  <meta name="description" content="Sign in to your CamboTrips account to continue your Cambodia adventure." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #c9d8c5;
      background-image: url('{{ asset('images/auth-bg.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      padding: 20px;
    }

    /* ── Card ── */
    .auth-card {
      background: #fff;
      border-radius: 20px;
      padding: 44px 40px 36px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 16px rgba(0,0,0,0.1);
      animation: cardIn 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Logo ── */
    .auth-logo {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .auth-logo a {
      display: block;
      width: 64px;
      height: 64px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid #f0f0f0;
      transition: transform 0.2s;
    }
    .auth-logo a:hover { transform: scale(1.06); }
    .auth-logo img { width: 100%; height: 100%; object-fit: cover; }

    /* ── Headings ── */
    .auth-title {
      text-align: center;
      font-size: 1.35rem;
      font-weight: 800;
      color: #1a1a2e;
      margin-bottom: 6px;
      letter-spacing: -0.02em;
    }
    .auth-subtitle {
      text-align: center;
      font-size: 0.875rem;
      color: #6b7280;
      margin-bottom: 28px;
    }

    /* ── Error banner ── */
    .auth-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
      padding: 10px 14px;
      border-radius: 10px;
      font-size: 0.82rem;
      margin-bottom: 18px;
      text-align: center;
    }

    /* ── Form ── */
    .form-group { margin-bottom: 18px; }

    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 7px;
    }

    .input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon {
      position: absolute;
      left: 13px;
      display: flex;
      align-items: center;
      color: #9ca3af;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      padding: 11px 42px 11px 40px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.9rem;
      font-family: inherit;
      color: #374151;
      background: #f9fafb;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      outline: none;
    }
    .form-input::placeholder { color: #9ca3af; }
    .form-input:focus {
      border-color: #4a9b9b;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(74,155,155,0.12);
    }

    .input-toggle {
      position: absolute;
      right: 12px;
      background: none;
      border: none;
      cursor: pointer;
      color: #9ca3af;
      padding: 4px;
      display: flex;
      align-items: center;
      transition: color 0.2s;
    }
    .input-toggle:hover { color: #4a9b9b; }

    /* ── Forgot link ── */
    .forgot-wrap {
      display: flex;
      justify-content: flex-end;
      margin-top: 8px;
    }
    .forgot-link {
      font-size: 0.82rem;
      color: #4a9b9b;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }
    .forgot-link:hover { color: #3a8080; text-decoration: underline; }

    /* ── Submit button ── */
    .btn-submit {
      width: 100%;
      padding: 13px;
      background: #4a9b9b;
      color: #fff;
      font-size: 0.95rem;
      font-weight: 700;
      font-family: inherit;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 22px;
      letter-spacing: 0.02em;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(74,155,155,0.35);
    }
    .btn-submit:hover {
      background: #3d8585;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(74,155,155,0.4);
    }
    .btn-submit:active { transform: translateY(0); }

    /* ── Footer switch ── */
    .auth-switch {
      text-align: center;
      font-size: 0.85rem;
      color: #6b7280;
      margin-top: 20px;
    }
    .auth-switch a {
      color: #4a9b9b;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.2s;
    }
    .auth-switch a:hover { color: #3a8080; text-decoration: underline; }

    /* ── Form validation errors ── */
    .form-error {
      font-size: 0.78rem;
      color: #dc2626;
      margin-top: 5px;
    }

    @media (max-width: 480px) {
      .auth-card { padding: 36px 24px 28px; }
    }

    /* ── Google Button ── */
    .btn-google {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      padding: 11px 14px;
      background: #fff;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.9rem;
      font-weight: 600;
      font-family: inherit;
      color: #374151;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
      box-shadow: 0 1px 4px rgba(0,0,0,0.07);
      margin-bottom: 20px;
    }
    .btn-google:hover {
      background: #f9fafb;
      border-color: #4a9b9b;
      box-shadow: 0 2px 8px rgba(74,155,155,0.15);
    }

    /* ── OR Divider ── */
    .auth-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 20px;
      color: #9ca3af;
      font-size: 0.8rem;
    }
    .auth-divider::before,
    .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e5e7eb;
    }
  </style>
</head>
<body>

  <div class="auth-card">

    <!-- Logo -->
    <div class="auth-logo">
      <a href="{{ route('home') }}" title="Back to CamboTrips">
        <img src="{{ asset('images/logo.png') }}" alt="CamboTrips Logo" />
      </a>
    </div>

    <!-- Heading -->
    <h1 class="auth-title">Welcome Back</h1>
    <p class="auth-subtitle">Sign in to continue your next Cambodia adventure</p>

    <!-- Error -->
    @if(session('error'))
      <div class="auth-error">{{ session('error') }}</div>
    @endif

    <!-- Google OAuth Button -->
    <a href="{{ route('auth.google') }}" class="btn-google">
      <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
        <path fill="none" d="M0 0h48v48H0z"/>
      </svg>
      Continue with Google
    </a>

    <!-- OR Divider -->
    <div class="auth-divider">
      <span>or</span>
    </div>

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" novalidate>
      @csrf

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </span>
          <input
            type="email"
            id="email"
            name="email"
            class="form-input"
            placeholder="johnwick123@gmail.com"
            value="{{ old('email') }}"
            required
            autofocus
            autocomplete="email"
          />
        </div>
        @error('email')
          <p class="form-error">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <input
            type="password"
            id="password"
            name="password"
            class="form-input"
            placeholder="••••••••••••••••••••"
            required
            autocomplete="current-password"
          />
          <button type="button" class="input-toggle" id="pwdToggle" aria-label="Toggle password visibility">
            <!-- Eye-off icon (default — password hidden) -->
            <svg id="eyeOff" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            <!-- Eye icon (shown when visible) -->
            <svg id="eyeOn" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        @error('password')
          <p class="form-error">{{ $message }}</p>
        @enderror

        <!-- Forgot password -->
        <div class="forgot-wrap">
          <a href="#" class="forgot-link">Forgot password?</a>
        </div>
      </div>

      <button type="submit" class="btn-submit">Sign in</button>
    </form>

    <p class="auth-switch">Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
  </div>

  <script>
    const pwdToggle = document.getElementById('pwdToggle');
    const pwdInput  = document.getElementById('password');
    const eyeOff    = document.getElementById('eyeOff');
    const eyeOn     = document.getElementById('eyeOn');

    pwdToggle.addEventListener('click', () => {
      const isHidden = pwdInput.type === 'password';
      pwdInput.type  = isHidden ? 'text' : 'password';
      eyeOff.style.display = isHidden ? 'none'  : '';
      eyeOn.style.display  = isHidden ? ''      : 'none';
    });
  </script>
</body>
</html>
