/* SOBHA 3 BHK Greater Noida — interactions */
(function () {
    'use strict';

    // ===== Sticky header =====
    const header = document.querySelector('.site-header');
    const onScroll = () => {
        if (!header) return;
        header.classList.toggle('scrolled', window.scrollY > 40);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ===== Mobile menu =====
    const toggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    const setMenu = (open) => {
        if (!toggle || !navLinks) return;
        navLinks.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        const icon = toggle.querySelector('i');
        if (icon) icon.className = open ? 'fas fa-times' : 'fas fa-bars';
        document.body.style.overflow = open ? 'hidden' : '';
    };
    if (toggle && navLinks) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.addEventListener('click', () => {
            setMenu(!navLinks.classList.contains('open'));
        });
        navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setMenu(false)));
        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && navLinks.classList.contains('open')) setMenu(false);
        });
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!navLinks.classList.contains('open')) return;
            if (navLinks.contains(e.target) || toggle.contains(e.target)) return;
            setMenu(false);
        });
        // Reset when resizing past breakpoint
        let rz;
        window.addEventListener('resize', () => {
            clearTimeout(rz);
            rz = setTimeout(() => { if (window.innerWidth > 992) setMenu(false); }, 120);
        });
    }

    // ===== Tabs (floor plans) with aria + keyboard =====
    document.querySelectorAll('.tabs').forEach(tabs => {
        const btns = Array.from(tabs.querySelectorAll('.tab-btn'));
        const panels = Array.from(tabs.querySelectorAll('.tab-panel'));
        btns.forEach((btn, i) => {
            btn.setAttribute('role', 'tab');
            btn.setAttribute('aria-selected', btn.classList.contains('active') ? 'true' : 'false');
            btn.setAttribute('tabindex', btn.classList.contains('active') ? '0' : '-1');
            btn.addEventListener('click', () => activate(i));
            btn.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') { e.preventDefault(); activate((i + 1) % btns.length, true); }
                else if (e.key === 'ArrowLeft') { e.preventDefault(); activate((i - 1 + btns.length) % btns.length, true); }
                else if (e.key === 'Home') { e.preventDefault(); activate(0, true); }
                else if (e.key === 'End')  { e.preventDefault(); activate(btns.length - 1, true); }
            });
        });
        panels.forEach(p => p.setAttribute('role', 'tabpanel'));
        function activate(i, focus) {
            btns.forEach((b, bi) => {
                const active = bi === i;
                b.classList.toggle('active', active);
                b.setAttribute('aria-selected', active ? 'true' : 'false');
                b.setAttribute('tabindex', active ? '0' : '-1');
                if (active && focus) b.focus();
            });
            panels.forEach(p => p.classList.remove('active'));
            const target = tabs.querySelector('#' + btns[i].dataset.tab);
            if (target) target.classList.add('active');
        }
    });

    // ===== Toast =====
    function showToast(message, type = 'success') {
        let toast = document.querySelector('.toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'toast';
            document.body.appendChild(toast);
        }
        toast.className = 'toast ' + type;
        toast.innerHTML = message;
        requestAnimationFrame(() => toast.classList.add('show'));
        clearTimeout(toast._t);
        toast._t = setTimeout(() => toast.classList.remove('show'), 5000);
    }
    window.showToast = showToast;

    // ===== Form validation + AJAX submit =====

    // Sanitize helpers (match server-side rules)
    const stripCtrl   = (v) => String(v || '').replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/g, '');
    const collapseWs  = (v) => v.replace(/\s+/g, ' ').trim();
    const cleanString = (v, max) => collapseWs(stripCtrl(v)).slice(0, max || 120);
    const digitsOnly  = (v) => String(v || '').replace(/\D/g, '');

    // Unicode name pattern — letters (any script), marks, spaces, hyphens, dots, apostrophes, 2-100 chars
    const NAME_RE  = /^[\p{L}\p{M}\s\-\.']{2,100}$/u;
    const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function setFieldError(group, message) {
        if (!group) return;
        group.classList.add('has-error');
        group.classList.remove('is-valid');
        const el = group.querySelector('.field-error');
        if (el) el.textContent = message;
    }
    function clearFieldError(group, markValid) {
        if (!group) return;
        group.classList.remove('has-error');
        if (markValid) group.classList.add('is-valid');
        const el = group.querySelector('.field-error');
        if (el) el.textContent = '';
    }

    function validateField(input) {
        const group = input.closest('.form-group');
        const name  = input.name;

        if (name === 'name') {
            const v = cleanString(input.value, 100);
            if (v.length < 2)          return { ok: false, msg: 'Please enter at least 2 characters.' };
            if (!NAME_RE.test(v))      return { ok: false, msg: 'Letters, spaces, hyphens and apostrophes only.' };
            return { ok: true, value: v };
        }
        if (name === 'email') {
            const v = cleanString(input.value, 120).toLowerCase();
            if (v === '') return { ok: true, value: '' };        // optional
            if (!EMAIL_RE.test(v) || v.length > 120)
                return { ok: false, msg: 'Please enter a valid email address.' };
            return { ok: true, value: v };
        }
        if (name === 'phone') {
            const digits = digitsOnly(input.value);
            if (digits.length < 10 || digits.length > 15)
                return { ok: false, msg: 'Enter a valid 10–15 digit mobile number.' };
            if (/^(\d)\1{9,}$/.test(digits))
                return { ok: false, msg: 'Please enter a real mobile number.' };
            return { ok: true, value: digits };
        }
        return { ok: true, value: input.value };
    }

    function attachLiveValidation(form) {
        form.querySelectorAll('input[name="name"], input[name="email"], input[name="phone"]').forEach(input => {
            const group = input.closest('.form-group');
            // Normalize on blur (sanitize in place so user sees cleaned value)
            input.addEventListener('blur', () => {
                const r = validateField(input);
                if (r.ok) {
                    if (typeof r.value === 'string' && input.type !== 'tel') input.value = r.value;
                    clearFieldError(group, input.value !== '');
                } else {
                    setFieldError(group, r.msg);
                }
            });
            // Clear error state as user types again
            input.addEventListener('input', () => {
                if (group && group.classList.contains('has-error')) clearFieldError(group, false);
            });
        });
    }

    async function handleSubmit(form) {
        const successBox = form.querySelector('.form-success');
        const submitBtn  = form.querySelector('button[type="submit"]');
        const btnLabel   = submitBtn ? submitBtn.innerHTML : '';

        // Clear any prior success state
        if (successBox) successBox.classList.remove('show');

        // Validate all fields up-front
        let firstBadGroup = null;
        const values = {};
        const fields = form.querySelectorAll('input[name="name"], input[name="email"], input[name="phone"]');
        for (const input of fields) {
            const r = validateField(input);
            const group = input.closest('.form-group');
            if (!r.ok) {
                setFieldError(group, r.msg);
                if (!firstBadGroup) firstBadGroup = group;
            } else {
                clearFieldError(group, true);
                values[input.name] = r.value;
                // Write sanitized values back (phone kept as digits for submission)
                input.value = (input.name === 'phone') ? r.value : (typeof r.value === 'string' ? r.value : input.value);
            }
        }
        if (firstBadGroup) {
            const badInput = firstBadGroup.querySelector('input, select');
            if (badInput) badInput.focus();
            showToast('Please fix the highlighted field.', 'error');
            return;
        }

        // Honeypot check — if filled, silently "succeed"
        const hp = form.querySelector('input[name="website"]');
        const hp2 = form.querySelector('input[name="company_website"]');
        if ((hp && hp.value) || (hp2 && hp2.value)) {
            if (successBox) {
                successBox.textContent = 'Thank you!';
                successBox.classList.add('show');
            }
            form.reset();
            return;
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        }

        try {
            const fd = new FormData(form);
            const res = await fetch(form.action || 'process-form.php', {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
            let data = {};
            try { data = await res.json(); } catch (_) {}

            if (res.ok && data.success) {
                if (successBox) {
                    successBox.textContent = data.message || 'Thank you! We will be in touch.';
                    successBox.classList.add('show');
                }
                showToast('<strong>Request received.</strong><br>Our SOBHA advisor will call within 24 hours.', 'success');
                form.reset();
                form.querySelectorAll('.form-group').forEach(g => g.classList.remove('has-error', 'is-valid'));
                setTimeout(() => { if (successBox) successBox.classList.remove('show'); }, 6000);
            } else {
                // Server returned validation errors per-field
                if (data && data.errors && typeof data.errors === 'object') {
                    Object.keys(data.errors).forEach(k => {
                        const g = form.querySelector('.form-group[data-field="' + k + '"]');
                        if (g) setFieldError(g, data.errors[k]);
                    });
                    const first = form.querySelector('.form-group.has-error input, .form-group.has-error select');
                    if (first) first.focus();
                }
                showToast(data.message || 'Something went wrong. Please call +91 94122 34688.', 'error');
            }
        } catch (err) {
            showToast('Network error. Please try again or call +91 94122 34688.', 'error');
        } finally {
            if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = btnLabel; }
        }
    }

    document.querySelectorAll('form[data-ajax="true"]').forEach(form => {
        attachLiveValidation(form);
        form.addEventListener('submit', e => {
            e.preventDefault();
            handleSubmit(form);
        });
    });

    // ===== Smooth scroll for anchor links =====
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const id = a.getAttribute('href');
            if (id === '#' || id.length < 2) return;
            const target = document.querySelector(id);
            if (!target) return;
            e.preventDefault();
            const top = target.getBoundingClientRect().top + window.scrollY - 72;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    });

    // ===== Leaflet map (lazy) =====
    const mapEl = document.getElementById('map');
    if (mapEl && window.L) {
        const map = L.map('map', { scrollWheelZoom: false }).setView([28.537, 77.477], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const gold = L.divIcon({
            html: '<div style="background:#d3a538;width:18px;height:18px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.3)"></div>',
            className: '',
            iconSize: [18, 18],
            iconAnchor: [9, 9],
        });

        L.marker([28.4721, 77.4963], { icon: gold }).addTo(map)
            .bindPopup('<strong>SOBHA Aurum</strong><br>Sector 36, Greater Noida');
        L.marker([28.6045, 77.4426], { icon: gold }).addTo(map)
            .bindPopup('<strong>SOBHA Rivana</strong><br>Sector 1, Greater Noida West');
    }

    // ===== AOS init =====
    if (window.AOS) AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });

    // ===== Year in footer =====
    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    // ===== Count-up numbers (keyfacts + about stats) =====
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function animateCount(el, target, opts = {}) {
        const duration = opts.duration || 1400;
        const decimals = opts.decimals || 0;
        const prefix   = opts.prefix   || '';
        const suffix   = opts.suffix   || '';
        const separator = opts.separator || '';
        const start = performance.now();
        const from  = 0;
        function frame(now) {
            const t = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - t, 3);
            const value = from + (target - from) * eased;
            let formatted = value.toFixed(decimals);
            if (separator) {
                const parts = formatted.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, separator);
                formatted = parts.join('.');
            }
            el.textContent = prefix + formatted + suffix;
            if (t < 1) requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }

    const countTargets = document.querySelectorAll('[data-count]');
    if (countTargets.length && 'IntersectionObserver' in window && !prefersReduced) {
        // If element is already on screen at init (above fold), don't animate — just hold the final value.
        // Only animate when the user scrolls a below-fold element into view.
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                if (el.dataset.counted) return;
                el.dataset.counted = '1';
                animateCount(el, parseFloat(el.dataset.count), {
                    duration:  parseInt(el.dataset.duration || '1400', 10),
                    decimals:  parseInt(el.dataset.decimals || '0', 10),
                    prefix:    el.dataset.prefix   || '',
                    suffix:    el.dataset.suffix   || '',
                    separator: el.dataset.separator|| '',
                });
                io.unobserve(el);
            });
        }, { threshold: 0.5 });
        countTargets.forEach(el => {
            const rect = el.getBoundingClientRect();
            const alreadyInView = rect.top < window.innerHeight && rect.bottom > 0;
            if (alreadyInView) {
                // Already visible — stamp as counted with final value, no animation flash
                el.dataset.counted = '1';
            } else {
                io.observe(el);
            }
        });
    } else {
        // No observer / reduced motion — leave server-rendered final values in place (no reset)
        countTargets.forEach(el => { el.dataset.counted = '1'; });
    }

    // ===== Hero parallax (transforms ::before via CSS var) =====
    const hero = document.querySelector('.hero');
    if (hero && !prefersReduced && window.matchMedia('(min-width: 768px)').matches) {
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                const y = Math.min(window.scrollY, 600);
                hero.style.setProperty('--parallax-y', (y * 0.3) + 'px');
                ticking = false;
            });
        }, { passive: true });
        // Inject the style that reads the var
        const s = document.createElement('style');
        s.textContent = '.hero::before{transform:translate3d(0, var(--parallax-y, 0), 0)}';
        document.head.appendChild(s);
    }

    // ===== Scroll progress bar + scroll-indicator hide + scroll-top =====
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.setAttribute('aria-hidden', 'true');
    document.body.appendChild(progressBar);
    const scrollInd = document.querySelector('.scroll-indicator');
    const scrollTopBtn = document.getElementById('scrollTop');
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: prefersReduced ? 'auto' : 'smooth' });
        });
    }
    let progTicking = false;
    window.addEventListener('scroll', () => {
        if (progTicking) return;
        progTicking = true;
        requestAnimationFrame(() => {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            const pct = max > 0 ? (window.scrollY / max) * 100 : 0;
            progressBar.style.width = pct + '%';
            if (scrollInd) scrollInd.classList.toggle('hide', window.scrollY > window.innerHeight * 0.25);
            if (scrollTopBtn) scrollTopBtn.classList.toggle('visible', window.scrollY > window.innerHeight * 0.8);
            progTicking = false;
        });
    }, { passive: true });

    // ===== Section-head in-view (triggers gold-rule draw) =====
    const sectionHeads = document.querySelectorAll('.section-head');
    if (sectionHeads.length && 'IntersectionObserver' in window) {
        const shIo = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    shIo.unobserve(entry.target);
                }
            });
        }, { threshold: 0.35 });
        sectionHeads.forEach(el => shIo.observe(el));
    } else {
        sectionHeads.forEach(el => el.classList.add('in-view'));
    }

    // ===== Ripple on primary buttons =====
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-primary');
        if (!btn || prefersReduced) return;
        const r = btn.getBoundingClientRect();
        const ripple = document.createElement('span');
        const size = Math.max(r.width, r.height);
        ripple.style.cssText = `position:absolute;left:${e.clientX - r.left - size/2}px;top:${e.clientY - r.top - size/2}px;width:${size}px;height:${size}px;background:rgba(255,255,255,0.45);border-radius:50%;transform:scale(0);animation:sobhaRipple 0.6s ease-out;pointer-events:none;z-index:0`;
        if (getComputedStyle(btn).position === 'static') btn.style.position = 'relative';
        btn.appendChild(ripple);
        setTimeout(() => ripple.remove(), 650);
    });

    // Inject ripple keyframe once
    if (!document.getElementById('sobha-ripple-kf')) {
        const s = document.createElement('style');
        s.id = 'sobha-ripple-kf';
        s.textContent = '@keyframes sobhaRipple{to{transform:scale(2.4);opacity:0}}';
        document.head.appendChild(s);
    }

    // ===== Lightbox (gallery) with prev/next + keyboard =====
    const galleryItems = Array.from(document.querySelectorAll('.gallery-item'));
    if (galleryItems.length) {
        const images = galleryItems.map(it => it.querySelector('img')).filter(Boolean);
        let current = 0;

        const overlay = document.createElement('div');
        overlay.className = 'lightbox-overlay';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.style.cssText = 'position:fixed;inset:0;background:rgba(11,18,32,0.92);display:none;z-index:10000;align-items:center;justify-content:center;padding:2rem;backdrop-filter:blur(6px)';
        overlay.innerHTML = [
            '<img alt="" style="max-width:90%;max-height:85%;border-radius:8px;box-shadow:0 20px 50px rgba(0,0,0,0.5);transition:opacity 0.25s ease, transform 0.4s cubic-bezier(.2,.7,.2,1);transform:scale(0.92);cursor:zoom-out">',
            '<button class="lightbox-nav prev" aria-label="Previous image"><i class="fas fa-chevron-left"></i></button>',
            '<button class="lightbox-nav next" aria-label="Next image"><i class="fas fa-chevron-right"></i></button>',
            '<div class="lightbox-counter"><span class="lb-i">1</span> / <span class="lb-n">' + images.length + '</span></div>',
            '<button class="lightbox-close" aria-label="Close" style="position:absolute;top:1.25rem;right:1.25rem;width:44px;height:44px;border-radius:50%;background:#d3a538;color:#111;border:none;font-size:1.1rem;cursor:pointer;display:grid;place-items:center"><i class="fas fa-times"></i></button>'
        ].join('');
        document.body.appendChild(overlay);
        const ovImg   = overlay.querySelector('img');
        const lbiEl   = overlay.querySelector('.lb-i');
        const btnPrev = overlay.querySelector('.lightbox-nav.prev');
        const btnNext = overlay.querySelector('.lightbox-nav.next');
        const btnClose= overlay.querySelector('.lightbox-close');

        const show = (i) => {
            current = (i + images.length) % images.length;
            ovImg.style.opacity = '0';
            setTimeout(() => {
                ovImg.src = images[current].src;
                ovImg.alt = images[current].alt || '';
                lbiEl.textContent = (current + 1);
                ovImg.style.opacity = '1';
            }, 160);
        };
        const open = (i) => {
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            show(i);
            requestAnimationFrame(() => { ovImg.style.transform = 'scale(1)'; });
            btnClose.focus();
        };
        const close = () => {
            overlay.style.display = 'none';
            ovImg.style.transform = 'scale(0.92)';
            document.body.style.overflow = '';
        };

        btnPrev.addEventListener('click', (e) => { e.stopPropagation(); show(current - 1); });
        btnNext.addEventListener('click', (e) => { e.stopPropagation(); show(current + 1); });
        btnClose.addEventListener('click', (e) => { e.stopPropagation(); close(); });
        ovImg.addEventListener('click', close);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });

        // Focus trap — keep Tab cycling inside the modal
        document.addEventListener('keydown', (e) => {
            if (overlay.style.display !== 'flex') return;
            if (e.key === 'Escape')          close();
            else if (e.key === 'ArrowLeft')  show(current - 1);
            else if (e.key === 'ArrowRight') show(current + 1);
            else if (e.key === 'Tab') {
                const focusables = [btnPrev, btnNext, btnClose];
                const active = document.activeElement;
                const i = focusables.indexOf(active);
                e.preventDefault();
                const next = e.shiftKey
                    ? focusables[(i <= 0 ? focusables.length : i) - 1]
                    : focusables[(i + 1) % focusables.length];
                next.focus();
            }
        });

        // Swipe on touch
        let startX = 0;
        ovImg.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
        ovImg.addEventListener('touchend', (e) => {
            const dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
        });

        galleryItems.forEach((item, i) => item.addEventListener('click', () => open(i)));
    }

    // ===== Page loader — hide once window fully loads =====
    const loader = document.getElementById('pageLoader');
    if (loader) {
        const hide = () => { loader.classList.add('hidden'); setTimeout(() => loader.remove(), 600); };
        if (document.readyState === 'complete') {
            setTimeout(hide, 120);
        } else {
            window.addEventListener('load', () => setTimeout(hide, 120));
            // Safety — hide after 3s regardless
            setTimeout(hide, 3000);
        }
    }

    // ===== Viewport height fix for iOS Safari =====
    const setVh = () => document.documentElement.style.setProperty('--vh', window.innerHeight * 0.01 + 'px');
    setVh();
    window.addEventListener('resize', setVh);

    // ===== Mobile sticky CTA bar =====
    const mobileCta = document.getElementById('mobileCta');
    if (mobileCta && window.matchMedia('(max-width: 768px)').matches) {
        document.body.classList.add('has-mobile-cta');
        // Show after scrolling past hero
        const heroEl = document.querySelector('.hero');
        const showMobileCta = () => {
            if (!heroEl) return;
            const past = window.scrollY > heroEl.offsetHeight * 0.6;
            mobileCta.classList.toggle('visible', past);
        };
        window.addEventListener('scroll', showMobileCta, { passive: true });
        showMobileCta();

        // Hide when final CTA is in view
        const finalCta = document.getElementById('final-cta');
        if (finalCta && 'IntersectionObserver' in window) {
            new IntersectionObserver((entries) => {
                document.body.classList.toggle('final-cta-in-view', entries[0].isIntersecting);
            }, { threshold: 0.25 }).observe(finalCta);
        }
    }

    // ===== Image lazy fade-in =====
    // Adds 'img-loaded' class once an image finishes decoding, CSS fades it in.
    document.querySelectorAll('img').forEach(img => {
        if (img.complete && img.naturalHeight !== 0) {
            img.classList.add('img-loaded');
        } else {
            img.addEventListener('load',  () => img.classList.add('img-loaded'),  { once: true });
            img.addEventListener('error', () => img.classList.add('img-loaded'),  { once: true });
        }
    });

    // ===== Dynamically added images (e.g. lightbox src swap) — observe too =====
    const imgObserver = new MutationObserver(mutations => {
        mutations.forEach(m => {
            m.addedNodes && m.addedNodes.forEach(node => {
                if (node.nodeType === 1 && node.tagName === 'IMG') {
                    if (node.complete) node.classList.add('img-loaded');
                    else node.addEventListener('load', () => node.classList.add('img-loaded'), { once: true });
                }
            });
        });
    });
    imgObserver.observe(document.body, { childList: true, subtree: true });
})();
