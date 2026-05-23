(function () {
    'use strict';

    // ---------- Toast ----------
    function showToast(message, type) {
        type = type || 'success';
        var toast = document.createElement('div');
        toast.className = 'toast' + (type === 'error' ? ' toast--error' : '');
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(function () { toast.classList.add('show'); }, 10);
        setTimeout(function () {
            toast.classList.remove('show');
            setTimeout(function () { toast.remove(); }, 500);
        }, 4500);
    }

    // ---------- Validation helpers ----------
    // Unicode letter pattern for multi-language names — matches tarc's spec.
    var NAME_RE  = /^[\p{L}\s.'\-]+$/u;
    // RFC-pragmatic email check. Not RFC 5322 perfect (nothing is), but rejects the 99% of garbage.
    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function normalizePhone(raw) {
        var trimmed = String(raw || '').trim();
        var hasPlus = trimmed.charAt(0) === '+';
        var digits = trimmed.replace(/\D+/g, '');
        return (hasPlus ? '+' : '') + digits;
    }

    function validateField(field) {
        var fieldName = field.getAttribute('name') || '';
        var value = String(field.value || '').trim();

        if (fieldName === 'name') {
            if (!value) return 'Please enter your name';
            if (value.length < 2) return 'Name is too short';
            if (value.length > 80) return 'Name is too long';
            if (!NAME_RE.test(value)) return 'Letters, spaces, . \' and - only';
            return '';
        }
        if (fieldName === 'email') {
            if (!value) return 'Please enter your email';
            if (value.length > 120) return 'Email is too long';
            if (!EMAIL_RE.test(value)) return 'Enter a valid email address';
            return '';
        }
        if (fieldName === 'phone') {
            if (!value) return 'Please enter your phone number';
            var digits = value.replace(/\D+/g, '');
            if (!/^[6-9][0-9]{9}$/.test(digits)) return 'Please enter a valid 10-digit Indian mobile number';
            return '';
        }
        if (fieldName === 'interested_in') {
            if (!value) return 'Please choose a residence';
            return '';
        }
        if (fieldName === 'message') {
            if (value.length > 500) return 'Message is too long (max 500)';
            return '';
        }
        return '';
    }

    function setFieldError(field, msg) {
        var fieldName = field.getAttribute('name') || '';
        var wrap = field.closest('.field');
        // Prefer an error span inside the field wrapper, else scoped by data-for under the form.
        var errEl = wrap ? wrap.querySelector('.field-error[data-for="' + fieldName + '"]') : null;
        if (!errEl) {
            var form = field.closest('form');
            errEl = form ? form.querySelector('.field-error[data-for="' + fieldName + '"]') : null;
        }
        if (msg) {
            field.classList.add('has-error');
            field.setAttribute('aria-invalid', 'true');
            if (errEl) errEl.textContent = msg;
        } else {
            field.classList.remove('has-error');
            field.removeAttribute('aria-invalid');
            if (errEl) errEl.textContent = '';
        }
    }


    function validateForm(form) {
        var fields = form.querySelectorAll('input[name], select[name], textarea[name]');
        var firstInvalid = null;
        fields.forEach(function (f) {
            var fn = f.getAttribute('name') || '';
            if (f.type === 'hidden' || fn === 'website') return;
            var msg = validateField(f);
            setFieldError(f, msg);
            if (msg && !firstInvalid) firstInvalid = f;
        });
        return firstInvalid;
    }

    function bindLiveValidation(form) {
        var fields = form.querySelectorAll('input[name], select[name], textarea[name]');
        fields.forEach(function (f) {
            var fn = f.getAttribute('name') || '';
            if (f.type === 'hidden' || fn === 'website') return;

            // Phone: strip non-digits (keep leading +) while typing
            if (fn === 'phone') {
                f.addEventListener('input', function () {
                    f.value = normalizePhone(f.value);
                });
            }

            // Clear error while they fix it
            f.addEventListener('input', function () {
                if (f.classList.contains('has-error')) {
                    var msg = validateField(f);
                    if (!msg) setFieldError(f, '');
                }
            });

            // Validate on blur
            f.addEventListener('blur', function () {
                var msg = validateField(f);
                setFieldError(f, msg);
            });

            // Select fires change, not blur, reliably
            if (f.tagName === 'SELECT') {
                f.addEventListener('change', function () {
                    setFieldError(f, validateField(f));
                });
            }
        });
    }

    // ---------- AJAX form submit ----------
    function bindLeadForms() {
        var forms = document.querySelectorAll('form.lead-form');
        forms.forEach(function (form) {
            bindLiveValidation(form);

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                var firstInvalid = validateForm(form);
                if (firstInvalid) {
                    showToast('Please check the highlighted fields.', 'error');
                    firstInvalid.focus({ preventScroll: false });
                    return;
                }

                // Normalize phone to a clean +digits form before sending
                var phoneField = form.querySelector('[name="phone"]');
                if (phoneField) phoneField.value = normalizePhone(phoneField.value);

                var submitBtn = form.querySelector('button[type="submit"]');
                var originalLabel = submitBtn ? submitBtn.innerHTML : '';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('aria-busy', 'true');
                    submitBtn.innerHTML = 'Sending…';
                }

                var data = new FormData(form);

                fetch('process-form.php', {
                    method: 'POST',
                    body: data,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                })
                    .then(function (r) {
                        return r.text().then(function (text) {
                            try { return { ok: r.ok, json: JSON.parse(text) }; }
                            catch (_) { return { ok: false, json: { success: false, message: 'Unexpected server response' } }; }
                        });
                    })
                    .then(function (res) {
                        var json = res.json || {};
                        if (json.success) {
                            showToast(json.message || 'Thank you — we will contact you shortly.');
                            form.reset();
                            form.querySelectorAll('.field-error').forEach(function (e) { e.textContent = ''; });
                            form.querySelectorAll('.has-error').forEach(function (e) { e.classList.remove('has-error'); });

                            // Close popup if form is inside popup
                            var popup = document.getElementById('popup-form');
                            if (popup && popup.contains(form)) {
                                setTimeout(function () { popup.classList.add('hidden'); }, 800);
                            }
                        } else {
                            showToast(json.message || 'Please check the form and try again.', 'error');
                        }
                    })
                    .catch(function () {
                        showToast('Network error. Please call +91 94122 34688.', 'error');
                    })
                    .finally(function () {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.removeAttribute('aria-busy');
                            submitBtn.innerHTML = originalLabel;
                        }
                    });
            });
        });
    }

    // ---------- Four Directions tabs ----------
    function bindDirectionTabs() {
        var tabs = document.querySelectorAll('.directions__tab');
        var panels = document.querySelectorAll('.directions__panel');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var target = tab.getAttribute('data-direction');
                tabs.forEach(function (t) { t.classList.remove('active'); });
                panels.forEach(function (p) { p.classList.remove('active'); });
                tab.classList.add('active');
                var panel = document.querySelector('.directions__panel[data-direction="' + target + '"]');
                if (panel) panel.classList.add('active');
            });
        });
    }

    // ---------- Floor plan tabs ----------
    function bindFloorPlanTabs() {
        var tabs = document.querySelectorAll('.fp-tab');
        var panels = document.querySelectorAll('.fp-panel');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var target = tab.getAttribute('data-fp');
                tabs.forEach(function (t) { t.classList.remove('active'); });
                panels.forEach(function (p) { p.classList.remove('active'); });
                tab.classList.add('active');
                var panel = document.querySelector('.fp-panel[data-fp="' + target + '"]');
                if (panel) panel.classList.add('active');
            });
        });
    }

    // ---------- Popup form ----------
    function bindPopup() {
        var popup = document.getElementById('popup-form');
        if (!popup) return;
        var closeBtn = document.getElementById('close-popup');
        var overlay = document.getElementById('popup-form__overlay');
        function close() { popup.classList.add('hidden'); }
        function open(type) {
            var typeField = document.getElementById('popup-form-type');
            if (typeField && type) typeField.value = type;
            popup.classList.remove('hidden');
        }
        if (closeBtn) closeBtn.addEventListener('click', close);
        if (overlay) overlay.addEventListener('click', close);
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

        // Triggers — any element with data-popup opens it
        document.querySelectorAll('[data-popup]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                open(el.getAttribute('data-popup'));
            });
        });
    }

    // ---------- Scroll reveal (IntersectionObserver) ----------
    function bindScrollReveal() {
        var targets = document.querySelectorAll('.reveal');
        if (!('IntersectionObserver' in window) || !targets.length) {
            targets.forEach(function (t) { t.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -12% 0px', threshold: 0.05 });
        targets.forEach(function (t) { io.observe(t); });
    }

    // ---------- Header micro-interactions (nav active state on scroll) ----------
    function bindNavHighlight() {
        var sections = ['overview', 'directions', 'residences', 'amenities', 'location', 'faq'];
        var links = {};
        sections.forEach(function (id) {
            var a = document.querySelector('.lux-nav a[href="#' + id + '"]');
            if (a) links[id] = a;
        });
        if (!Object.keys(links).length || !('IntersectionObserver' in window)) return;

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                var id = entry.target.id;
                if (!links[id]) return;
                if (entry.isIntersecting) {
                    Object.values(links).forEach(function (a) { a.classList.remove('is-active'); });
                    links[id].classList.add('is-active');
                }
            });
        }, { rootMargin: '-45% 0px -50% 0px' });

        sections.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) io.observe(el);
        });
    }

    // ---------- Keyboard nav for tab groups ----------
    function enhanceTabKeyboardNav(selector) {
        var groups = document.querySelectorAll(selector);
        groups.forEach(function (group) {
            var tabs = Array.prototype.slice.call(group.querySelectorAll('button'));
            tabs.forEach(function (tab, i) {
                tab.setAttribute('role', 'tab');
                tab.addEventListener('keydown', function (e) {
                    var next = null;
                    if (e.key === 'ArrowRight' || e.key === 'ArrowDown') next = tabs[(i + 1) % tabs.length];
                    else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') next = tabs[(i - 1 + tabs.length) % tabs.length];
                    if (next) { e.preventDefault(); next.focus(); next.click(); }
                });
            });
        });
    }

    // ---------- Init ----------
    document.addEventListener('DOMContentLoaded', function () {
        bindLeadForms();
        bindDirectionTabs();
        bindFloorPlanTabs();
        bindPopup();
        bindScrollReveal();
        bindNavHighlight();
        enhanceTabKeyboardNav('.directions__tabs, .fp-tabs');
    });
})();
