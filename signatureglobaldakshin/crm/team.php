<!-- admin.html -->
<?php include('php/check_login.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Team Members</title>

  <!-- ======= Styles ====== -->
  <!--<link rel="stylesheet" href="style.css">-->
  <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
  <?php include('resource.php'); ?>
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
          <img src="assets/imgs/customer01.jpg" onclick="openPopup('<img src=\'assets/imgs/customer01.jpg\' alt=\'Image\' />')" alt="">
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


      <div class="upper_container">
        
        <div class="form-container">
          <h2 id="addMemberTitle">Add Member</h2>
          <form action="php/save_team_member.php" method="post">
            <input type="hidden" id="id" name="id"> <!-- for update -->
            
            <div class="col">
              <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Name" required>
                <label for="name">Name</label>
              </div>
              <div class="form-group">
                <input type="text" id="employId" name="employId" placeholder="Employ Id" required>
                <label for="EmployId">Employ Id</label>
              </div>
            </div>
            
            <div class="col">
              <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <label for="email">Email</label>
              </div>
              <div class="form-group">
                <input type="tel" id="phone" name="phone" placeholder="Phone no." required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
                <label for="phone">Phone no.</label>
              </div>
            </div>
            
            <div class="col">
              <div class="form-group">
                <input type="text" id="team_name" name="team_name" placeholder="Team name">
                <label for="team_name">Team name</label>
              </div>
              <div class="form-group">
                <select id="rights" class="filter-select" style="min-width: 170px;" name="rights" required>
                  <option value="Read">Read</option>
                  <option value="Read/Write">Read/Write</option>
                </select>
                <ion-icon name="chevron-down-outline"></ion-icon>
              </div>
            </div>
              <button class="btn" id="add_member">Add</button>
          </form>
        </div>

        <div class="info_box">
          <h2>Remember!!</h2>
          <p><span class="highlighted_span">Note:</span> New member's Password will be the first name + @ + Employe Id,</p>
          <p>Like, if Your Name is <span class="highlighted_span">John Doe</span> and Your Employ Id is <span class="highlighted_span">1234</span> Then Your Password will be <span class="highlighted_span">John@1234</span>.</p>
        </div>
        
      </div>




      <!-- ================ Team Member List ================= -->
      <div class="details">
        <div class="recentOrders">
          <div class="cardHeader">
            <h2>Team Members</h2>
            <div>
              <!-- <a id="addMember" class="btn">Add Member</a> -->
              <button id="exportExcel" onclick="exportTeamToExcel()" class="btn">
                <ion-icon name="download-outline"></ion-icon> Export to Excel
              </button>
            </div>
          </div>

          <table>
            <thead>
              <tr>
                <td>Name</td>
                <td>Employ Id</td>
                <td>Phone No.</td>
                <td>Email</td>
                <td>Team</td>
                <td>Rights</td>
                <td>Action</td>
              </tr>
            </thead>

            <tbody id="teamTableBody">
              <!-- Fetched rows will be injected here -->
            </tbody>



          </table>
        </div>
      </div>

    </div>
  </div>

  <div id="notificationContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

  <script>
    $(document).ready(function() {
      loadTeamMembers(); // Initial fetch
      setInterval(loadTeamMembers, 5000); // Optional auto-refresh

      function loadTeamMembers() {
        $.ajax({
          url: 'php/fetch_team.php',
          method: 'GET',
          success: function(data) {
            $('#teamTableBody').html(data);
          },
          error: function() {
            $('#teamTableBody').html('<tr><td colspan="6">Failed to load team members</td></tr>');
          }
        });
      }
    });

    $(document).on('click', '.edit-member', function(e) {
      e.preventDefault();

      document.getElementById('addMemberTitle').innerText = "Update Details";
      document.getElementById('add_member').innerText = "Update";
      const id = $(this).data('id');
      const name = $(this).data('name');
      const employId = $(this).data('employid');
      const email = $(this).data('email');
      const contact = $(this).data('contact');
      const team_name = $(this).data('team_name');
      const rights = $(this).data('rights');

      // Fill form values
      $('#id').val(id);
      $('#name').val(name);
      $('#employId').val(employId);
      $('#email').val(email);
      $('#phone').val(contact);
      $('#team_name').val(team_name);
      $('#rights').val(rights);
      
        // 👇 Scroll to top
    $('html, body').animate({ scrollTop: 0 }, 'smooth'); 
    });

    document.getElementById('addMember').addEventListener('click', () => {
      document.getElementById('addMemberTitle').innerText = "Add Memeber"
      document.getElementById('id').value = "";
      document.getElementById('name').value = "";
      document.getElementById('employId').value = "";
      document.getElementById('email').value = "";
      document.getElementById('phone').value = "";
      document.getElementById('team_name').value = "";
      document.getElementById('rights').value = "Read"; // or set it to a default value
    });
    
    
    
    function exportTeamToExcel() {
      // Create a form dynamically
      let form = document.createElement('form');
      form.method = 'POST';
      form.action = 'php/export_team.php';

      // Append form to body and submit
      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);
    }

    // Add click handler for the export button
    $('#exportExcel').on('click', exportTeamToExcel);
  </script>

  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>