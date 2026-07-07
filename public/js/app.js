// ============================================================
// CAMBOTRIPS — SPA Navigation Engine  (v2 — clean rewrite)
// ============================================================
//
// Root causes fixed in this version
// ----------------------------------
// BUG 1: initApp() added document click/submit/scroll listeners every time
//         it was called. After AJAX nav, executePageScripts() re-ran app.js,
//         calling initApp() again → duplicate listeners → double navigation.
// FIX:    Guard all global listeners with a single `_spaInitialised` flag.
//
// BUG 2: executePageScripts() iterated ALL <script> tags in the fetched HTML,
//         including the <script src="app.js"> tag in <head>. That loaded app.js
//         a second time, registered another click listener, and caused every
//         link click to fire navigateTo() twice.
// FIX:    Skip any script whose src includes "app.js".
//
// BUG 3: window.location.href inside the catch block caused a real full-page
//         reload on any transient network blip, triggering the browser's own
//         loading bar on top of the AJAX one.
// FIX:    Removed the fallback. Errors are shown as a toast instead.
//
// BUG 4: No navigation lock — rapidly clicking a link fired multiple fetch()
//         calls in parallel, causing content to flicker and render 2-3 times.
// FIX:    _navigating flag blocks concurrent navigations.
//
// BUG 5: onclick="window.location.href='...'" on card <div>s bypassed the SPA
//         router entirely and always caused a full page load.
// FIX:    All cards are now wrapped in proper <a> tags (Blade files updated).
//
// ============================================================

// ── State ─────────────────────────────────────────────────────
let _spaInitialised = false;
let _navigating     = false;

