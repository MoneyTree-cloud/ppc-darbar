<!-- admin.html -->
<?php include('php/check_login.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Team Members</title>
    <?php include('../resource.php'); ?>
  <!-- ======= Styles ====== -->
  <!--<link rel="stylesheet" href="style.css">-->
  <link rel="stylesheet" href="../style.css?v=<?= filemtime('../style.css'); ?>">
    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php') ?>

    <!-- ========================= Main ==================== -->
    <div class="main" style="display: flex; flex-direction: column; align-items: center; justify-content: flex-start;">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>

        <div class="tabName">
          <p class="pageName">Dashboard / <span>Team</span></p>
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

      <!-- ================ Team Member List ================= -->
      <div class="details">
        <div class="recentOrders">
          <div class="cardHeader">
            <h2>Team Members</h2>
            <!-- <a id="addMember" class="btn">Add Member</a> -->
          </div>

          <table>
            <thead>
              <tr>
                <td>Name</td>
                <td>Employ Id</td>
                <td>Phone No.</td>
                <td>Email</td>
                <td>Rights</td>
                <!-- <td>Action</td> -->
              </tr>
            </thead>

            <tbody id="subTeamTableBody">
              <!-- Fetched rows will be injected here -->
            </tbody>



          </table>
        </div>
      </div>

    </div>
  </div>

  <div id="notificationContainer"></div>


  <script>
    $(document).ready(function() {
      loadTeamMembers(); // Initial fetch
      setInterval(loadTeamMembers, 5000); // Optional auto-refresh

      function loadTeamMembers() {
        $.ajax({
          url: 'php/fetch_team.php',
          method: 'GET',
          success: function(data) {
            $('#subTeamTableBody').html(data);
          },
          error: function() {
            $('#subTeamTableBody').html('<tr><td colspan="6">Failed to load team members</td></tr>');
          }
        });
      }
    });
  </script>

  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>