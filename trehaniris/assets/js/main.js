/**
 * Trehan Iris Broadway — PPC Landing Page JS
 * Vanilla JS only — zero frameworks
 * Includes: Forms, FAQ, Tracking, FOMO, Exit-Intent, Social Proof, Sticky CTA
 */

(function () {
    'use strict';

    // ========================================
    // AJAX Form Submission
    // ========================================
    function initForms() {
        document.querySelectorAll('.lead-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var formId = form.id;
                var btn = form.querySelector('.cta-btn');
                var errorEl = document.getElementById(formId + '-error');
                var successEl = document.getElementById(formId + '-success');

                var name = form.querySelector('[name="name"]').value.trim();
                var phone = form.querySelector('[name="phone"]').value.trim();

                if (!name) {
                    showError(errorEl, 'Please enter your name.');
                    return;
                }
                if (!/^[6-9]\d{9}$/.test(phone)) {
                    showError(errorEl, 'Please enter a valid 10-digit mobile number.');
                    return;
                }

                var hp = form.querySelector('[name="website"]');
                if (hp && hp.value) return;

                var originalText = btn.textContent;
                btn.disabled = true;
                btn.textContent = 'Submitting...';
                hideError(errorEl);

                var data = new FormData(form);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/api/submit-lead.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onload = function () {
                    btn.disabled = false;
                    btn.textContent = originalText;

                    if (xhr.status === 200) {
                        try {
                            var resp = JSON.parse(xhr.responseText);
                            if (resp.success) {
                                form.style.display = 'none';
                                var urgency = form.parentElement.querySelector('.form-urgency');
                                if (urgency) urgency.style.display = 'none';
                                if (successEl) successEl.style.display = 'block';

                                // Close exit popup if this was the exit form
                                if (formId === 'exitForm') {
                                    setTimeout(function() {
                                        var popup = document.getElementById('exitPopup');
                                        if (popup) popup.classList.remove('active');
                                    }, 2000);
                                }

                                fireConversionEvents(data);
                                trackEvent('form_submit', formId);
                            } else {
                                showError(errorEl, resp.message || 'Something went wrong. Please try again.');
                            }
                        } catch (ex) {
                            showError(errorEl, 'Something went wrong. Please try again.');
                        }
                    } else {
                        showError(errorEl, 'Server error. Please call us directly.');
                    }
                };

                xhr.onerror = function () {
                    btn.disabled = false;
                    btn.textContent = originalText;
                    showError(errorEl, 'Network error. Please check your connection.');
                };

                xhr.send(data);
            });
        });
    }

    function showError(el, msg) {
        if (el) { el.textContent = msg; el.style.display = 'block'; }
    }
    function hideError(el) {
        if (el) el.style.display = 'none';
    }

    // ========================================
    // Conversion Tracking Events
    // ========================================
    function fireConversionEvents(formData) {
        if (typeof gtag === 'function') {
            gtag('event', 'conversion', { send_to: window.GADS_CONVERSION_ID || '' });
            gtag('event', 'generate_lead', {
                event_category: 'form',
                event_label: formData.get('landing_page') || ''
            });
        }
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: 'form_submission',
            formVariant: formData.get('variant') || 'A',
            utmSource: formData.get('utm_source') || '',
            utmCampaign: formData.get('utm_campaign') || ''
        });
        if (typeof fbq === 'function') { fbq('track', 'Lead'); }
    }

    // ========================================
    // Event Tracking Helper
    // ========================================
    window.trackEvent = function (action, label) {
        if (typeof gtag === 'function') {
            gtag('event', action, { event_label: label });
        }
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ event: action, eventLabel: label });
    };

    // ========================================
    // FAQ Accordion
    // ========================================
    function initFAQ() {
        document.querySelectorAll('.faq-question').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var item = btn.parentElement;
                var answer = item.querySelector('.faq-answer');
                var isActive = item.classList.contains('active');

                document.querySelectorAll('.faq-item.active').forEach(function (open) {
                    open.classList.remove('active');
                    open.querySelector('.faq-answer').style.maxHeight = null;
                    open.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
                });

                if (!isActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    // ========================================
    // Scroll Depth Tracking
    // ========================================
    function initScrollTracking() {
        var milestones = [25, 50, 75, 100];
        var triggered = {};
        window.addEventListener('scroll', function () {
            var scrollPct = Math.round(
                (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100
            );
            milestones.forEach(function (m) {
                if (scrollPct >= m && !triggered[m]) {
                    triggered[m] = true;
                    trackEvent('scroll_depth', m + '%');
                }
            });
        }, { passive: true });
    }

    // ========================================
    // Time on Page Tracking
    // ========================================
    function initTimeTracking() {
        [30, 60, 120].forEach(function (sec) {
            setTimeout(function () {
                trackEvent('time_on_page', sec + 's');
            }, sec * 1000);
        });
    }

    // ========================================
    // Smooth Scroll for Anchor Links
    // ========================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (a) {
            a.addEventListener('click', function (e) {
                var target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    // ========================================
    // Phone Input Auto-format
    // ========================================
    function initPhoneInput() {
        document.querySelectorAll('input[type="tel"]').forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 10);
            });
        });
    }

    // ========================================
    // EXIT-INTENT POPUP
    // ========================================
    function initExitIntent() {
        var popup = document.getElementById('exitPopup');
        var closeBtn = document.getElementById('exitPopupClose');
        if (!popup || !closeBtn) return;

        var shown = false;
        var hasConverted = false;

        // Check if already shown this session
        if (sessionStorage.getItem('exit_popup_shown')) return;

        // Desktop: mouse leaves viewport at top
        document.addEventListener('mouseout', function (e) {
            if (shown || hasConverted) return;
            if (e.clientY < 5 && e.relatedTarget === null) {
                showPopup();
            }
        });

        // Mobile: back button / scroll-up-fast intent (after 30s)
        setTimeout(function () {
            var lastScroll = window.scrollY;
            window.addEventListener('scroll', function () {
                if (shown || hasConverted) return;
                var current = window.scrollY;
                // Fast upward scroll suggests intent to leave
                if (lastScroll - current > 300 && current > 500) {
                    showPopup();
                }
                lastScroll = current;
            }, { passive: true });
        }, 30000);

        function showPopup() {
            shown = true;
            popup.classList.add('active');
            sessionStorage.setItem('exit_popup_shown', '1');
            trackEvent('exit_popup', 'shown');
        }

        closeBtn.addEventListener('click', function () {
            popup.classList.remove('active');
            trackEvent('exit_popup', 'closed');
        });

        popup.addEventListener('click', function (e) {
            if (e.target === popup) {
                popup.classList.remove('active');
            }
        });
    }

    // ========================================
    // SOCIAL PROOF TOAST (toned down — 3 max, longer intervals)
    // ========================================
    function initSocialProof() {
        var toast = document.getElementById('socialToast');
        var toastName = document.getElementById('toastName');
        var toastAction = document.getElementById('toastAction');
        var toastTime = document.getElementById('toastTime');
        if (!toast) return;

        // Fewer entries, more believable — initials only
        var entries = [
            { name: 'R.S. from Gurgaon', action: 'downloaded the floor plan', time: 'a few minutes ago' },
            { name: 'P.K. from Delhi', action: 'booked a site visit', time: '12 minutes ago' },
            { name: 'A.M. from Noida', action: 'requested the price list', time: '25 minutes ago' },
        ];

        var showCount = 0;

        function showToast() {
            if (showCount >= entries.length) return;
            var entry = entries[showCount];
            showCount++;

            toastName.textContent = entry.name;
            toastAction.textContent = entry.action;
            toastTime.textContent = entry.time;

            toast.classList.add('visible');

            setTimeout(function () {
                toast.classList.remove('visible');
            }, 4000);
        }

        // First after 20s, then every 45s
        setTimeout(function () {
            showToast();
            var interval = setInterval(function () {
                showToast();
                if (showCount >= entries.length) clearInterval(interval);
            }, 45000);
        }, 20000);
    }

    // ========================================
    // STICKY DESKTOP CTA BAR
    // ========================================
    function initStickyCta() {
        var bar = document.getElementById('stickyCta');
        var header = document.getElementById('siteHeader');
        if (!bar) return;

        var heroHeight = document.querySelector('.hero');
        var triggerPoint = heroHeight ? heroHeight.offsetHeight + 200 : 800;

        window.addEventListener('scroll', function () {
            if (window.scrollY > triggerPoint) {
                bar.classList.add('visible');
                if (header) header.style.opacity = '0';
                if (header) header.style.pointerEvents = 'none';
            } else {
                bar.classList.remove('visible');
                if (header) header.style.opacity = '1';
                if (header) header.style.pointerEvents = 'auto';
            }
        }, { passive: true });
    }

    // ========================================
    // Initialize Everything
    // ========================================
    document.addEventListener('DOMContentLoaded', function () {
        initForms();
        initFAQ();
        initScrollTracking();
        initTimeTracking();
        initSmoothScroll();
        initPhoneInput();
        initExitIntent();
        initSocialProof();
        initStickyCta();
    });

})();
