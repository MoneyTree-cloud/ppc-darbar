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
        notification.classList.add("slide-out");
        // Wait for the animation to finish (0.4s), then remove
        setTimeout(() => {
            notification.remove();
        }, 400);
    }, 5000);
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    const message = urlParams.get('message');

    if (type && message) {
        // Show notification from URL parameters (e.g., for success/error messages from the server)
        notificationMessage(type, decodeURIComponent(message));

        // After 5 seconds, remove query params without changing page
        setTimeout(function() {
            const baseUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, baseUrl);
        }, 5000);
    }

    // Find the form by its ID
    const eventForm = document.getElementById("eventForm");

    // Check if the form exists before adding a listener
    if (eventForm) {
        eventForm.addEventListener("submit", function(e) {
            // This will now correctly trigger when the form is submitted
            notificationMessage("processiong", "Your Feedback is getting Submitted, Please Wait for a While.");

            // Find the submit button within the form
            const submitButton = eventForm.querySelector('.submit-btn');
            
            // Disable the button and change its text to prevent multiple clicks
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';
            }
        });
    }
});
