document.addEventListener('DOMContentLoaded', function(){
  const search = document.getElementById('tableSearch');
  const table = document.getElementById('clientTable');

  if (search && table) {
    search.addEventListener('input', function(){
      const q = this.value.toLowerCase().trim();
      const rows = table.tBodies[0].rows;
      for (let r of rows) {
        const text = (r.textContent || r.innerText).toLowerCase();
        r.style.display = text.indexOf(q) !== -1 ? '' : 'none';
      }
    });
  }

  // Basic client-side validation for phone format
  const form = document.querySelector('.client-form');
  if (form) {
    form.addEventListener('submit', function(e){
      const phoneInput = form.querySelector('input[name="phone_number"]');
      if (phoneInput) {
        const v = phoneInput.value.replace(/\D/g,'');
        if (!/^\d{7,13}$/.test(v)) {
          e.preventDefault();
          alert('Please enter a valid phone number (7-13 digits).');
          phoneInput.focus();
        }
      }
    });
  }
});

// Navigation highlighting
(function () {
  const html = document.documentElement;
  const toggle = document.getElementById('navToggle');
  const nav = document.getElementById('mainNav');

  if (!toggle || !nav) return;

  function setExpanded(val) {
    toggle.setAttribute('aria-expanded', String(val));
    if (val) html.classList.add('nav-open'); else html.classList.remove('nav-open');
  }

  toggle.addEventListener('click', function (e) {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    setExpanded(!expanded);
  });

  // close on escape
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setExpanded(false);
  });

  // close when clicking outside nav on mobile
  document.addEventListener('click', function (e) {
    if (!nav.contains(e.target) && !toggle.contains(e.target)) setExpanded(false);
  });

})();

