<!-- admin.html -->
<?php include('php/check_login.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Dashboard | Setting (Change Password)</title>

  <!-- ======= Styles ====== -->
  <!--<link rel="stylesheet" href="style.css">-->
  <link rel="stylesheet" href="../style.css?v=<?= filemtime('../style.css'); ?>">
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php') ?>

    <!-- ========================= Main ==================== -->
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>

        <div class="tabName">
          <p class="pageName">Dashboard / <span>Setting</span></p>
        </div>

        <!-- <div class="search">
          <label>
            <input type="text" placeholder="Search here">
            <ion-icon name="search-outline"></ion-icon>
          </label>
        </div> -->

        <div class="user">
          <img src="../assets/imgs/default_profile.png" onclick="openPopup('<img src=\'../assets/imgs/default_profile.png\' alt=\'Image\' /><p><?php echo $username; ?></p>')">
        </div>
        <!-- Reusable Popup -->
        <div class="popup-overlay" id="reusablePopup">
          <div class="popup-content">
            <button class="popup-close" onclick="closePopup()">&times;</button>
            <div id="popup-body"></div>
            <div id="popup-actions" class="popup-actions"></div>
          </div>
        </div>
      </div>


      <div class="upper_Container" style="display: flex; align-items: center; justify-content: center;">

        <div class="form-container">
          <h2>Change Your Password</h2>
          <form action="php/change_password.php" method="post" style="flex-direction: column;">
            <div class="form-group">
              <input type="text" id="o_password" name="old-password" placeholder="Old Password" required>
              <label for="old-password">Old Password</label>
            </div>
            <div class="form-group">
              <input type="password" id="n_password" name="new-password" placeholder="New password" required>
              <label for="new-password">New Password</label>
            </div>
            <div class="form-group">
              <input type="password" id="cn_password" name="c-new-password" placeholder="Confirm New Password" required>
              <label for="c-new-password">Confirm New Password</label>
            </div>

            <button class="btn">Submit</button>
          </form>
        </div>

      </div>
      <div class="details">
        <div class="form_details" style="padding: 20px; background: #ffffff; border-radius: 10px; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
          <h2 style="color: #004d40; font-size: 24px; margin-bottom: 15px;">Change Password</h2>
          <h3 style="color: #163b6e; font-size: 18px; margin-bottom: 20px;">To enhance the security of your account, please enter your current password and set a new one.</h3>

          <ul style="list-style-type: disc; padding-left: 20px; font-size: 16px; color: #333; line-height: 1.8;">
            <li><strong>Old Password:</strong> Enter your current password.</li>
            <li><strong>New Password:</strong> Choose a strong new password.</li>
            <li><strong>Confirm New Password:</strong> Re-enter the new password to confirm.</li>
          </ul>
        </div>
      </div>

    </div>


    <div id="notificationContainer"></div>

    <!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>