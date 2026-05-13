document.addEventListener("DOMContentLoaded", function () {
	// Initialize AOS
	AOS.init({
		// Disable AOS on mobile devices
		disable: function() {
			return window.innerWidth < 768;
		},
		duration: 1000,
		once: true,
		offset: 100, // Note: 'disable' option added above
	});

	// Mobile Menu Toggle
	const mobileMenuBtn = document.querySelector(".mobile-menu");
	const navLinks = document.querySelector(".nav-links");

	mobileMenuBtn.addEventListener("click", () => {
		navLinks.classList.toggle("active");
	});

	// Initialize Map
	if (document.getElementById("location-map")) {
		const map = L.map("location-map").setView([28.4744, 77.504], 13);

		L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			attribution: " OpenStreetMap contributors",
		}).addTo(map);

		// Lazy load images
		const images = document.querySelectorAll("img[data-src]");

		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const img = entry.target;
					img.src = img.dataset.src;
					img.removeAttribute("data-src");
					observer.unobserve(img);
				}
			});
		});

		images.forEach((img) => observer.observe(img));

		// Add markers for key locations
		const locations = [
			{
				name: "SOBHA Sector 36",
				coords: [28.4744, 77.504],
				description: "SOBHA Sector 36, Greater Noida",
			},
			{
				name: "Noida Expressway",
				coords: [28.4744, 77.514],
				description: "5 mins from Noida Expressway",
			},
			{
				name: "Delhi NCR",
				coords: [28.4844, 77.504],
				description: "30 mins from Delhi NCR",
			},
		];

		locations.forEach((location) => {
			L.marker(location.coords)
				.bindPopup(`<b>${location.name}</b><br>${location.description}`)
				.addTo(map);
		});
	}

	// Form submission handling
	const contactForm = document.querySelector(".contact-form");
	if (contactForm) {
		contactForm.addEventListener("submit", async function (e) {
			e.preventDefault();

			// Get form data
			const formData = new FormData(this);

			// Show loading state
			const submitButton = this.querySelector('button[type="submit"]');
			const originalButtonText = submitButton.textContent;
			submitButton.textContent = "Sending...";
			submitButton.disabled = true;

			// Send form data
			try {
				const response = await fetch("process.php", {
					method: "POST",
					body: formData,
				});

				const data = await response.json();

				if (data.success) {
					const messageDiv = document.createElement("div");
					messageDiv.className = "form-message success";
					messageDiv.textContent =
						"Thank you for your interest! We will contact you shortly.";

					// Remove any existing message
					const existingMessage = contactForm.querySelector(".form-message");
					if (existingMessage) {
						existingMessage.remove();
					}

					contactForm.insertBefore(messageDiv, submitButton);

					// Reset form if successful
					contactForm.reset();
				} else {
					const messageDiv = document.createElement("div");
					messageDiv.className = "form-message error";
					messageDiv.textContent =
						data.message || "Something went wrong. Please try again.";
					contactForm.insertBefore(messageDiv, submitButton);
				}
			} catch (error) {
				console.error("Error:", error);
				const messageDiv = document.createElement("div");
				messageDiv.className = "form-message error";
				messageDiv.textContent = "Network error. Please try again.";
				contactForm.insertBefore(messageDiv, submitButton);
			} finally {
				// Reset button state
				submitButton.textContent = originalButtonText;
				submitButton.disabled = false;
			}
		});
	}

	// Smooth scroll for navigation links
	document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
		anchor.addEventListener("click", function (e) {
			e.preventDefault();
			const target = document.querySelector(this.getAttribute("href"));
			if (target) {
				target.scrollIntoView({
					behavior: "smooth",
					block: "start",
				});
				// Close mobile menu if open
				navLinks.classList.remove("active");
			}
		});
	});

	// Add scroll-based header styling
	const header = document.querySelector(".header");
	if (header) {
		let lastScroll = 0;
		window.addEventListener("scroll", () => {
			const currentScroll = window.pageYOffset;

			if (currentScroll <= 0) {
				header.classList.remove("scroll-up");
				return;
			}

			if (
				currentScroll > lastScroll &&
				!header.classList.contains("scroll-down")
			) {
				// Scroll Down
				header.classList.remove("scroll-up");
				header.classList.add("scroll-down");
			} else if (
				currentScroll < lastScroll &&
				header.classList.contains("scroll-down")
			) {
				// Scroll Up
				header.classList.remove("scroll-down");
				header.classList.add("scroll-up");
			}
			lastScroll = currentScroll;
		});
	}

	// Add animation to price tag
	const priceTag = document.querySelector(".price-tag");
	if (priceTag) {
		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						priceTag.classList.add("animate");
					}
				});
			},
			{ threshold: 0.5 }
		);
		observer.observe(priceTag);
	}
});
