/* ============================================================
   Great Value High Life — main.js
   - AJAX form submit (process-form.php)
   - Floor plan tabs
   - Scroll reveal
   - Nav toggle
   - Modal open/close
   - Toast notifications
   ============================================================ */

(function () {
  'use strict';

  // ---------- Nav mobile toggle ----------
  const navToggle = document.querySelector('.nav-toggle');
  const navList = document.querySelector('.nav-list');
  if (navToggle && navList) {
    navToggle.addEventListener('click', () => {
      navList.classList.toggle('is-open');
    });
    navList.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => navList.classList.remove('is-open'));
    });
  }

  // ---------- Modal handling ----------
  const modals = document.querySelectorAll('.modal');
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
  modals.forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      modals.forEach(m => m.classList.remove('is-open'));
      document.body.style.overflow = '';
    }
  });

  // ---------- Toast ----------
  function showToast(title, message, tone) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML =
      '<small>' + (title || 'Notice') + '</small>' +
      '<div>' + (message || '') + '</div>';
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('is-visible'));
    setTimeout(() => {
      toast.classList.remove('is-visible');
      setTimeout(() => toast.remove(), 500);
    }, 5000);
  }

  // ---------- AJAX form submit ----------
  const forms = document.querySelectorAll('form.js-lead-form');
  forms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Honeypot
      const hp = form.querySelector('input[name="website"]');
      if (hp && hp.value) { return; }

      const msgBox = form.querySelector('.form-msg');
      const submit = form.querySelector('button[type="submit"]');
      if (msgBox) { msgBox.className = 'form-msg'; msgBox.textContent = ''; }
      if (submit) { submit.disabled = true; submit.dataset.label = submit.textContent; submit.textContent = 'Submitting...'; }

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
    }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
  } else {
    document.querySelectorAll('.reveal').forEach(el => el.classList.add('is-visible'));
  }

  // ---------- Header shadow on scroll ----------
  const header = document.querySelector('.site-header');
  if (header) {
    const onScroll = () => {
      header.style.boxShadow = window.scrollY > 20 ? '0 20px 40px -20px rgba(0,0,0,0.7)' : 'none';
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }
})();
