<!-- admin.html -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- ======= Styles ====== -->
  <link rel="stylesheet" href="../../style.css">
</head>

<body>

  <div class="topbar">
    <div class="toggle">
      <ion-icon name="menu-outline"></ion-icon>
    </div>

    <!-- <div class="tabName">
      <p class="pageName">Dashboard / <span>Overview</span></p>
    </div> -->

    <div class="search">
      <label>
        <input type="text" id="searchInput" placeholder="Search here">
        <ion-icon name="search-outline"></ion-icon>
      </label>
    </div>


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


 
  <!-- =========== Scripts =========  -->
  <!-- <script src="../main.js"></script> -->

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>