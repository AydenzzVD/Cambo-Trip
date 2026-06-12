<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Admin Dashboard — CamboTrips')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  
  <style>
    :root {
      --color-sidebar:   #1a1a2e;
      --color-sidebar-hover: rgba(255, 255, 255, 0.08);
      --color-bg:        #F5F0E8;
      --color-surface:   #FFFFFF;
      --color-accent:    #4A9B9B;
      --color-accent-hover: #3d8080;
      --color-accent2:   #E8A020;
      --color-danger:    #EF4444;
      --color-danger-hover: #DC2626;
      --color-text:      #2C2C2C;
      --color-text-muted:#6B7280;
      --color-border:    #E5E7EB;
      --color-white:     #FFFFFF;

      --font-main:       'Outfit', sans-serif;
      --radius-sm:       8px;
      --radius-md:       12px;
      --radius-lg:       18px;
      --transition:      0.25s cubic-bezier(0.4, 0, 0.2, 1);
      
      --shadow-sm:       0 2px 8px rgba(0,0,0,0.06);
      --shadow-md:       0 4px 20px rgba(0,0,0,0.08);
      --shadow-lg:       0 10px 30px rgba(0,0,0,0.12);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: var(--font-main);
      background: var(--color-bg);
      color: var(--color-text);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── Sidebar ── */
    .sidebar {
      width: 260px;
      background: var(--color-sidebar);
      color: var(--color-white);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      position: sticky;
      top: 0;
      height: 100vh;
      box-shadow: var(--shadow-lg);
      z-index: 100;
    }

    .sidebar-header {
      padding: 24px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-icon {
      font-size: 1.6rem;
      background: linear-gradient(135deg, var(--color-accent2), var(--color-accent));
      width: 42px;
      height: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .logo-img {
      width: 42px;
      height: 42px;
      object-fit: cover;
      border-radius: 50%;
    }

    .logo-text {
      font-weight: 700;
      font-size: 1.2rem;
      letter-spacing: 0.5px;
      background: linear-gradient(to right, #ffffff, #e0e0e0);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .sidebar-menu {
      list-style: none;
      padding: 20px 14px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      flex-grow: 1;
    }

    .menu-item a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      border-radius: var(--radius-sm);
      transition: all var(--transition);
    }

    .menu-item a:hover {
      color: var(--color-white);
      background: var(--color-sidebar-hover);
      transform: translateX(4px);
    }

    .menu-item.active a {
      color: var(--color-white);
      background: linear-gradient(135deg, rgba(74, 155, 155, 0.2), rgba(232, 160, 32, 0.1));
      border-left: 4px solid var(--color-accent2);
      padding-left: 12px;
    }

    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.08);
      font-size: 0.85rem;
      color: rgba(255,255,255,0.5);
      text-align: center;
    }

    /* ── Main Panel Content ── */
    .content-area {
      flex-grow: 1;
      padding: 40px;
      max-width: 1200px;
      margin: 0 auto;
      width: calc(100% - 260px);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--color-sidebar);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.9rem;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: all var(--transition);
    }

    .btn-primary {
      background: var(--color-accent);
      color: var(--color-white);
    }

    .btn-primary:hover {
      background: var(--color-accent-hover);
      box-shadow: var(--shadow-sm);
    }

    .btn-secondary {
      background: var(--color-white);
      color: var(--color-text);
      border: 1px solid var(--color-border);
    }

    .btn-secondary:hover {
      background: #fafafa;
    }

    .btn-danger {
      background: var(--color-danger);
      color: var(--color-white);
    }

    .btn-danger:hover {
      background: var(--color-danger-hover);
    }

    .btn-sm {
      padding: 6px 12px;
      font-size: 0.8rem;
      border-radius: 6px;
    }

    /* ── Table Styling ── */
    .table-container {
      background: var(--color-surface);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-md);
      overflow: hidden;
      margin-bottom: 24px;
      border: 1px solid var(--color-border);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    th {
      background: #fafafa;
      color: var(--color-text-muted);
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      padding: 16px 24px;
      border-bottom: 1px solid var(--color-border);
    }

    td {
      padding: 16px 24px;
      border-bottom: 1px solid var(--color-border);
      font-size: 0.92rem;
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: rgba(74, 155, 155, 0.02);
    }

    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .badge-primary {
      background: rgba(74, 155, 155, 0.12);
      color: var(--color-accent);
    }

    .badge-secondary {
      background: rgba(232, 160, 32, 0.12);
      color: var(--color-accent2);
    }

    /* ── Form Styling ── */
    .form-card {
      background: var(--color-surface);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-md);
      padding: 30px;
      border: 1px solid var(--color-border);
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-full {
      grid-column: span 2;
    }

    .form-group {
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .form-label {
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--color-sidebar);
    }

    .form-control {
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--color-border);
      font-family: var(--font-main);
      font-size: 0.95rem;
      background: #fafafa;
      color: var(--color-text);
      transition: all var(--transition);
      outline: none;
    }

    .form-control:focus {
      background: var(--color-white);
      border-color: var(--color-accent);
      box-shadow: 0 0 0 3px rgba(74, 155, 155, 0.15);
    }

    .form-error {
      color: var(--color-danger);
      font-size: 0.8rem;
      margin-top: 4px;
      font-weight: 500;
    }

    /* ── Alerts ── */
    .alert {
      padding: 14px 20px;
      border-radius: var(--radius-sm);
      margin-bottom: 20px;
      font-size: 0.9rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-success {
      background: #ECFDF5;
      border: 1px solid #A7F3D0;
      color: #047857;
    }

    .alert-error {
      background: #FEF2F2;
      border: 1px solid #FECACA;
      color: #B91C1C;
    }

    /* ── Dashboard Stats ── */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: var(--color-surface);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-sm);
      padding: 24px;
      border: 1px solid var(--color-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: transform var(--transition);
    }

    .stat-card:hover {
      transform: translateY(-4px);
    }

    .stat-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .stat-value {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--color-sidebar);
    }

    .stat-label {
      font-size: 0.85rem;
      color: var(--color-text-muted);
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .stat-icon {
      font-size: 2.2rem;
      opacity: 0.85;
    }

    .dashboard-sections {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 25px;
    }

    .section-card {
      background: var(--color-surface);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-md);
      border: 1px solid var(--color-border);
      padding: 24px;
    }

    .section-title {
      font-size: 1.15rem;
      font-weight: 700;
      margin-bottom: 18px;
      color: var(--color-sidebar);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Tag Checkbox Grids */
    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 12px;
      background: #fafafa;
      padding: 16px;
      border-radius: var(--radius-sm);
      border: 1px solid var(--color-border);
      max-height: 200px;
      overflow-y: auto;
    }

    .checkbox-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .checkbox-item input {
      width: 16px;
      height: 16px;
      cursor: pointer;
    }
  </style>
  @yield('styles')
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/logo.png') }}" alt="CamboTrips Logo" class="logo-img" />
      <div class="logo-text">CamboTrips</div>
    </div>
    
    <ul class="sidebar-menu">
      <li class="menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
      </li>
      <li class="menu-item {{ Route::is('admin.provinces.*') ? 'active' : '' }}">
        <a href="{{ route('admin.provinces.index') }}">🗺️ Provinces</a>
      </li>
      <li class="menu-item {{ Route::is('admin.places.*') ? 'active' : '' }}">
        <a href="{{ route('admin.places.index') }}">📍 Places</a>
      </li>
      <li class="menu-item {{ Route::is('admin.tags.*') ? 'active' : '' }}">
        <a href="{{ route('admin.tags.index') }}">🏷️ Categories</a>
      </li>
      <li class="menu-item {{ Route::is('admin.reviews.*') ? 'active' : '' }}">
        <a href="{{ route('admin.reviews.index') }}">⭐ Reviews</a>
      </li>
      
      <li class="menu-item" style="margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 20px;">
        <a href="{{ route('home') }}">🏠 Back to Website</a>
      </li>
    </ul>

    <div class="sidebar-footer">
      Admin Panel v1.0
    </div>
  </aside>

  <!-- Main Content Area -->
  <main class="content-area">
    <!-- Flash Messages -->
    @if (session('success'))
      <div class="alert alert-success">
        <span>✅</span> {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-error">
        <span>❌</span> {{ session('error') }}
      </div>
    @endif

    @yield('content')
  </main>

  @yield('scripts')
</body>
</html>
