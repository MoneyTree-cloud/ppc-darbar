let saleIndex = 1;

function updateSaleNumbers() {
  const sales = document.querySelectorAll('.sale');
  sales.forEach((sale, i) => {
    const label = sale.querySelector('.sale-number');
    if (label) label.textContent = `${i + 1}.`;
  });
}

// Add More Sale Handler
document.getElementById('addSaleBtn').addEventListener('click', () => {
  const wrapper = document.getElementById('salesWrapper');

  // Collapse existing sales
  wrapper.querySelectorAll('.sale').forEach(s => {
    s.classList.remove('active-sale');
    const details = s.querySelector('.details');
    const clientInput = s.querySelector('.client-name');
    if (details) details.style.display = 'none';
    if (clientInput) clientInput.classList.add('compact-client');
    s.querySelectorAll('input[type="radio"]').forEach(r => r.required = false);
  });

  // New Sale block
  const newSale = document.createElement('div');
  newSale.className = 'sale active-sale';

  newSale.innerHTML = `
    <div class="sale-header">
      <span class="sale-number">${saleIndex + 1}.</span>
      <div class="input-group">
            <label>Client Name</label>
            <input type="text" name="client_name[]" class="client-name">
            <i class="fa-solid fa-pen-to-square"></i>
      </div>
            <span class="remove-sale" title="Remove">❌</span>
    </div>
    <div class="details">
    <div class="input-group">
            <label>Mobile No.</label>
            <input type="tel" name="mobile[]" pattern="[0-9]{10}" maxlength="10" minlength="10" required placeholder="Enter 10 digit mobile number">
      </div>
        <div class="input-group">
            <label>Project Name</label>
            <input type="text" name="project[]">
        </div>
        <div class="input-group">
            <label>Unit Number</label>
            <input type="text" name="unit[]">
        </div>
        <div class="input-group">
            <label>Unit Size</label>
            <input type="text" name="size[]">
        </div>
        <div class="input-group">
            <label>Total Cost</label>
            <input type="text" name="total_cost[]">
        </div>
            <label>Inventory Hold on SAP:
          <input type="radio" name="inventory_status[0]" value="yes" style="margin-left: 30px;"> <span>Yes</span>
          <input type="radio" name="inventory_status[0]" value="no" style="margin-left: 30px;"> <span>No</span>
        </label>
    </div>
  `;
  wrapper.appendChild(newSale);
  saleIndex++;
  updateSaleNumbers();
});

// Remove sale column
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('remove-sale')) {
    e.target.closest('.sale').remove();
    updateSaleNumbers();
  }
});

// Accordion click behavior
document.addEventListener('click', (e) => {
  const sales = document.querySelectorAll('.sale');

  sales.forEach((sale) => {
    const clientInput = sale.querySelector('.client-name');
    const details = sale.querySelector('.details');
    const radios = sale.querySelectorAll('input[type="radio"]');

    if (!clientInput || !details) return;

    if (sale.contains(e.target)) {
      sale.classList.add('active-sale');
      clientInput.classList.remove('compact-client');
      details.style.display = 'block';
      radios.forEach(r => r.required = true);
    } else {
      sale.classList.remove('active-sale');
      clientInput.classList.add('compact-client');
      details.style.display = 'none';
      radios.forEach(r => r.required = false);
    }
  });
});


const today = new Date();
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  document.getElementById('todayDate').textContent = today.toLocaleDateString('en-IN', options);



// notification
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



document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("form");
  let formSubmitted = false;

  forms.forEach(function (form) {
    form.addEventListener("submit", function (e) {
      if (formSubmitted) {
        e.preventDefault();
        return false;
      }

      const inputs = form.querySelectorAll("input:not([type='submit']):not([type='button'])");
      let isValid = true;
      let missingFields = [];

      inputs.forEach((input) => {
        if (!input.value.trim()) {
          isValid = false;
          const label = input.closest(".input-group")?.querySelector("label")?.innerText || input.name;
          if (!missingFields.includes(label)) {
            missingFields.push(label);
          }
        }
      });

      // Validate inventory_status radio groups
      const inventoryGroups = form.querySelectorAll('[name^="inventory_status["]');
      const groupNames = new Set();
      inventoryGroups.forEach((input) => groupNames.add(input.name));
      for (const name of groupNames) {
        const radios = form.querySelectorAll(`[name="${name}"]`);
        const oneChecked = Array.from(radios).some(r => r.checked);
        if (!oneChecked) {
          isValid = false;
          if (!missingFields.includes("Inventory Hold")) {
            missingFields.push("Inventory Hold");
          }
        }
      }

     if (!isValid) {
        e.preventDefault();

        // Trim to max 3 fields and append '...' if more
        let displayFields = missingFields.slice(0, 3);
        if (missingFields.length > 3) {
          displayFields.push("..");
        }
    
        const message = `Please fill ${displayFields.join(", ")}`;
        notificationMessage("error", message);
        return;
    }


      // Show processing notification
      notificationMessage("processing", "Your request is processing, please wait...");

      const submitInput = form.querySelector('input[type="submit"]');
      if (submitInput) {
        submitInput.disabled = true;
        submitInput.style.opacity = '0.6';
        submitInput.style.cursor = 'not-allowed';
        submitInput.value = "Processing...";
      }

      formSubmitted = true;
    });
  });
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