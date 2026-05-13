/**
 * Ace Terra Yamuna Expressway — Main JS
 * Handles: popup form, AJAX submission, toast notifications, sticky header,
 * mobile menu, smooth scrolling, exit-intent popup
 */
document.addEventListener('DOMContentLoaded', function () {

    // --- Element Selections ---
    const header = document.getElementById('header');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const popupForm = document.getElementById('popup-form');
    const closePopupButton = document.getElementById('close-popup');
    const ctaButtons = document.querySelectorAll('#header-cta, #mobile-menu-cta, #hero-cta, #about-cta, #gallery-cta, .price-cta');

    // --- Sticky Header on Scroll ---
    window.addEventListener('scroll', function () {
        const isScrolled = window.scrollY > 50;
        header.classList.toggle('bg-white/80', isScrolled);
        header.classList.toggle('shadow-md', isScrolled);
        header.classList.toggle('backdrop-blur-sm', isScrolled);
        header.classList.toggle('border-b', isScrolled);
        header.classList.toggle('border-gray-200/50', isScrolled);
        header.classList.toggle('scrolled', isScrolled);

        // Show/hide mobile bottom bar
        var mobileBottomBar = document.getElementById('mobile-bottom-bar');
        if (mobileBottomBar) {
            if (isScrolled) { mobileBottomBar.classList.add('show'); }
            else { mobileBottomBar.classList.remove('show'); }
        }
    });

    // --- Mobile Menu Toggle ---
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () { mobileMenu.classList.toggle('hidden'); });
        mobileMenu.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' || e.target.closest('button')) {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // --- Popup Logic ---
    var openPopup = function () { if (popupForm) popupForm.classList.add('active'); };
    var closePopup = function () { if (popupForm) popupForm.classList.remove('active'); };

    ctaButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            openPopup();
        });
    });

    if (closePopupButton) closePopupButton.addEventListener('click', closePopup);
    if (popupForm) {
        popupForm.addEventListener('click', function (e) {
            if (e.target === popupForm) closePopup();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && popupForm && popupForm.classList.contains('active')) {
            closePopup();
        }
    });

    // --- Exit-Intent Popup (once per session) ---
    document.addEventListener('mouseleave', function (e) {
        if (e.clientY <= 0 && !sessionStorage.getItem('popupShown')) {
            openPopup();
            sessionStorage.setItem('popupShown', 'true');
        }
    });

    // --- Toast Notification ---
    window.showToast = function (msg, isError) {
        var bgColor = isError ? '#b91c1c' : '#16a34a';
        var toast = document.createElement('div');
        toast.style.cssText =
            'position:fixed;top:20px;left:50%;padding:16px 24px;background-color:' + bgColor + ';color:white;' +
            'border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.2);z-index:10001;font-family:Poppins,sans-serif;' +
            'opacity:0;transition:all 0.5s cubic-bezier(0.25,1,0.5,1);transform:translate(-50%,-100px);font-size:1rem;max-width:90vw;text-align:center;';
        toast.innerText = msg;
        document.body.appendChild(toast);
        setTimeout(function () { toast.style.opacity = '1'; toast.style.transform = 'translateX(-50%)'; }, 10);
        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, -100px)';
            setTimeout(function () { if (toast.parentNode) document.body.removeChild(toast); }, 500);
        }, 4000);
    };

    // --- Form Validation ---
    function validateForm(form) {
        var name = form.querySelector('[name="name"]').value.trim();
        var email = form.querySelector('[name="email"]').value.trim();
        var phone = form.querySelector('[name="phone"]').value.trim();
        if (!name) { showToast('Please enter your name.', true); return false; }
        if (!email || !/^\S+@\S+\.\S+$/.test(email)) { showToast('Please enter a valid email address.', true); return false; }
        if (!phone || !/^\d{10,15}$/.test(phone.replace(/\D/g, ''))) { showToast('Please enter a valid phone number.', true); return false; }
        return true;
    }

    // --- AJAX Form Submission ---
    function handleFormSubmit(e) {
        e.preventDefault();
        var form = e.target;
        if (!validateForm(form)) return;

        var submitBtn = form.querySelector('button[type="submit"]');
        var originalText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting...';
        }

        var formData = new FormData(form);

        fetch('process-form.php', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                showToast(data.message || 'Thank you! Our team will contact you shortly.', false);
                form.reset();
                // Close popup if open
                closePopup();
                // Show inline success message inside form container
                var successDiv = document.createElement('div');
                successDiv.className = 'text-center py-4 text-green-700 font-semibold';
                successDiv.innerText = data.message || 'Thank you! We will get in touch soon.';
                form.parentNode.insertBefore(successDiv, form);
                form.style.display = 'none';
                // Auto-reset form visibility after 5 seconds
                setTimeout(function () {
                    form.style.display = '';
                    if (successDiv.parentNode) successDiv.parentNode.removeChild(successDiv);
                }, 5000);
            } else {
                showToast(data.message || 'Something went wrong. Please try again.', true);
            }
        })
        .catch(function () {
            showToast('Network error. Please try again.', true);
        })
        .finally(function () {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }

    // Attach to both forms
    var contactForm = document.getElementById('contact-form');
    var popupContactForm = document.getElementById('popup-contact-form');
    if (contactForm) contactForm.addEventListener('submit', handleFormSubmit);
    if (popupContactForm) popupContactForm.addEventListener('submit', handleFormSubmit);

    // --- Smooth Scrolling for Anchor Links ---
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            var targetId = this.getAttribute('href');
            var targetElement = document.querySelector(targetId);
            if (targetElement) {
                var headerOffset = document.getElementById('header').offsetHeight;
                var elementPosition = targetElement.getBoundingClientRect().top;
                var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
            }
        });
    });

    // --- Mobile Enquire Button (bottom bar) ---
    var mobileEnquireBtn = document.getElementById('mobile-enquire-btn');
    if (mobileEnquireBtn) {
        mobileEnquireBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openPopup();
        });
    }
});
