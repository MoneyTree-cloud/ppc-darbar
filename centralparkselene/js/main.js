// Central Park Selene Tower - Main JavaScript

document.addEventListener('DOMContentLoaded', function() {

    // ==================== AJAX FORM HANDLER ====================
    var forms = document.querySelectorAll('form[data-ajax="true"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';
                submitBtn.style.opacity = '0.7';
            }

            var formData = new FormData(form);

            fetch(form.action || 'process-form.php', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    showToast(data.message, 'success');
                    form.reset();
                    var modal = form.closest('.modal');
                    if (modal && typeof $ !== 'undefined') {
                        setTimeout(function() { $(modal).modal('hide'); }, 2000);
                    }
                } else {
                    showToast(data.message || 'Something went wrong. Please try again.', 'error');
                }
            })
            .catch(function() {
                showToast('Network error. Please try again.', 'error');
            })
            .finally(function() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.style.opacity = '';
                }
            });
        });
    });

    // ==================== TOAST NOTIFICATION ====================
    function showToast(message, type) {
        var existing = document.getElementById('ajax-toast');
        if (existing) existing.remove();

        var toast = document.createElement('div');
        toast.id = 'ajax-toast';
        toast.style.cssText = 'position:fixed;top:24px;right:24px;z-index:99999;max-width:380px;padding:20px 26px;display:flex;align-items:center;gap:14px;border-radius:8px;box-shadow:0 16px 48px rgba(0,0,0,0.25);animation:toastIn 400ms ease both;font-family:Poppins,sans-serif;';

        if (type === 'success') {
            toast.style.background = '#195f46';
            toast.style.color = '#fff';
            toast.style.border = '1px solid #2a7d5e';
        } else {
            toast.style.background = '#8C2E2E';
            toast.style.color = '#fff';
            toast.style.border = '1px solid #a33';
        }

        var icon = type === 'success' ? '&#10003;' : '&#10007;';
        toast.innerHTML = '<span style="font-size:22px;">' + icon + '</span>'
            + '<p style="margin:0;font-size:14px;line-height:1.5;">' + message + '</p>';

        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 400ms ease';
            setTimeout(function() { toast.remove(); }, 400);
        }, 5000);
    }

    window.showToast = showToast;

    // ==================== MAGNIFIC POPUP INIT ====================
    if (typeof $ !== 'undefined' && $.fn.magnificPopup) {
        $('.without-caption').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-no-margins mfp-with-zoom',
            image: { verticalFit: true },
            zoom: { enabled: true, duration: 300 }
        });

        $('.with-caption').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            image: {
                verticalFit: true,
                titleSrc: function(item) {
                    return item.el.attr('title') || '';
                }
            },
            zoom: { enabled: true }
        });
    }

    // ==================== STICKY HEADER ====================
    var header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY >= 70) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // ==================== MOBILE MENU ====================
    var menuToggle = document.getElementById('menuToggle');
    var navMenu = document.getElementById('navMenu');
    var overlay = document.querySelector('.overlay');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            if (navMenu) navMenu.classList.add('active');
            if (overlay) overlay.classList.add('active');
        });
    }

    function closeMenu() {
        if (navMenu) navMenu.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
    }

    if (overlay) overlay.addEventListener('click', closeMenu);

    // Close menu when nav link clicked
    if (navMenu) {
        navMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    }

    // ==================== AUTO-OPEN MODAL (after 5s) ====================
    if (typeof $ !== 'undefined') {
        setTimeout(function() {
            $('#customModal').modal('show');
        }, 5000);
    }

    // ==================== SCROLL REVEAL (Intersection Observer) ====================
    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

        // Comprehensive selector list for all revealable elements
        var revealSelectors = [
            '.reveal',
            '.section-heading',
            '.section-label',
            '.price-card',
            '.amenity-card',
            '.highlight-item',
            '.payment-card',
            '.faq-item',
            '.overview-text',
            '.overview-img',
            '.siteplan-img',
            '.location-list',
            '.location-map',
            '.gallery-grid a',
            '.developer-text',
            '.developer-logo',
            '.contact-info',
            '.contact-form-wrap',
            '.fact-item',
            '.seo-block details',
            '.amenities-all'
        ].join(', ');

        document.querySelectorAll(revealSelectors).forEach(function(el) {
            if (!el.classList.contains('reveal')) {
                el.classList.add('reveal');
            }
            revealObserver.observe(el);
        });
    }

    // ==================== COUNTER ANIMATION ====================
    if ('IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounters(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        var factStrip = document.querySelector('.fact-strip');
        if (factStrip) {
            counterObserver.observe(factStrip);
        }
    }

    function animateCounters(container) {
        var numbers = container.querySelectorAll('.fact-number');
        numbers.forEach(function(el) {
            var text = el.textContent.trim();

            // Extract leading numeric part and suffix
            var match = text.match(/^([0-9,]+)(.*)/);
            if (!match) return; // Skip non-numeric like "G+25"

            var numStr = match[1].replace(/,/g, '');
            var suffix = match[2]; // e.g. "+", " Cr*"
            var target = parseInt(numStr, 10);
            if (isNaN(target) || target === 0) return;

            var hasComma = match[1].indexOf(',') !== -1;
            var duration = 1600; // ms
            var startTime = null;

            function formatNumber(n) {
                if (hasComma) {
                    return n.toLocaleString('en-IN');
                }
                return n.toString();
            }

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                // Ease out cubic
                var eased = 1 - Math.pow(1 - progress, 3);
                var current = Math.floor(eased * target);
                el.textContent = formatNumber(current) + suffix;
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = formatNumber(target) + suffix;
                }
            }

            requestAnimationFrame(step);
        });
    }

    // ==================== FAQ SMOOTH ANIMATION ====================
    // Use a click handler to animate max-height properly on details elements
    document.querySelectorAll('.faq-item').forEach(function(details) {
        var summary = details.querySelector('summary');
        var answer = details.querySelector('.faq-answer');
        if (!summary || !answer) return;

        summary.addEventListener('click', function(e) {
            e.preventDefault();

            if (details.hasAttribute('open')) {
                // Closing
                answer.style.maxHeight = answer.scrollHeight + 'px';
                // Force reflow
                answer.offsetHeight;
                answer.style.maxHeight = '0';
                answer.style.paddingBottom = '0';

                answer.addEventListener('transitionend', function handler() {
                    details.removeAttribute('open');
                    answer.removeEventListener('transitionend', handler);
                    answer.style.maxHeight = '';
                    answer.style.paddingBottom = '';
                }, { once: true });
            } else {
                // Opening
                details.setAttribute('open', '');
                var h = answer.scrollHeight;
                answer.style.maxHeight = '0';
                answer.style.paddingBottom = '0';
                // Force reflow
                answer.offsetHeight;
                answer.style.maxHeight = h + 'px';
                answer.style.paddingBottom = '16px';

                answer.addEventListener('transitionend', function handler() {
                    answer.removeEventListener('transitionend', handler);
                    answer.style.maxHeight = '';
                    answer.style.paddingBottom = '';
                }, { once: true });
            }
        });
    });

    // ==================== TOAST ANIMATION CSS ====================
    var style = document.createElement('style');
    style.textContent = '@keyframes toastIn{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}';
    document.head.appendChild(style);
});
