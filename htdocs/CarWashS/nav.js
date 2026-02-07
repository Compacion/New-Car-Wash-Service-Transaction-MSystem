// Navigation behavior: mobile toggle + user menu
document.addEventListener('DOMContentLoaded', function () {
  const header = document.getElementById('siteHeader');
  const navToggle = document.getElementById('navToggle');
  const userBtn = document.getElementById('userBtn');
  const userMenu = document.getElementById('userMenu');

  if (navToggle) {
    navToggle.addEventListener('click', function () {
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', String(!expanded));
      header.classList.toggle('nav-open');
    });
  }

  if (userBtn) {
    userBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      const expanded = userBtn.getAttribute('aria-expanded') === 'true';
      userBtn.setAttribute('aria-expanded', String(!expanded));
      if (userMenu) userMenu.hidden = expanded;
    });
  }

  // close on outside click
  document.addEventListener('click', function (e) {
    if (userMenu && !userMenu.contains(e.target) && userBtn && !userBtn.contains(e.target)) {
      userMenu.hidden = true;
      userBtn && userBtn.setAttribute('aria-expanded', 'false');
    }
  });

  // ESC to close
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      header && header.classList.remove('nav-open');
      navToggle && navToggle.setAttribute('aria-expanded', 'false');
      if (userMenu) userMenu.hidden = true;
      userBtn && userBtn.setAttribute('aria-expanded', 'false');
    }
  });
});
