<?php 
include('../php/check_login.php');
include('../php/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Lead Generator</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <?php include('../resource.php'); ?>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
</head>
<body>

    <button class="btn" onclick="openPopup()">Show Form</button>
    
    <div id="popupForm" class="overlay show">
    <div class="popup">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <div class="illustration">
        <h2>We Promise</h2>
        <div class="illustrate-item">
          <img src="assets/image/Call Now.svg" width=60 height=60 alt="customer-service">
          <p>Instant Call Now</p>
        </div>
        <div class="illustrate-item">
          <img src="assets/image/Site Visit.svg" width=60 height=60 alt="vehicle">
          <p>Book Site Visit</p>
        </div>
        <div class="illustrate-item">
          <img src="assets/image/money.svg" width=60 height=60 alt="Price">
          <p>Unmatched Price</p>
        </div>
      </div>
      <div class="form_container">
        <h2 class="logo">LOGO</h2>
        <!-- <img src="assets/image/logo-1.png" alt="Logo" class="logo" width="150" height="60"> -->
         <h3>Register Here And Avail <span class="highlight">The Best Offers!!</span></h3>
        
        <form id="registrationForm" action="php/submit.php" method="POST">
          <div class="form-group">
            <input type="text" name="name" id="nameInput" required>
            <label for="nameInput">Name</label>
          </div>
           <div class="form-group">
            <input type="email" name="email" id="emailInput" >
            <label for="emailInput">E-Mail Address</label>
          </div>
          
          <div class="form-group">
            <input type="tel" name="mobile" id="mobileInput" pattern="[0-9]{10}" maxlength="10" required />
            <label for="mobileInput">Mobile No</label>
          </div>
          
          <?php


$sql = "SELECT id, domain_name, project_name FROM domains";
$result = $conn->query($sql);

$domainProjectMap = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $domain = $row["domain_name"];
        $project = $row["project_name"];
        $domainProjectMap[$domain] = $project;
    }
}
$conn->close();
?>


         <div class="form-group">
    <label for="domainSelect">Select Domain</label>
    <select name="domain" id="domainSelect" required>
        <option value="">--Select a Domain--</option>
        <?php
        foreach ($domainProjectMap as $domain => $project) {
            echo "<option value='$domain' data-project='$project'>$domain</option>";
        }
        ?>
    </select>
  </div>

  <!-- Hidden Project Field -->
  <input type="hidden" name="projectName" id="projectHidden">

          <div class="form-group">
            <input type="datetime-local" name="date_time" id="datetimeInput" required>
            <label for="datetimeInput">Select Date and Time</label>
          </div>
          
          <input type="text" name="website" style="display:none">
  
          <label class="consent">
            <input class="consent-check" name="consent" type="checkbox" required checked>
            <p>I give my consent for the <a>privacy policy</a> to apply to the processing of the provided data. I give authority to the website owner and its representatives permission to contact me via phone, text, email, or whatsapp with its offer and products. This agreement takes precedenceover any DNC/NDNC registration.</p>
          </label>
  
          <button class="gradient-btn" id="submitBtn" type="submit">Pre-Register Now</button>
        </form>
      
    </div>
    </div>
  </div>
  <div id="notificationContainer"></div>
<script>
document.getElementById('domainSelect').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    let project = selectedOption.getAttribute('data-project');
    document.getElementById('projectHidden').value = project;
});
</script>

  <!-- scripts -->
  <script src="script.js?v=<?= filemtime('script.js'); ?>"></script>
</body>
</html>