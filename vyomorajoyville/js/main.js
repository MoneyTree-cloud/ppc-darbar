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
    var NAME_RE  = /^[\p{L}\s.'\-]+$/u;
    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    function normalizePhone(raw) {
        var trimmed = String(raw || '').trim();
        var hasPlus = trimmed.charAt(0) === '+';
        var digits  = trimmed.replace(/\D+/g, '');
        return (hasPlus ? '+' : '') + digits;
    }

    function validateField(field) {
        var fieldName = field.getAttribute('name') || '';
        var value     = String(field.value || '').trim();

        if (fieldName === 'name') {
            if (!value)              return 'Please enter your name';
            if (value.length < 2)    return 'Name is too short';
            if (value.length > 80)   return 'Name is too long';
            if (!NAME_RE.test(value)) return 'Letters, spaces, . \' and - only';
            return '';
        }
        if (fieldName === 'email') {
            if (!value)               return 'Please enter your email';
            if (value.length > 120)   return 'Email is too long';
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
            if (!value) return 'Please select a configuration';
            return '';
        }
        if (fieldName === 'message') {
            if (value.length > 500) return 'Message is too long (max 500 chars)';
            return '';
        }
        return '';
    }

    function setFieldError(field, msg) {
        var fieldName = field.getAttribute('name') || '';
        var wrap   = field.closest('.field');
        var errEl  = wrap ? wrap.querySelector('.field-error[data-for="' + fieldName + '"]') : null;
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

            if (fn === 'phone') {
                f.addEventListener('input', function () {
                    f.value = normalizePhone(f.value);
                });
            }

            f.addEventListener('input', function () {
                if (f.classList.contains('has-error')) {
                    var msg = validateField(f);
                    if (!msg) setFieldError(f, '');
                }
            });

            f.addEventListener('blur', function () {
                setFieldError(f, validateField(f));
            });

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

                var phoneField = form.querySelector('[name="phone"]');
                if (phoneField) phoneField.value = normalizePhone(phoneField.value);

                var submitBtn    = form.querySelector('button[type="submit"]');
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

                            var popup = document.getElementById('popup-form');
                            if (popup && popup.contains(form)) {
                                setTimeout(function () { popup.classList.add('hidden'); }, 800);
                            }
                        } else {
                            showToast(json.message || 'Please check the form and try again.', 'error');
                        }
                    })
                    .catch(function () {
                        showToast('Network error. Please call us directly.', 'error');
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

    // ---------- Floor plan tabs ----------
    function bindFloorPlanTabs() {
        var tabs   = document.querySelectorAll('.fp-tab');
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
        var popup    = document.getElementById('popup-form');
        if (!popup) return;
        var closeBtn = document.getElementById('close-popup');
        var overlay  = document.getElementById('popup-form__overlay');

        function close() { popup.classList.add('hidden'); }
        function open(type) {
            var typeField = document.getElementById('popup-form-type');
            if (typeField && type) typeField.value = type;
            popup.classList.remove('hidden');
        }

        if (closeBtn) closeBtn.addEventListener('click', close);
        if (overlay)  overlay.addEventListener('click', close);
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

        document.querySelectorAll('[data-popup]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                open(el.getAttribute('data-popup'));
            });
        });
    }

    // ---------- Scroll reveal ----------
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

    // ---------- Header nav active on scroll ----------
    function bindNavHighlight() {
        var sectionIds = ['overview', 'residences', 'amenities', 'location', 'faq'];
        var links = {};
        sectionIds.forEach(function (id) {
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
        }, { rootMargin: '-25% 0px -65% 0px', threshold: 0 });

        sectionIds.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) io.observe(el);
        });
    }

    // ---------- Init ----------
    document.addEventListener('DOMContentLoaded', function () {
        bindLeadForms();
        bindFloorPlanTabs();
        bindPopup();
        bindScrollReveal();
        bindNavHighlight();
    });
})();
