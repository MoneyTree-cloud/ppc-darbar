<!-- admin.html -->
<?php include('php/check_login.php');
$statusFromURL = $_GET['status'] ?? 'all';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Leads Record</title>
    <?php include('resource.php') ?>
  <!-- ======= Styles ====== -->
<!--<link rel="stylesheet" href="style.css">-->
<link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">

  <!-- AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php') ?>

    <!-- ========================= Main ==================== -->
    <div class="main">

      <!-- ======================= topbar ================== -->
      <?php include('components/topbar.php'); ?>

      <!-- =============== lead details form ================= -->
      <?php include('components/lead_details.php'); ?>

      <!-- ================ Order Details List ================= -->
      <div class="details">
        <div class="recentOrders">
          <div class="cardHeader">
            <h2>Deleted Leads</h2>
          </div>

          <table>
            <thead>
              <tr>
                <td style="background: transparent"></td>
                <td style="background: transparent"></td>
                <td style="display: none;"></td>
                <td style="text-align: left; background: transparent">
                  <select class="filter-select" id="domainSelect">
                    <option value="all">All Domains</option>
                    <?php include('php/fetch_domain.php') ?>
                  </select>
                </td>
                <td style="background: transparent"></td>
                <td style="background: transparent">
                  <select class="filter-select" id="statusSelect">
                    <option value="all">All Status</option>
                    <option value="New Lead">New Lead</option>
                    <option value="Interested">Interested</option>
                    <option value="Not_Interested">Not Interested</option>
                    <option value="Hot">Hot</option>
                    <option value="Very_Hot">Very Hot</option>
                    <option value="meeting_booked">Meeting booked</option>
                    <option value="meeting_done">Meeting Done</option>
                    <option value="Site_visited">Site Visited</option>
                    <option value="call_me_back">Call me Back</option>
                    <option value="Call_not_picked">Call not picked</option>
                    <option value="switch_off">Switch Off</option>
                    <option value="Broker">Broker</option>
                    <option value="Dumped">Dumped</option>
                    <option value="Closed">Sale Closed</option>
                  </select>
                </td>
              </tr>
              <tr>
              <!-- <td></td> -->
                <td>Name</td>
                <td>Mobile</td>
                <td style="display: none;">Email</td>
                <td>Domain</td>
                <td>Date & Time</td>
                <td>Status</td>
                <td>Action</td>
              </tr>
            </thead>

            <tbody id="leadsTableBody">
              <!-- Data will be loaded here from fetch_leads.php -->
            </tbody>
          </table>
          <div id="paginationContainer" class="pagination" style="margin-top:20px; text-align:center;"></div>

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

  setInterval(fetchLeads, 5000); // Refresh every 5 sec
});



function fetchLeads() {
  let selectedDomain = $('#domainSelect').val();
  let selectedStatus = $('#statusSelect').val();
  let searchQuery = $('#searchInput').val(); // Assuming your search input has id="searchInput"

  $.ajax({
    url: 'php/fetch_deleted_leads.php',
    method: 'GET',
    data: {
      domain: selectedDomain,
      status: selectedStatus,
      page: currentPage,
      search: searchQuery
    },
    dataType: 'json',
    success: function(response) {
      $('#leadsTableBody').html(response.table);
      $('#paginationContainer').html(response.pagination);
      updateCardNumbers(response.counts);

      // 🔥 Show "No records found" if no rows
      if (response.table.trim() === '') {
        $('#leadsTableBody').html(`
          <tr>
            <td colspan="6" style="text-align: center; padding: 20px; color: red;">
              No records found matching your criteria.
            </td>
          </tr>
        `);
      }
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


<script>
  let defaultStatus = '<?php echo $statusFromURL; ?>';
  console.log(defaultStatus);

  $(document).ready(function () {
    $('#statusSelect').val(defaultStatus); // Set default status
    $('#domainSelect').val('all');         // Reset domain filter
    fetchLeads();                          // Fetch leads with status filter
  });
  document.getElementById('statusSelect').value = defaultStatus;

</script>


  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>