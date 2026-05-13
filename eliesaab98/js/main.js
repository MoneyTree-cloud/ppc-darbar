(function () {
  'use strict';

  // ------------------------------------------------------------
  // Sticky header on scroll
  // ------------------------------------------------------------
  var header = document.getElementById('siteHeader');
  function onScroll() {
    if (!header) return;
    if (window.scrollY > 40) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // ------------------------------------------------------------
  // Mobile nav toggle
  // ------------------------------------------------------------
  var navToggle = document.getElementById('navToggle');
  var siteNav   = document.getElementById('siteNav');
  if (navToggle && siteNav) {
    navToggle.addEventListener('click', function () {
      siteNav.classList.toggle('is-open');
    });
    siteNav.addEventListener('click', function (e) {
      var t = e.target;
      if (t && t.tagName === 'A') siteNav.classList.remove('is-open');
    });
  }

  // ------------------------------------------------------------
  // Smooth scroll for in-page anchors
  // ------------------------------------------------------------
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var hash = a.getAttribute('href');
      if (!hash || hash.length < 2) return;
      var el = document.querySelector(hash);
      if (!el) return;
      e.preventDefault();
      var offset = (header ? header.offsetHeight : 0) + 10;
      var top = el.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

  // ------------------------------------------------------------
  // Floor plan tabs
  // ------------------------------------------------------------
  var tabs   = document.querySelectorAll('.fp-tab');
  var panels = document.querySelectorAll('.fp-panel');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = tab.getAttribute('data-target');
      tabs.forEach(function (t) { t.classList.remove('is-active'); });
      panels.forEach(function (p) { p.classList.remove('is-active'); });
      tab.classList.add('is-active');
      var panel = document.getElementById(target);
      if (panel) panel.classList.add('is-active');
    });
  });

  // ------------------------------------------------------------
  // Gallery lightbox
  // ------------------------------------------------------------
  var lightbox      = document.getElementById('lightbox');
  var lightboxImg   = document.getElementById('lightboxImg');
  var lightboxClose = document.getElementById('lightboxClose');
  document.querySelectorAll('.gallery-grid a[data-lightbox]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      e.preventDefault();
      if (!lightbox || !lightboxImg) return;
      lightboxImg.src = a.getAttribute('href');
      lightboxImg.alt = a.getAttribute('data-alt') || 'Gallery image';
      lightbox.classList.add('is-open');
    });
  });
  if (lightboxClose) {
    lightboxClose.addEventListener('click', function () { lightbox.classList.remove('is-open'); });
  }
  if (lightbox) {
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) lightbox.classList.remove('is-open');
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && lightbox) lightbox.classList.remove('is-open');
  });

  // ------------------------------------------------------------
  // Scroll reveal
  // ------------------------------------------------------------
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          en.target.classList.add('is-in');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });
  } else {
    document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('is-in'); });
  }

  // ------------------------------------------------------------
  // Toast
  // ------------------------------------------------------------
  var toast;
  window.showToast = function (message, isError) {
    if (!toast) {
      toast = document.createElement('div');
      toast.className = 'toast';
      document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.toggle('is-error', !!isError);
    toast.classList.add('is-visible');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(function () {
      toast.classList.remove('is-visible');
    }, 4200);
  };

  // ------------------------------------------------------------
  // AJAX form submission
  // ------------------------------------------------------------
  function handleForm(form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var status = form.querySelector('.form-status');
      var btn    = form.querySelector('button[type="submit"], input[type="submit"]');
      var fd     = new FormData(form);

      // Basic client-side checks
      var name  = (fd.get('name')  || '').toString().trim();
      var email = (fd.get('email') || '').toString().trim();
      var phone = (fd.get('phone') || '').toString().trim();
      var phoneDigits = phone.replace(/\D+/g, '');

      if (name.length < 2) {
        setStatus(status, 'Please enter your full name.', 'error');
        return;
      }
      if (!/^\S+@\S+\.\S+$/.test(email)) {
        setStatus(status, 'Please enter a valid email address.', 'error');
        return;
      }
      if (phoneDigits.length < 10 || phoneDigits.length > 15) {
        setStatus(status, 'Please enter a valid phone number.', 'error');
        return;
      }

      var originalBtnText = btn ? btn.textContent : '';
      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }

      fetch(form.getAttribute('action') || 'process-form.php', {
        method: 'POST',
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        credentials: 'same-origin'
      })
        .then(function (r) { return r.json().catch(function () { return { success: false, message: 'Unexpected server response.' }; }); })
        .then(function (data) {
          if (data && data.success) {
            setStatus(status, data.message || 'Thank you. We will reach out shortly.', 'success');
            window.showToast(data.message || 'Enquiry received. We will call you back shortly.');
            form.reset();
            setTimeout(function () {
              if (status) { status.className = 'form-status'; status.textContent = ''; }
            }, 5000);
          } else {
            setStatus(status, (data && data.message) || 'Something went wrong. Please try again.', 'error');
            window.showToast((data && data.message) || 'Submission failed.', true);
          }
        })
        .catch(function () {
          setStatus(status, 'Network error. Please try again.', 'error');
          window.showToast('Network error. Please try again.', true);
        })
        .finally(function () {
          if (btn) { btn.disabled = false; btn.textContent = originalBtnText; }
        });
    });
  }

  function setStatus(el, msg, type) {
    if (!el) return;
    el.textContent = msg;
    el.className = 'form-status ' + (type === 'success' ? 'is-success' : 'is-error');
  }

  document.querySelectorAll('form[data-ajax="true"]').forEach(handleForm);

  // ------------------------------------------------------------
  // Current year
  // ------------------------------------------------------------
  var yearEl = document.getElementById('currentYear');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
})();
