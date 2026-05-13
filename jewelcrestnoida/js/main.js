/* =====================================================================
   M3M × Jacob & Co Residences — main.js
   AJAX form, mobile menu, modals, scroll reveal, toast, floor-plan tabs
   ===================================================================== */

(function () {
  'use strict';

  // ---------- Mobile menu ----------
  const menuToggle = document.querySelector('.mobile-menu-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  const menuClose  = document.querySelector('.mobile-menu-close');
  const menuOverlay = document.querySelector('.mobile-menu-overlay');

  function openMenu() {
    if (mobileMenu) { mobileMenu.classList.add('is-open'); mobileMenu.setAttribute('aria-hidden', 'false'); }
    if (menuOverlay) menuOverlay.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }
  function closeMenu() {
    if (mobileMenu) { mobileMenu.classList.remove('is-open'); mobileMenu.setAttribute('aria-hidden', 'true'); }
    if (menuOverlay) menuOverlay.classList.remove('is-open');
    document.body.style.overflow = '';
  }
  if (menuToggle) menuToggle.addEventListener('click', openMenu);
  if (menuClose) menuClose.addEventListener('click', closeMenu);
  if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);
  if (mobileMenu) {
    mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
  }

  // ---------- Modal ----------
  document.querySelectorAll('[data-modal-open]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const id = btn.getAttribute('data-modal-open');
      const modal = document.getElementById(id);
      if (modal) {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
      const modal = btn.closest('.modal');
      if (modal) modal.classList.remove('is-open');
      document.body.style.overflow = '';
    });
  });
  document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.modal').forEach(m => m.classList.remove('is-open'));
      document.body.style.overflow = '';
    }
  });

  // ---------- Toast ----------
  const toastEl = document.getElementById('hc-toast');
  function showToast(title, message) {
    if (!toastEl) return;
    toastEl.innerHTML = '<small>' + (title || 'Notice') + '</small><div>' + (message || '') + '</div>';
    requestAnimationFrame(() => toastEl.classList.add('is-visible'));
    setTimeout(() => toastEl.classList.remove('is-visible'), 5000);
  }

  // ---------- AJAX form submit ----------
  document.querySelectorAll('form.js-lead-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Honeypot
      const hp = form.querySelector('input[name="website"]');
      if (hp && hp.value) { return; }

      const msgBox = form.querySelector('.form-msg');
      const submit = form.querySelector('button[type="submit"]');
      if (msgBox) { msgBox.className = 'form-msg'; msgBox.textContent = ''; }
      if (submit) {
        submit.disabled = true;
        submit.dataset.label = submit.textContent;
        submit.textContent = 'Submitting...';
      }

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action || 'process-form.php', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();

        if (data.success) {
          if (msgBox) { msgBox.classList.add('success'); msgBox.textContent = data.message || 'Thank you. We will contact you shortly.'; }
          showToast('Enquiry received', data.message || 'Our team will contact you shortly.');
          form.reset();
          setTimeout(() => {
            if (msgBox) { msgBox.className = 'form-msg'; msgBox.textContent = ''; }
            // close modal if inside
            const modal = form.closest('.modal');
            if (modal) { modal.classList.remove('is-open'); document.body.style.overflow = ''; }
          }, 5000);
        } else {
          if (msgBox) { msgBox.classList.add('error'); msgBox.textContent = data.message || 'Something went wrong. Please try again.'; }
          showToast('Submission error', data.message || 'Please check the form and try again.');
        }
      } catch (err) {
        if (msgBox) { msgBox.classList.add('error'); msgBox.textContent = 'Network error. Please try again.'; }
        showToast('Network error', 'Please try again in a moment.');
      } finally {
        if (submit) { submit.disabled = false; submit.textContent = submit.dataset.label || 'Submit'; }
      }
    });
  });

  // ---------- Floor plan tabs ----------
  document.querySelectorAll('.tabs').forEach(tabs => {
    const buttons = tabs.querySelectorAll('button');
    const target = tabs.getAttribute('data-target');
    const container = target ? document.querySelector(target) : null;
    if (!container) return;
    const panels = container.querySelectorAll('.tab-panel');

    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const key = btn.getAttribute('data-tab');
        buttons.forEach(b => b.classList.toggle('is-active', b === btn));
        panels.forEach(p => p.classList.toggle('is-active', p.getAttribute('data-panel') === key));
      });
    });
  });

  // ---------- Scroll reveal ----------
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
  } else {
    document.querySelectorAll('.reveal').forEach(el => el.classList.add('is-visible'));
  }

  // ---------- Header shadow on scroll ----------
  const header = document.querySelector('.hc-header');
  if (header) {
    const onScroll = () => {
      header.style.boxShadow = window.scrollY > 20 ? '0 24px 40px -24px rgba(0,0,0,0.8)' : 'none';
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }
})();
