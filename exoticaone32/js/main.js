/* Exotica One32 — main.js
   Header scroll state, mobile toggle, reveal animations,
   tabs, lightbox, AJAX form with CSRF + toast.
*/
(function () {
    'use strict';

    // ------------------------------------------------------------------
    // Header scroll state
    // ------------------------------------------------------------------
    const header = document.querySelector('.site-header');
    const onScroll = () => {
        if (!header) return;
        if (window.scrollY > 40) header.classList.add('scrolled');
        else header.classList.remove('scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ------------------------------------------------------------------
    // Mobile nav toggle
    // ------------------------------------------------------------------
    const toggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (toggle && navLinks) {
        toggle.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            toggle.setAttribute('aria-expanded', navLinks.classList.contains('open'));
        });
        navLinks.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') navLinks.classList.remove('open');
        });
    }

    // ------------------------------------------------------------------
    // Scroll reveal (IntersectionObserver)
    // ------------------------------------------------------------------
    const revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach((el) => io.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('visible'));
    }

    // ------------------------------------------------------------------
    // Floor plan tabs
    // ------------------------------------------------------------------
    const tabButtons = document.querySelectorAll('[data-tab]');
    const tabPanels  = document.querySelectorAll('[data-panel]');
    tabButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab');
            tabButtons.forEach((b) => b.classList.toggle('active', b === btn));
            tabPanels.forEach((p) => p.classList.toggle('active', p.getAttribute('data-panel') === target));
        });
    });

    // ------------------------------------------------------------------
    // Lightbox
    // ------------------------------------------------------------------
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const galItems = document.querySelectorAll('.gal-item');
    galItems.forEach((item) => {
        item.addEventListener('click', () => {
            const src = item.querySelector('img')?.getAttribute('src');
            if (src && lightbox && lightboxImg) {
                lightboxImg.src = src;
                lightbox.classList.add('open');
                document.body.classList.add('no-scroll');
            }
        });
    });
    const closeLightbox = () => {
        if (lightbox) {
            lightbox.classList.remove('open');
            document.body.classList.remove('no-scroll');
        }
    };
    lightbox?.addEventListener('click', (e) => {
        if (e.target === lightbox || e.target.classList.contains('lightbox-close')) closeLightbox();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });

    // ------------------------------------------------------------------
    // Toast
    // ------------------------------------------------------------------
    const toast = document.getElementById('toast');
    function showToast(message, type = 'success') {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.remove('error', 'success');
        toast.classList.add('show', type);
        setTimeout(() => toast.classList.remove('show'), 5000);
    }

    // ------------------------------------------------------------------
    // AJAX form handler (works for every form.lead-form on the page)
    // ------------------------------------------------------------------
    const forms = document.querySelectorAll('form.lead-form');
    forms.forEach((form) => {
        const msgBox = form.querySelector('.form-msg');
        const submitBtn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (msgBox) { msgBox.textContent = ''; msgBox.className = 'form-msg'; }

            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Sending...'; }

            const fd = new FormData(form);

            try {
                const res = await fetch('process-form.php', {
                    method: 'POST',
                    body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json().catch(() => ({}));

                if (data.csrf) {
                    const tokenField = form.querySelector('input[name="csrf_token"]');
                    if (tokenField) tokenField.value = data.csrf;
                }

                if (data.status === 'success') {
                    if (msgBox) {
                        msgBox.textContent = data.message || 'Thank you. We will reach out shortly.';
                        msgBox.className = 'form-msg success';
                    }
                    showToast(data.message || 'Thank you. We will reach out shortly.', 'success');
                    form.reset();
                    setTimeout(() => {
                        if (msgBox) msgBox.className = 'form-msg';
                    }, 5000);
                } else {
                    const err = (data && data.message) || 'Something went wrong. Please try again.';
                    if (msgBox) {
                        msgBox.textContent = err;
                        msgBox.className = 'form-msg error';
                    }
                    showToast(err, 'error');
                }
            } catch (err) {
                if (msgBox) {
                    msgBox.textContent = 'Network error. Please try again.';
                    msgBox.className = 'form-msg error';
                }
                showToast('Network error. Please try again.', 'error');
            } finally {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
            }
        });
    });

    // ------------------------------------------------------------------
    // Current year in footer
    // ------------------------------------------------------------------
    const yrEl = document.getElementById('current-year');
    if (yrEl) yrEl.textContent = new Date().getFullYear();
})();
