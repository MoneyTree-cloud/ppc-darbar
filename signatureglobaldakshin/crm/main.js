document.addEventListener("DOMContentLoaded", () => {
  // let list = document.querySelectorAll(".navigation li");

  // function activeLink() {
  //   list.forEach((item) => item.classList.remove("hovered"));
  //   this.classList.add("hovered");
  // }

  // list.forEach((item) => item.addEventListener("mouseover", activeLink));

  let toggle = document.querySelector(".toggle");
  let navigation = document.querySelector(".navigation");
  let main = document.querySelector(".main");
  let toggleIcon = toggle.querySelector("ion-icon"); // grab the icon inside toggle
  
  toggle.onclick = () => {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
  
    // Change icon based on navigation active
    if (navigation.classList.contains("active")) {
      toggleIcon.setAttribute("name", "close-outline"); // Show cross icon
    } else {
      toggleIcon.setAttribute("name", "menu-outline");  // Show menu icon
    }
  };
  

  // Popup functionality
  window.openPopup = function (contentHTML, showButtons = false) {
    const popup = document.getElementById("reusablePopup");
    const content = document.getElementById("popup-body");
    const actions = document.getElementById("popup-actions");

    content.innerHTML = contentHTML;

    actions.innerHTML = showButtons
      ? `<button class="popup-btn" onclick="handleYes()">Yes</button>
         <button class="popup-btn" onclick="closePopup()">No</button>`
      : "";

    popup.classList.add("active");
    document.body.style.overflow = "hidden";
  };

  window.closePopup = function () {
    const popup = document.getElementById("reusablePopup");
    popup.classList.remove("active");
    document.getElementById("popup-body").innerHTML = "";
    document.getElementById("popup-actions").innerHTML = "";
    document.body.style.overflow = "";
  };

  window.handleYes = function () {
    window.location.href = "php/logout.php";
    // alert("you Clicked Yes!")
    closePopup()
  };

  document.getElementById("reusablePopup").addEventListener("click", (e) => {
    if (e.target.id === "reusablePopup") closePopup();
  });
});

// Popup functionality
  window.openResetPopup = function (contentHTML, showButtons = false) {
    const popup = document.getElementById("reusablePopup");
    const content = document.getElementById("popup-body");
    const actions = document.getElementById("popup-actions");

    content.innerHTML = contentHTML;

    actions.innerHTML = showButtons
      ? `<button class="popup-btn" onclick="handleKraYes()">Yes</button>
         <button class="popup-btn" onclick="closePopup()">No</button>`
      : "";

    popup.classList.add("active");
    document.body.style.overflow = "hidden";
  };

  window.handleKraYes = function () {
    window.location.href = "php/reset_kra.php";
    // alert("you Clicked Yes!")
    closePopup()
  };


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
     notification.classList.add("slide-out");
        // Wait for the animation to finish (0.4s), then remove
        setTimeout(() => {
            notification.remove();
        }, 400);
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
      // Show notification
      notificationMessage(type, decodeURIComponent(message));

      // After 5 seconds, remove query params without changing page
      setTimeout(function() {
          const baseUrl = window.location.origin + window.location.pathname;
          window.history.replaceState({}, document.title, baseUrl);
      }, 5000);
  }
});


  function openLeadForm(row) {
    const overlay = document.getElementById("overlay");
    
    
    const id = row.getAttribute('data-id') || '';
    const name = row.getAttribute('data-name') || '';
    const email = row.getAttribute('data-email') || '';
    const mobile = row.getAttribute('data-mobile') || '';
    const domain = row.getAttribute('data-domain') || '';
    const remark = row.getAttribute('data-remark') || '';
    const datetime = row.getAttribute('data-datetime') || '';
    const updatetime = row.getAttribute('data-updatetime') || '';
    // const readStatus = row.getAttribute('data-read_status') || '';
    const status = row.getAttribute('data-status') || '';
    

    document.getElementById('clientId').value = id;
    document.getElementById('nameInput').value = name;
    document.getElementById('emailInput').value = email;
    document.getElementById('phoneInput').value = mobile;
    document.getElementById('remark').value = remark;
    document.getElementById('datetimeInput').value = datetime;
    document.getElementById('lastUpdatedInput').value = updatetime;
    document.getElementById('statusInput').value = status;
    document.getElementById('domainHeading').textContent = `Lead from ${domain}`;
    
    document.getElementById('overlay').style.display = 'flex';
  }
  
    document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('leadsTableBody');

    tableBody.addEventListener('click', function (event) {
        // ✅ If the clicked element is inside a delete button, skip
        if (event.target.closest('a.delete-lead')) {
            event.stopPropagation(); // Prevent triggering openLeadForm
            return;
        }

        const clickedRow = event.target.closest('tr');
        if (clickedRow) {
            openLeadForm(clickedRow);
            document.body.style.overflow = "hidden";
        }
    });
});
  
  // const overlay = document.getElementById("overlay");
  // Close overlay on outside click (optional)
  overlay.addEventListener("click", e => {
    if (e.target === overlay) {
      overlay.style.display = "none";
      document.body.style.overflow = "auto"
    }
  });


  function closeForm(){
      overlay.style.display = "none";
      document.body.style.overflow = "auto"
  }