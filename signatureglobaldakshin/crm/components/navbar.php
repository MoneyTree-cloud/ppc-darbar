
  <?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

  
  <div class="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
          
            <span class="title"><img src="assets/imgs/logo.png" alt=""></span>
          </a>
        </li>

        <li class="<?= ($currentPage == 'index.php') ? 'hovered' : '' ?>">
  <a href="index.php">
    <span class="icon"><ion-icon name="home"></ion-icon></span>
    <span class="title">Overview</span>
  </a>
</li>

<li class="<?= ($currentPage == 'leads.php') ? 'hovered' : '' ?>">
  <a href="leads.php">
    <span class="icon"><ion-icon name="mail-unread"></ion-icon></span>
    <span class="title">Leads</span>
    <span class="unread_notification">0</span>
  </a>
</li>

<!--<li class="<?= ($currentPage == 'team.php') ? 'hovered' : '' ?>">-->
<!--  <a href="team.php">-->
<!--    <span class="icon"><ion-icon name="person-add"></ion-icon></span>-->
<!--    <span class="title">Team members</span>-->
<!--  </a>-->
<!--</li>-->

<!--<li class="<?= ($currentPage == 'edit_kra_report.php') ? 'hovered' : '' ?>">-->
<!--  <a href="edit_kra_report.php">-->
<!--    <span class="icon"><ion-icon name="calculator"></ion-icon></span>-->
<!--    <span class="title">KRA's</span>-->
<!--  </a>-->
<!--</li>-->

<!--<li class="<?= ($currentPage == 'eod_report.php') ? 'hovered' : '' ?>">-->
<!--  <a href="eod_report.php">-->
<!--    <span class="icon"><ion-icon name="calendar-outline"></ion-icon></span>-->
<!--    <span class="title">EOD</span>-->
<!--  </a>-->
<!--</li>-->

<!--<li class="<?= ($currentPage == 'meeting_client.php') ? 'hovered' : '' ?>">-->
<!--  <a href="meeting_client.php">-->
<!--    <span class="icon"><ion-icon name="people"></ion-icon></span>-->
<!--    <span class="title">Meeting</span>-->
<!--  </a>-->
<!--</li>-->

<!--<li class="<?= ($currentPage == 'event_client.php') ? 'hovered' : '' ?>">-->
<!--  <a href="event_client.php">-->
<!--    <span class="icon"><ion-icon name="people"></ion-icon></span>-->
<!--    <span class="title">Event</span>-->
<!--  </a>-->
<!--</li>-->

<li class="<?= ($currentPage == 'domain.php') ? 'hovered' : '' ?>">
  <a href="domain.php">
    <span class="icon"><ion-icon name="logo-chrome"></ion-icon></span>
    <span class="title">Domains</span>
  </a>
</li>

<!--<li class="<?= ($currentPage == 'tasks.php') ? 'hovered' : '' ?>">-->
<!--  <a href="tasks.php">-->
<!--    <span class="icon"><ion-icon name="list"></ion-icon></span>-->
<!--    <span class="title">Todos</span>-->
<!--  </a>-->
<!--</li>-->

<li class="<?= ($currentPage == 'setting.php') ? 'hovered' : '' ?>">
  <a href="setting.php">
    <span class="icon"><ion-icon name="settings"></ion-icon></span>
    <span class="title">Settings</span>
  </a>
</li>




        <li>
          <a href="#" onclick="openPopup('<p>Are You Sure, You want to Logout?</p>', true)" class="active">
            <span class="icon">
              <ion-icon name="log-out"></ion-icon>
            </span>
            <span class="title">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>


    <!-- Add jQuery before your script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      $(document).ready(function() {
        fetchUnreadCount(); // Initial load
        setInterval(fetchUnreadCount, 5000); // Update every 5 seconds
      });

      function fetchUnreadCount() {
        $.ajax({
          url: '../php/fetch_leads.php', // Adjusted path
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.counts && response.counts.unread !== undefined) {
              updateCardNumber('.unread_notification', response.counts.unread);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching unread count:', error);
          }
        });
      }

      function updateCardNumber(selector, newValue) {
        const element = document.querySelector(selector);
        if (element && element.textContent != newValue) {
          element.textContent = newValue;
        }
      }
    </script>



    <!-- =========== Scripts =========  -->
    <!-- <script src="../main.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

