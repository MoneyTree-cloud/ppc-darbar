<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Lead Details</title>
    <!-- <link rel="stylesheet" href="../style.css"> -->

    <script type='module' src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js'></script>
    <script nomodule src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js'></script>
</head>
<body>

<div class="overlay" id="overlay" style="display: none">
          <div class="form-container" style="max-width: 600px; width: 100%; flex-direction: column;">
            <h2>Lead Details</h2>
            <div class="close" onclick="closeForm()"><ion-icon name="close-outline"></ion-icon></div>
            <h3 id="domainHeading">Lead from Domain.in</h3>
            <form action="php/update_lead.php" method="post" class="lead_form">
              
              <input type="hidden" name="id" id="clientId" required />
              
              <div class="form-group">
                <input type="text" name="name" id="nameInput" required disabled/>
                <label for="nameInput">Client Name</label>
              </div>
              <div class="form-group">
                <input type="email" name="email" id="emailInput" required disabled/>
                <label for="emailInput">E-Mail Address</label>
              </div>
              <div class="form-group">
                <input type="number" name="mobile" id="phoneInput" required disabled/>
                <label for="emailInput">Contact Number</label>
              </div>
              <div class="form-group">
                <textarea name="remark" id="remark"></textarea>
                <label for="remark">Remark</label>
              </div>
              <div class="form-group">
                <input type="text" name="email" id="datetimeInput" required disabled/>
                <label for="emailInput">Date & Time</label>
              </div>
              <div class="form-group">
                <select class="filter-select" name="status" id="statusInput">
                  <!-- <option value="New Lead">New Lead</option> -->
                  <option value="closed">closed</option>
                  <option value="interested">interested</option>
                  <option value="not_interested">not_interested</option>
                  <option value="call_not_picked">call_not_picked</option>
                  <option value="broker">broker</option>
                  <option value="hot">hot</option>
                  <option value="very_hot">very_hot</option>
                  <option value="dumped">dumped</option>
                  <option value="meeting_booked">meeting_booked</option>
                  <option value="site_visited">site_visited</option>
                </select>
                <ion-icon name="chevron-down-outline"></ion-icon>
              </div>
              <div class="button">
                <label class="custom-checkbox">
                    <input type="checkbox" name="read_status" id="markUnreadCheckbox" />
                    <span class="checkbox-style"></span>
                    Mark as Unread
                  </label>

            
                <!-- <button class="btn" title="Mark As Unread"><ion-icon name="checkmark-circle-outline"></ion-icon></button> -->
                <button class="btn">Update</button>
            </div>
            </form>
          </div>
        </div>
    
</body>
</html>