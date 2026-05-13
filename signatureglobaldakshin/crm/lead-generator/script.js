// --------------- Function to show notification messages ---------------------

function notificationMessage(type, messageText) {
  const notificationContainer = document.getElementById("notificationContainer");

  // Create the notification element
  const notification = document.createElement("div");
  notification.className = `notification ${type}`; // Add class for styling

  // Add the message
  const message = document.createElement("div");
  message.className = "message";
  message.textContent = messageText;

  // Add a close button
  const closeBtn = document.createElement("button");
  closeBtn.className = "close-btn";
  closeBtn.innerHTML = "&times;";
  closeBtn.addEventListener("click", () => {
      notification.remove();
  });

  // Add the progress bar
  const progressBar = document.createElement("div");
  progressBar.className = "progress-bar";

  // Append elements to the notification
  notification.appendChild(message);
  notification.appendChild(closeBtn);
  notification.appendChild(progressBar);

  // Append the notification to the container
  notificationContainer.appendChild(notification);

  // Remove the notification after 5 seconds
  setTimeout(() => {
      notification.remove();
  }, 5000);
}


const toggleBtn = document.getElementById('toggleFormBtn');


// Form submission - Traditional POST for both forms
document.addEventListener("DOMContentLoaded", function() {
    // Popup form submission
    const popupForm = document.getElementById("registrationForm");
    if (popupForm) {
        popupForm.addEventListener("submit", function(e) {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="margin-right:8px;"></i> Processing...';
            }
        });
    }

});

document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  const type = urlParams.get('type');
  const message = urlParams.get('message');

  if (type && message) {
      // Show notification
      notificationMessage(type, decodeURIComponent(message));

      // After 5 seconds, remove query params without changing page
      setTimeout(function() {
          const baseUrl = window.location.origin + window.location.pathname;
          window.history.replaceState({}, document.title, baseUrl);
      }, 5000);
  }
});

  function openPopup() {
    const popup = document.getElementById("popupForm");
    popup.style.display = "flex";
    setTimeout(() => {
      popup.classList.add("show");
    }, 10);
    // closeLightboxPopup()
    document.body.style.overflow = "hidden";
    if (typeof leadForm !== "undefined") {
      leadForm.classList.add("hidden");
    }
  }
  
  function closePopup() {
    const popup = document.getElementById("popupForm");
    popup.classList.remove("show");
    setTimeout(() => {
      popup.style.display = "none";
    }, 400); // match transition
    document.body.style.overflow = "auto";
  }

  document.addEventListener("click", function (e) {
    const popup = document.querySelector(".popup");
    const overlay = document.getElementById("popupForm");
    if (overlay.classList.contains("show") && !popup.contains(e.target)) {
      closePopup();
    }
  });