
<?php include('php/admin_details.php'); ?>

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


