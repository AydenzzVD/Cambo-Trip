// ============================================================
// KHMER TRAVEL — Interactive Application Script
// ============================================================

// ── Toast Notification ────────────────────────────────────────
function showToast(message, type = 'success') {
  const existing = document.getElementById('toast');
  if (existing) existing.remove();

  const toast = document.createElement('div');
  toast.id = 'toast';
  toast.className = `toast toast-${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);

  // Trigger CSS transition
  requestAnimationFrame(() => toast.classList.add('show'));
  
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}

// ── Page Fade-in Transition ───────────────────────────────────
function initPageTransition() {
  document.body.classList.add('page-enter');
  requestAnimationFrame(() => {
    setTimeout(() => document.body.classList.add('page-enter-active'), 10);
  });
}

// ── Setup Event Listeners ─────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  // Mobile navbar toggle menu
  const toggle = document.getElementById('navToggle');
  const navLinksEl = document.querySelector('.nav-links');
  
  if (toggle && navLinksEl) {
    toggle.addEventListener('click', () => {
      navLinksEl.classList.toggle('open');
      toggle.classList.toggle('open');
    });
  }

  // Sticky blur/shadow on scroll for header
  const navbar = document.getElementById('navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
    });
    // Check initial state
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }

  // Initialize page enter transitions
  initPageTransition();
});
