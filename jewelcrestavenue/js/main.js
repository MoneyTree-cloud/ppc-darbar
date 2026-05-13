/* ============================================================
   M3M Jewel Crest Avenue — main.js
   ============================================================ */
(function () {
  'use strict';

  /* ---------- sticky header ---------- */
  const header = document.getElementById('lux-header');
  if (header) {
    const onScroll = () => {
      if (window.scrollY > 40) header.classList.add('scrolled');
      else header.classList.remove('scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ---------- mobile menu ---------- */
  const menu        = document.querySelector('.mobile-menu');
  const menuToggle  = document.querySelector('.mobile-menu-toggle');
  const menuClose   = document.querySelector('.mobile-menu-close');
  const menuOverlay = document.querySelector('.mobile-menu-overlay');
  const openMenu  = () => { if (menu) menu.classList.add('open'); document.body.style.overflow = 'hidden'; };
  const closeMenu = () => { if (menu) menu.classList.remove('open'); document.body.style.overflow = ''; };
  if (menuToggle) menuToggle.addEventListener('click', openMenu);
  if (menuClose)  menuClose.addEventListener('click', closeMenu);
  if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);
  document.querySelectorAll('.mobile-menu nav a').forEach(a => a.addEventListener('click', closeMenu));

  /* ---------- reveal on scroll ---------- */
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('visible'), i * 80);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
    revealEls.forEach(el => io.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('visible'));
  }

  /* ---------- floor plan tabs ---------- */
  const fpTabs = document.querySelectorAll('.fp-tab');
  const fpPanels = document.querySelectorAll('.fp-panel');
  fpTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const key = tab.dataset.target;
      fpTabs.forEach(t => t.classList.remove('active'));
      fpPanels.forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      const panel = document.getElementById(key);
      if (panel) panel.classList.add('active');
    });
  });

  /* ---------- lightbox ---------- */
  const lb = document.querySelector('.lb');
  const lbImg = lb ? lb.querySelector('img') : null;
  const lbClose = lb ? lb.querySelector('.lb__close') : null;
  document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', () => {
      if (!lb || !lbImg) return;
      const img = item.querySelector('img');
      if (img) lbImg.src = img.getAttribute('data-full') || img.src;
      lb.classList.add('open');
    });
  });
  if (lbClose) lbClose.addEventListener('click', () => lb.classList.remove('open'));
  if (lb) lb.addEventListener('click', (e) => { if (e.target === lb) lb.classList.remove('open'); });
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && lb) lb.classList.remove('open'); });

  /* ---------- toast ---------- */
  function toast(msg, type) {
    let t = document.querySelector('.toast');
    if (!t) {
      t = document.createElement('div');
      t.className = 'toast';
      document.body.appendChild(t);
    }
    t.textContent = msg;
    t.classList.remove('err');
    if (type === 'err') t.classList.add('err');
    requestAnimationFrame(() => t.classList.add('show'));
    setTimeout(() => t.classList.remove('show'), 5000);
  }

  /* ---------- AJAX forms ---------- */
  const forms = document.querySelectorAll('form[data-ajax]');
  forms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msgEl  = form.querySelector('.form-msg');
      const submit = form.querySelector('button[type="submit"]');
      if (msgEl)  { msgEl.textContent = ''; msgEl.className = 'form-msg'; }
      if (submit) { submit.disabled = true; submit.dataset.label = submit.textContent; submit.textContent = 'Sending…'; }

      const fd = new FormData(form);

      try {
        const res = await fetch(form.action || 'process-form.php', {
          method: 'POST',
          body: fd,
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });

        let data;
        try { data = await res.json(); }
        catch (_) { data = { success: res.ok, message: res.ok ? 'Submitted.' : 'Server error.' }; }

        if (data.success) {
          if (msgEl) { msgEl.textContent = data.message; msgEl.className = 'form-msg form-msg--ok'; }
          toast(data.message, 'ok');
          form.reset();
          setTimeout(() => { if (msgEl) msgEl.textContent = ''; }, 5000);
        } else {
          const errMsg = data.message || 'Please check your inputs.';
          if (msgEl) { msgEl.textContent = errMsg; msgEl.className = 'form-msg form-msg--err'; }
          toast(errMsg, 'err');
        }
      } catch (err) {
        const errMsg = 'Network error. Please try again or call +91 94122 34688.';
        if (msgEl) { msgEl.textContent = errMsg; msgEl.className = 'form-msg form-msg--err'; }
        toast(errMsg, 'err');
      } finally {
        if (submit) { submit.disabled = false; submit.textContent = submit.dataset.label || 'Submit'; }
      }
    });
  });

  /* ---------- smooth anchor scroll offset for fixed header ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', (e) => {
      const id = a.getAttribute('href');
      if (!id || id === '#') return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const top = target.getBoundingClientRect().top + window.scrollY - 72;
      window.scrollTo({ top, behavior: 'smooth' });
    });
  });

  /* ---------- digit-only phone inputs ---------- */
  document.querySelectorAll('input[type="tel"]').forEach(el => {
    el.addEventListener('input', () => { el.value = el.value.replace(/[^0-9]/g, '').slice(0, 15); });
  });

})();
