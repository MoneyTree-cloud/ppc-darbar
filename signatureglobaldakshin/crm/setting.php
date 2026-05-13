 <!-- admin.html -->
<?php include('php/check_login.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Setting (Change Password)</title>
  <?php include('resource.php'); ?>

  <!-- ======= Styles ====== -->
<!--<link rel="stylesheet" href="style.css">-->
<link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php')?>

    <!-- ========================= Main ==================== -->
    <div class="main">


      <?php include('php/admin_details.php'); ?>

  <div class="topbar">
    <div class="toggle">
      <ion-icon name="menu-outline"></ion-icon>
    </div>

    <div class="tabName">
      <p class="pageName">Dashboard / <span>Setting</span></p>
    </div>

    <!-- <div class="search" id="search_bar">
      <label>
        <input type="text" id="searchInput" placeholder="Search here">
        <ion-icon name="search-outline"></ion-icon>
      </label>
    </div> -->


    <div class="user">
      <img src="assets/imgs/admin/<?php echo $admin_profile; ?>" onclick="openPopup('<img src=\'assets/imgs/admin/<?php echo $admin_profile; ?>\' alt=\'Image\' /><p><?php echo $admin_name; ?></p>')">
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

  <style>
    :root {
        --primary-green: rgba(0, 88, 79, 1); --accent-gold: #D4AF37; --light-background: #F0FDF4;
        --dark-text: #222222; --light-text: #555555; --success-bg: #D1F2EB;
        --success-text: #0E6655; --error-bg: #FADBD8; --error-text: #78281F;
    }
    .file-input {width: 100%; border: 2px dashed var(--accent-gold); border-radius: 8px; padding: 15px; cursor: pointer; background-color: #FFFDF5; transition: background-color 0.3s; }
    .file-input:hover { background-color: #FEF9E7; }
    .file-input input[type="file"] { display: none; }
    .file-input label { color: var(--primary-green); font-weight: bold; }
    @media (max-width: 900px){
      
      .upper_Container {
        flex-direction: column-reverse;
        margin-bottom: 60px;
      }
    }
  </style>
    

      <div class="upper_Container" style="display: flex; align-items: center; justify-content: center; margin-top: 30px; gap: 40px;">
                <div class="form-container" style="">
                    <h2>Update Your Profile</h2>
                    <form action="php/change_password.php" method="post" enctype="multipart/form-data" style="flex-direction: column;">
                        
                        
                        
                        <div class="form-group">
                            <input type="password" id="o_password" name="old-password" placeholder="Old Password">
                            <label for="old-password">Old Password</label>
                        </div>
                        <div class="form-group">
                            <input type="password" id="n_password" name="new-password" placeholder="New password">
                            <label for="new-password">New Password</label>
                        </div>
                        <div class="form-group">
                            <input type="password" id="cn_password" name="c-new-password" placeholder="Confirm New Password">
                            <label for="c-new-password">Confirm New Password</label>
                        </div>
                        <div class="file-input">
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/gif">
                            <label for="profile_picture" id="file-label">Update Profile Picture</label>
                        </div>
                        <button type="submit" class="btn">Update Profile</button>
                    </form>
                </div>
           

            <div class="details" style="display: flex; align-items: center; justify-content: center; max-width: 500px; border: 2px solid #004d40; border-radius: 10px;">
                <div class="form_details" style="padding: 20px; background: #ffffff; border-radius: 10px; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <h2 style="color: #004d40; font-size: 24px; margin-bottom: 15px;">Update Your Details</h2>
                    <h3 style="color: #163b6e; font-size: 18px; margin-bottom: 20px;">Update your profile picture or change your password.</h3>
                    
                    <ul style="list-style-type: disc; padding-left: 20px; font-size: 16px; color: #333; line-height: 1.8;">
                        <li>1. <strong>Update Profile Picture:</strong> Choose a new image file (JPEG, PNG, GIF) to upload.</li>
                        <li>2. <strong>Change Password:</strong> To change your password, you must fill in all three password fields.</li>
                        <li>3. If you only want to update your picture, you can leave the password fields blank.</li>
                    </ul>
                </div>
            </div>
        </div>
 </div>
      

    <div id="notificationContainer"></div>
    
    <script>
      document.getElementById('profile_picture').onchange = function () {
        document.getElementById('file-label').textContent = this.files[0].name;
    };
    </script>

  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>