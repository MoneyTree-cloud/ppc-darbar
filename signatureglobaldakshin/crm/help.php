<!-- admin.html -->
<?php include('php/check_login.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Help</title>

  <!-- ======= Styles ====== -->
<!--<link rel="stylesheet" href="style.css">-->
<link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php')?>

    <!-- ========================= Main ==================== -->
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
      
    </div>
  </div>

  <div id="notificationContainer"></div>

  <script>
  let currentPage = 1;
  let searchQuery = '';

$(document).ready(function() {
  fetchLeads(); // Initial load

  $('#domainSelect, #statusSelect').on('change', function() {
    currentPage = 1;
    fetchLeads();
  });

  $('#searchInput').on('input', function() {
    searchQuery = $(this).val();
    currentPage = 1;
    fetchLeads();
  });

  setInterval(fetchLeads, 5000); // Refresh data every 5 sec
});

function fetchLeads() {
    let selectedDomain = $('#domainSelect').val();
    let selectedStatus = $('#statusSelect').val();

     $.ajax({
    url: 'php/fetch_leads.php',
    method: 'GET',
    data: {
      domain: selectedDomain,
      status: selectedStatus,
      page: currentPage,
      search: searchQuery
    },
    dataType: 'json',
    success: function(response) {
      $('#leadsTableBody').html(response.table); //for table data fetchs
      $('#paginationContainer').html(response.pagination); //for Pagination
      updateCardNumbers(response.counts); //for status card numbers
    },
    error: function(xhr, status, error) {
      console.error('Error:', error);
    }
  });
}

function updateCardNumbers(counts) {
  updateCardNumber('.cardBox .card:nth-child(1) .numbers', counts.total);
  updateCardNumber('.cardBox .card:nth-child(2) .numbers', counts.interested);
  updateCardNumber('.cardBox .card:nth-child(3) .numbers', counts.not_interested);
  updateCardNumber('.cardBox .card:nth-child(4) .numbers', counts.hot);
  updateCardNumber('.cardBox .card:nth-child(5) .numbers', counts.very_hot);
  updateCardNumber('.cardBox .card:nth-child(6) .numbers', counts.dumped);
  updateCardNumber('.cardBox .card:nth-child(7) .numbers', counts.meeting_booked);
  updateCardNumber('.cardBox .card:nth-child(8) .numbers', counts.site_visited);
  updateCardNumber('.unread_notification', counts.unread);
  updateCardNumber('.cardUnread_notification', counts.unread);
}

function updateCardNumber(selector, newValue) {
  const element = document.querySelector(selector);
  if (element && element.textContent != newValue) {
    element.textContent = newValue;
  }
}

function changePage(page) {
  currentPage = page;
  fetchLeads();
}

</script>
    
    


  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>