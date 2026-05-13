// Main JavaScript for Paras Meerut Plots

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const ctaButtons = document.querySelectorAll('.cta-button');
    const floorButtons = document.querySelectorAll('.floor-btn');
    const floorPlans = document.querySelectorAll('.floor-plan-item');
    const galleryItems = document.querySelectorAll('.gallery-item img');
    const popupForm = document.getElementById('popup-form');
    const popupFormType = document.getElementById('popup-form-type');
    const closePopupBtn = document.getElementById('close-popup');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');

    // Initialize lightbox elements
    let lightboxOverlay = document.createElement('div');
    lightboxOverlay.className = 'lightbox-overlay';
    lightboxOverlay.innerHTML = `
        <div class="lightbox-content">
            <img class="lightbox-img" src="" alt="Gallery Image">
            <div class="lightbox-close">&times;</div>
            <div class="lightbox-nav">
                <div class="lightbox-nav-btn lightbox-prev">&lt;</div>
                <div class="lightbox-nav-btn lightbox-next">&gt;</div>
            </div>
        </div>
    `;
    document.body.appendChild(lightboxOverlay);

    // Legacy sticky header disabled — new .lux-header in includes/header.php handles scroll state
    // createStickyHeader();

    // Handle CTA button click for popup with animation
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (popupForm) {
                // Set form type based on data-form-type attribute or button text
                const buttonText = this.textContent.trim().toUpperCase();
                const dataType = this.getAttribute('data-form-type');

                if (popupFormType) {
                    if (dataType) {
                        popupFormType.value = dataType;
                    } else if (buttonText.includes('SITE VISIT') || buttonText.includes('VIEWING') || buttonText.includes('VISIT')) {
                        popupFormType.value = 'site_visit';
                    } else if (buttonText.includes('BROCHURE')) {
                        popupFormType.value = 'brochure';
                    } else if (buttonText.includes('QUOTE')) {
                        popupFormType.value = 'price_quote';
                    } else if (buttonText.includes('FLOOR PLAN') || buttonText.includes('MASTER PLAN')) {
                        popupFormType.value = 'floor_plan';
                    } else {
                        popupFormType.value = 'general';
                    }
                }
                
                // Show popup with fade-in effect
                popupForm.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
                
                // Animate form fields with staggered delay
                const formControls = popupForm.querySelectorAll('input, select, textarea');
                if (formControls.length) {
                    formControls.forEach((control, index) => {
                        control.style.opacity = '0';
                        control.style.transform = 'translateY(20px)';
                        control.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        
                        setTimeout(() => {
                            control.style.opacity = '1';
                            control.style.transform = 'translateY(0)';
                        }, 100 + (index * 100));
                    });
                }
                
                // Animate the submit button with a pulse effect
                const submitButton = popupForm.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.style.animation = 'none';
                    setTimeout(() => {
                        submitButton.style.animation = 'pulse 1.5s ease-in-out 1s';
                    }, 600);
                }
            }
        });
    });

    // Close popup when clicking the close button or outside
    if (closePopupBtn) {
        closePopupBtn.addEventListener('click', closePopup);
    }
    
    if (popupForm) {
        popupForm.addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });

        // Close popup with ESC key for accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !popupForm.classList.contains('hidden')) {
                closePopup();
            }
        });
    }

    // Handle floor plan tabs
    console.log('Floor buttons found:', floorButtons.length);
    console.log('Floor plans found:', floorPlans.length);
    
    floorButtons.forEach((button, idx) => {
        button.addEventListener('click', function() {
            console.log('Clicked on floor plan button index:', idx);
            
            // Remove active class from all buttons and floor plans
            floorButtons.forEach(btn => btn.classList.remove('active'));
            floorPlans.forEach(plan => {
                plan.classList.remove('active');
                plan.classList.add('hidden');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get index of button
            const index = Array.from(floorButtons).indexOf(this);
            console.log('Button index:', index);
            
            // Show corresponding floor plan
            if (floorPlans[index]) {
                floorPlans[index].classList.add('active');
                floorPlans[index].classList.remove('hidden');
                console.log('Showing floor plan at index:', index);
            } else {
                console.error('No floor plan found at index:', index);
            }
        });
    });

    // Gallery lightbox
    let currentImageIndex = 0;
    const lightboxImg = document.querySelector('.lightbox-img');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');

    galleryItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            currentImageIndex = index;
            openLightbox(this.src);
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightboxOverlay) {
        lightboxOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
    }

    if (lightboxPrev) {
        lightboxPrev.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateLightbox('prev');
        });
    }

    if (lightboxNext) {
        lightboxNext.addEventListener('click', function(e) {
            e.stopPropagation();
            navigateLightbox('next');
        });
    }

    // Mobile menu toggle - Fix for hamburger menu
    const mobileMenuButtons = document.querySelectorAll('.mobile-menu-toggle');
    console.log('Mobile menu buttons found:', mobileMenuButtons.length);
    
    if (mobileMenuButtons.length > 0) {
        mobileMenuButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log('Mobile menu button clicked');
                if (mobileMenu) {
                    console.log('Mobile menu found, adding active class');
                    mobileMenu.classList.add('active');
                    // Remove inline styles that might be interfering
                    mobileMenu.style.transform = '';
                    mobileMenu.style.display = 'block';
                    mobileMenu.style.animation = 'slideInRight 0.3s forwards';
                } else {
                    console.error('Mobile menu element not found');
                }
                
                if (mobileMenuOverlay) {
                    console.log('Adding mobile menu overlay');
                    mobileMenuOverlay.style.display = 'block';
                } else {
                    console.error('Mobile menu overlay not found');
                }
                
                document.body.style.overflow = 'hidden';
            });
        });
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        // Setup input event listeners to clear errors when user types
        const allInputs = form.querySelectorAll('input, select, textarea');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Remove the error class
                input.classList.remove('input-error');
                
                // Remove any error messages
                const existingError = input.parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
            });
        });
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Get all required inputs
            const requiredInputs = form.querySelectorAll('[required]');
            
            requiredInputs.forEach(input => {
                // Remove existing error messages
                const existingError = input.parentNode.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                // Remove existing error styling
                input.classList.remove('input-error');
                
                // Check if input is empty
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('input-error');
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'error-message';
                    errorMessage.textContent = 'This field is required';
                    input.parentNode.appendChild(errorMessage);
                }
                
                // Validate name field (if it has the name attribute 'name')
                if (input.name === 'name' && input.value.trim()) {
                    // Check minimum length
                    if (input.value.trim().length < 2) {
                        isValid = false;
                        input.classList.add('input-error');
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Name must be at least 2 characters long';
                        input.parentNode.appendChild(errorMessage);
                    }
                    
                    // Check for valid characters (similar to our pattern attribute)
                    const nameRegex = /^[a-zA-Z\s.'\\-]+$/;
                    if (!nameRegex.test(input.value.trim())) {
                        isValid = false;
                        input.classList.add('input-error');
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Name contains invalid characters';
                        input.parentNode.appendChild(errorMessage);
                    }
                }
                
                // Validate email format
                if (input.type === 'email' && input.value.trim()) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value.trim())) {
                        isValid = false;
                        input.classList.add('input-error');
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Please enter a valid email address';
                        input.parentNode.appendChild(errorMessage);
                    }
                }
                
                // Validate phone number (10-15 digits, allowing formatting characters)
                if (input.type === 'tel' && input.value.trim()) {
                    // First remove all non-digit characters for validation
                    const digitsOnly = input.value.trim().replace(/\D/g, '');
                    
                    if (digitsOnly.length < 10 || digitsOnly.length > 15) {
                        isValid = false;
                        input.classList.add('input-error');
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Please enter a valid phone number (10-15 digits)';
                        input.parentNode.appendChild(errorMessage);
                    }
                }
                
                // Validate select fields (dropdown)
                if (input.tagName.toLowerCase() === 'select' && input.required) {
                    if (input.value === '' || input.selectedIndex === 0 && input.options[0].disabled) {
                        isValid = false;
                        input.classList.add('input-error');
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'error-message';
                        errorMessage.textContent = 'Please select an option';
                        input.parentNode.appendChild(errorMessage);
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                return;
            }

            // AJAX submit — no page reload
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';
                submitBtn.style.opacity = '0.7';
            }

            const formData = new FormData(form);

            fetch(form.action || 'process-form.php', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Replace form with success message
                    const wrapper = form.closest('.glass-form') || form.parentElement;
                    const msg = document.createElement('div');
                    msg.style.cssText = 'text-align:center; padding:40px 20px;';
                    msg.innerHTML = '<div style="width:64px;height:64px;border:2px solid var(--gold-500);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:var(--gold-500);font-size:28px;">&#10003;</div>'
                        + '<h3 style="font-family:var(--font-serif);font-size:24px;font-weight:500;margin:0 0 12px;color:inherit;">Thank You</h3>'
                        + '<p style="font-size:14px;line-height:1.7;color:inherit;opacity:0.8;margin:0;">' + data.message + '</p>';
                    form.style.display = 'none';
                    wrapper.appendChild(msg);

                    // Show toast
                    showToast(data.message, 'success');

                    // Auto-reset: popup closes after 4s, all others reset after 5s
                    if (popupForm && wrapper.closest('#popup-form')) {
                        setTimeout(function() { closePopup(); form.style.display = ''; msg.remove(); form.reset(); }, 4000);
                    } else {
                        setTimeout(function() { form.style.display = ''; msg.remove(); form.reset(); }, 5000);
                    }
                } else {
                    // Show error inline
                    let errEl = form.querySelector('.ajax-error');
                    if (!errEl) {
                        errEl = document.createElement('div');
                        errEl.className = 'ajax-error';
                        errEl.style.cssText = 'color:var(--error,#8C2E2E);font-size:13px;text-align:center;padding:12px 0;';
                        form.insertBefore(errEl, submitBtn);
                    }
                    errEl.textContent = data.message || 'Something went wrong. Please try again.';
                    showToast(data.message || 'Something went wrong. Please try again.', 'error');
                }
            })
            .catch(function() {
                // Network error — fall back to normal form submit
                form.removeEventListener('submit', arguments.callee);
                form.submit();
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

    // Toast notification
    function showToast(message, type) {
        var existing = document.getElementById('ajax-toast');
        if (existing) existing.remove();

        var toast = document.createElement('div');
        toast.id = 'ajax-toast';
        toast.style.cssText = 'position:fixed;top:24px;right:24px;z-index:3000;max-width:380px;padding:22px 28px;display:flex;align-items:center;gap:14px;box-shadow:0 24px 60px rgba(0,0,0,0.25);animation:fadeIn 400ms ease both;'
            + (type === 'success'
                ? 'background:var(--ink-900,#0B1220);color:var(--gold-400,#D9BE86);border:1px solid var(--gold-500,#C9A96E);'
                : 'background:var(--ink-900,#0B1220);color:#fff;border:1px solid var(--error,#8C2E2E);');

        var icon = type === 'success' ? '&#10003;' : '&#10007;';
        var iconColor = type === 'success' ? 'var(--gold-500,#C9A96E)' : 'var(--error,#8C2E2E)';

        toast.innerHTML = '<span style="font-size:22px;color:' + iconColor + ';">' + icon + '</span>'
            + '<p style="margin:0;font-size:13px;line-height:1.6;">' + message + '</p>';

        document.body.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 400ms ease';
            setTimeout(function() { toast.remove(); }, 400);
        }, 6000);
    }

    // Functions
    function closePopup() {
        if (popupForm) {
            popupForm.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
    }

    function openLightbox(src) {
        lightboxImg.src = src;
        lightboxOverlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightboxOverlay.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function navigateLightbox(direction) {
        if (direction === 'next') {
            currentImageIndex = (currentImageIndex + 1) % galleryItems.length;
        } else {
            currentImageIndex = (currentImageIndex - 1 + galleryItems.length) % galleryItems.length;
        }
        
        lightboxImg.src = galleryItems[currentImageIndex].src;
    }

    function closeMobileMenu() {
        console.log('Closing mobile menu');
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
            // Add a slide out animation
            mobileMenu.style.animation = 'none'; // Reset animation first
            
            // Use a transition instead of direct transform for smoother animation
            setTimeout(() => {
                mobileMenu.style.transform = 'translateX(100%)';
                
                // Add a delay before hiding the menu completely
                setTimeout(() => {
                    if (!mobileMenu.classList.contains('active')) {
                        mobileMenu.style.display = 'none';
                    }
                }, 300);
            }, 10);
        }
        
        if (mobileMenuOverlay) {
            mobileMenuOverlay.style.display = 'none';
        }
        
        document.body.style.overflow = 'auto';
    }

    function createStickyHeader() {
        // Create sticky header element
        const header = document.createElement('header');
        header.className = 'sticky-header';
        header.innerHTML = `
            <div class="container mx-auto px-4 py-3">
                <div class="flex justify-between items-center">
                    <div class="text-2xl font-bold text-blue-700">Elan The Presidential</div>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#about" class="text-gray-700 hover:text-blue-700">About</a>
                        <a href="#highlights" class="text-gray-700 hover:text-blue-700">Highlights</a>
                        <a href="#floor-plans" class="text-gray-700 hover:text-blue-700">Floor Plan</a>
                        <a href="#gallery" class="text-gray-700 hover:text-blue-700">Gallery</a>
                        <a href="#location" class="text-gray-700 hover:text-blue-700">Location</a>
                        <a href="tel:+919412234688" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-phone-alt mr-2"></i>9412234688
                        </a>
                    </div>
                    <div class="md:hidden">
                        <button class="mobile-menu-toggle text-blue-700 focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.prepend(header);

        // Show sticky header on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                header.classList.add('visible');
            } else {
                header.classList.remove('visible');
            }
        });
    }

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                // Close mobile menu if open
                if (mobileMenu && mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
                
                // Scroll to target
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
