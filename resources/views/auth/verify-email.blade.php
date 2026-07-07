<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify Email — CamboTrips</title>
  <meta name="description" content="Please verify your email address to continue." />
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
      max-width: 440px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 16px rgba(0,0,0,0.1);
      animation: cardIn 0.4s cubic-bezier(0.22, 1, 0.36, 1);
      text-align: center;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(20px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── Logo/Icon ── */
    .auth-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 68px;
      height: 68px;
      background: rgba(74, 155, 155, 0.1);
      color: #4a9b9b;
      border-radius: 50%;
      margin-bottom: 24px;
    }

    /* ── Headings ── */
    .auth-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: #1a1a2e;
      margin-bottom: 12px;
      letter-spacing: -0.02em;
    }
    .auth-text {
      font-size: 0.9rem;
      color: #4b5563;
      line-height: 1.6;
      margin-bottom: 24px;
    }

    /* ── Alert banners ── */
    .auth-alert {
      background: #ecfdf5;
      border: 1px solid #a7f3d0;
      color: #065f46;
      padding: 12px;
      border-radius: 10px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }

    .auth-error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
      padding: 12px;
      border-radius: 10px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }

    /* ── Buttons ── */
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
      letter-spacing: 0.02em;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(74,155,155,0.35);
      margin-bottom: 12px;
    }
    .btn-submit:hover {
      background: #3d8585;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(74,155,155,0.4);
    }
    .btn-submit:active { transform: translateY(0); }

    .btn-logout {
      background: none;
      border: none;
      color: #9ca3af;
      font-size: 0.85rem;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: color 0.2s;
      padding: 6px 12px;
    }
    .btn-logout:hover { color: #dc2626; text-decoration: underline; }

    @media (max-width: 480px) {
      .auth-card { padding: 36px 24px 28px; }
    }
  </style>
</head>
<body>

  <div class="auth-card">
    <!-- Verification Icon -->
    <div class="auth-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><path d="m16 19 2 2 4-4"/></svg>
    </div>

    <!-- Heading -->
    <h1 class="auth-title">Verify Your Email</h1>
    
    <p class="auth-text">
      Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </p>

    <!-- Alerts -->
    @if (session('success'))
      <div class="auth-alert">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="auth-error">
        {{ session('error') }}
      </div>
    @endif

    <!-- Resend Form -->
    <form action="{{ route('verification.send') }}" method="POST">
      @csrf
      <button type="submit" class="btn-submit">Resend Verification Email</button>
    </form>

    <!-- Logout Option (so they aren't trapped) -->
    <form action="{{ route('logout') }}" method="POST" style="margin-top: 14px;">
      @csrf
      <button type="submit" class="btn-logout">Logout</button>
    </form>
  </div>

</body>
</html>
