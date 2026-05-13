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

    // Create sticky header
    createStickyHeader();

    // Handle CTA button click for popup with animation
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (popupForm) {
                // Set form type based on button text
                const buttonText = this.textContent.trim();
                
                if (popupFormType) {
                    // Set the form type based on the button text
                    if (buttonText.includes('SITE VISIT')) {
                        popupFormType.value = 'site_visit';
                    } else if (buttonText.includes('BROCHURE')) {
                        popupFormType.value = 'brochure';
                    } else if (buttonText.includes('QUOTE')) {
                        popupFormType.value = 'price_quote';
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

            // AJAX submission
            e.preventDefault();
            var btn = form.querySelector('button[type="submit"]');
            var originalText = btn ? btn.innerHTML : '';
            if (btn) { btn.disabled = true; btn.innerHTML = 'Submitting...'; }

            fetch(form.action || 'process-form.php', {
                method: 'POST',
                body: new FormData(form),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.success) {
                    form.reset();
                    window.location.href = data.redirect || 'thank-you.php';
                } else {
                    alert(data.message || 'An error occurred.');
                }
            })
            .catch(function() { alert('An unexpected error occurred. Please try again.'); })
            .finally(function() { if (btn) { btn.disabled = false; btn.innerHTML = originalText; } });
        });
    });

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
                    <div class="text-2xl font-bold text-blue-700">Paras Meerut Plots</div>
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="#about" class="text-gray-700 hover:text-blue-700">About</a>
                        <a href="#highlights" class="text-gray-700 hover:text-blue-700">Highlights</a>
                        <a href="#site-plan" class="text-gray-700 hover:text-blue-700">Site Plan</a>
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