// ── Toast ─────────────────────────────────────────────────────
function showToast(message, type = 'success') {
  const existing = document.getElementById('toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id        = 'toast';
  toast.className = `toast toast-${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);

  requestAnimationFrame(() => toast.classList.add('show'));
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}

// ── Page fade-in ──────────────────────────────────────────────
function initPageTransition() {
  document.body.classList.remove('page-enter-active');
  document.body.classList.add('page-enter');
  requestAnimationFrame(() =>
    setTimeout(() => document.body.classList.add('page-enter-active'), 10)
  );
}

// ── Navbar mobile toggle ──────────────────────────────────────
// Safe to call multiple times — clones the button to wipe old listeners.
function setupNavbarToggle() {
  const toggle    = document.getElementById('navToggle');
  const navLinks  = document.querySelector('.nav-links');
  if (!toggle || !navLinks) return;

  const fresh = toggle.cloneNode(true);
  toggle.replaceWith(fresh);

  fresh.addEventListener('click', () => {
    navLinks.classList.toggle('open');
    fresh.classList.toggle('open');
  });
}

// Helper to check if a route is a standalone page bypassing SPA routing
function isStandaloneRoute(pathname) {
  return pathname.startsWith('/admin') ||
         pathname === '/logout' ||
         pathname === '/login' ||
         pathname === '/signup' ||
         pathname.startsWith('/auth/google') ||
         pathname.startsWith('/email/verify') ||
         pathname === '/forgot-password' ||
         pathname.startsWith('/reset-password');
}

// ── AJAX page swap ────────────────────────────────────────────
function navigateTo(url, addToHistory = true) {
  if (_navigating) return;          // prevent double-click races
  if (window.location.href === url) return; // already here

  _navigating = true;

  const appContent = document.getElementById('app-content');
  if (appContent) {
    appContent.style.transition = 'opacity 0.15s ease';
    appContent.style.opacity    = '0.4';
  }

  fetch(url, { headers: { 'X-SPA-Request': '1' } })
    .then(r => {
      if (!r.ok) throw new Error(`HTTP ${r.status}`);
      return r.text();
    })
    .then(html => {
      const parser = new DOMParser();
      const doc    = parser.parseFromString(html, 'text/html');

      // ── Detect non-SPA pages (standalone pages without #app-content) ──
      // Auth pages (login/signup) are standalone and have no #app-content.
      // If the fetched page has no #app-content, do a real navigation instead
      // of silently failing and leaving the current page dimmed/frozen.
      const newContent = doc.getElementById('app-content');
      if (!newContent) {
        // Fall back to a real browser navigation for standalone pages
        window.location.href = url;
        return;
      }

      // Swap title
      document.title = doc.title;

      // Swap main content
      if (appContent) {
        appContent.innerHTML   = newContent.innerHTML;
        appContent.style.opacity = '1';
      }

      // Swap nav-links (active class update)
      const curLinks = document.querySelector('.nav-links');
      const newLinks = doc.querySelector('.nav-links');
      if (curLinks && newLinks) curLinks.innerHTML = newLinks.innerHTML;

      // Swap nav-actions (auth state)
      const curActions = document.querySelector('.nav-actions');
      const newActions = doc.querySelector('.nav-actions');
      if (curActions && newActions) curActions.innerHTML = newActions.innerHTML;

      // Push history
      if (addToHistory) history.pushState({ url }, doc.title, url);

      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'instant' });

      // Re-attach navbar toggle (button was replaced by innerHTML swap above)
      setupNavbarToggle();

      // Run page-specific inline scripts from the NEW content only
      runInlineScripts(newContent);

      // Fade in
      initPageTransition();
    })
    .catch(err => {
      console.error('[SPA] Navigation failed:', err);
      if (appContent) appContent.style.opacity = '1';
      showToast('Page could not be loaded. Please try again.', 'error');
    })
    .finally(() => {
      // ALWAYS restore opacity — prevents the "frozen/dimmed" state
      if (appContent) appContent.style.opacity = '1';
      _navigating = false;
    });
}

// ── Run only the inline scripts inside the swapped content ────
// Skips any <script src="..."> tags — those are layout-level scripts
// (like app.js) that are already loaded and must NOT be re-executed.
function runInlineScripts(container) {
  if (!container) return;

  container.querySelectorAll('script').forEach(oldScript => {
    // Skip external scripts (app.js, CDN libs, etc.)
    if (oldScript.src) return;

    const s = document.createElement('script');
    s.textContent = oldScript.textContent;
    document.body.appendChild(s);
    s.remove();
  });
}

// ── One-time global event setup ───────────────────────────────
function initApp() {
  if (_spaInitialised) return;   // ← THE key guard: run once only
  _spaInitialised = true;

  setupNavbarToggle();

  // Sticky navbar + back-to-top
  const navbar      = document.getElementById('navbar');
  const backToTop   = document.getElementById('backToTop');

  const onScroll = () => {
    const y = window.scrollY;
    navbar?.classList.toggle('scrolled', y > 20);
    backToTop?.classList.toggle('show', y > 300);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // ── Delegate all link clicks ──────────────────────────────
  document.addEventListener('click', e => {
    const link = e.target.closest('a[href]');
    if (!link) return;

    // Let modifier keys / special attributes fall through
    if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    if (link.target === '_blank' || link.hasAttribute('download') || link.hasAttribute('data-bypass')) return;

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:') ||
        href.startsWith('mailto:') || href.startsWith('tel:')) return;

    try {
      const url = new URL(href, window.location.href);
      if (url.origin !== window.location.origin) return;

      // Hard-exclude admin, logout, and auth routes from SPA.
      if (isStandaloneRoute(url.pathname)) return;

      e.preventDefault();
      navigateTo(url.toString());
    } catch (_) { /* invalid URL — let browser handle */ }
  });

  // ── Delegate GET form submissions (search, filters) ───────
  document.addEventListener('submit', e => {
    const form = e.target;
    if (form.method.toLowerCase() !== 'get') return;

    try {
      const url = new URL(form.action || window.location.href, window.location.href);
      if (url.origin !== window.location.origin) return;
      if (isStandaloneRoute(url.pathname)) return;

      const data = new FormData(form);
      url.search = '';
      data.forEach((val, key) => { if (val !== '') url.searchParams.set(key, val); });

      e.preventDefault();
      navigateTo(url.toString());
    } catch (_) { /* invalid form action */ }
  });

  // ── Back / Forward buttons ────────────────────────────────
  window.addEventListener('popstate', e => {
    const target = (e.state && e.state.url) ? e.state.url : window.location.href;

    // If the target is a standalone/auth page, do a real navigation
    try {
      const u = new URL(target, window.location.href);
      if (isStandaloneRoute(u.pathname)) {
        window.location.href = target;
        return;
      }
    } catch (_) {}

    navigateTo(target, false);
  });

  // Fade in the initial page
  initPageTransition();
}

// ── Bootstrap ─────────────────────────────────────────────────
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initApp);
} else {
  initApp();
}
