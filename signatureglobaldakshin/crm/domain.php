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

<style>
  .card-box-container .card {
  width: 100%;
  max-width: 300px;
  padding: 10px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 2px solid var(--primary-color);
  border-radius: 10px;
  overflow: hidden;
}

.card-box-container .card img {
  width: 100%;
  aspect-ratio: 12/7;
  object-fit: cover;
  border-radius: 6px;
}

/* Overlay */
.card-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  opacity: 0;
  transition: 0.3s ease;
}

.card:hover .card-overlay {
  opacity: 1;
}

/* Buttons */
.card-overlay .btn {
  padding: 8px 16px;
  border-radius: 6px;
  color: #fff;
  height: 40px;
  text-decoration: none;
  font-size: 14px;
}

.card-overlay .edit {
  background: #28a745;
}

.card-overlay .delete {
  background: #dc3545;
}

.card-box-container .card-overlay .card a {
  margin-top: 15px;
  color: white;
  font-size: 18px;
  text-decoration: none;
}

.card-box-container .card a ion-icon{
  color: white;
}

.domain-index{
  color: white;
  margin-bottom: 10px;
  font-size: 16px;
}

</style>

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
          <img src="assets/imgs/admin/admin_1_1770206041.png" onclick="openPopup('<img src=\'assets/imgs/admin/admin_1_1770206041.png\' alt=\'Image\' />')" alt="">
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

      


      <div class="cardHeader" style="display: flex; justify-content: space-between; padding: 0 20px; align-items: center;">
        <h1 style="text-align: center;">Active Domains</h1>
        <td style="background: transparent; align-content: flex-end;">
              <div>
              <!-- <div class="dropdown">
                    <button type="button" class="btn" onclick="toggleDropdown('teamExportDropdown')">Leads ▾</button>
                    <div id="teamExportDropdown" class="dropdown-content">
                        <a href="uploaded_leads.php">Uploaded Leads</a>
                        <a href="number_leads.php">Raw Leads</a>
                        <a href="deleted_leads.php">Deleted Leads</a>
                        <a href="ip_captured.php">IP Captured</a>
                    </div>
                </div> -->
            
              <button class="filter-select" onclick="openDomainForm()" style="padding: 8px; background-color: #28a745; color: white;">
                <ion-icon name="download-outline"></ion-icon> Add Domain
              </button>
              </div>
            </td>
      </div>
      <div class="card-box-container">

<?php

// Get max index_no
$maxSql = "SELECT MAX(index_no) AS last_index FROM domains";
$maxResult = mysqli_query($conn, $maxSql);
$maxRow = mysqli_fetch_assoc($maxResult);
$last_index = $maxRow['last_index'];


$sql = "SELECT * 
        FROM domains 
        WHERE index_no IS NOT NULL AND index_no != 0
        ORDER BY index_no ASC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $domain = $row['domain_name'];
    $json = htmlspecialchars(json_encode([
            "id" => $row["id"],
            "index_no" => $row["index_no"],
            "project_name" => $row["project_name"],
            "domain_name" => $row["domain_name"],
            "active_status" => $row["active_status"],
            "date_time" => $row["date_time"],
            "updated_on" => $row["updated_on"],
            "max_index" => $maxRow['last_index']
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
?>
    <div class="card">
        <img src="https://<?php echo $domain; ?>/assets/preview.png" alt="site-preview">

        <div class="card-overlay">
            <a href="#" class="btn edit" onclick="openDomainDetails(<?php echo $json; ?>)"><ion-icon name="create"></ion-icon></a>
            <a href="php/delete/delete-domain.php?domain=<?php echo $domain; ?>" 
               class="btn delete"
               onclick="return confirm('Are you sure you want to delete this domain?')">
               <ion-icon name="trash"></ion-icon>
            </a>
        </div>

        <a href="https://<?php echo $domain; ?>/" target="_blank">
            <?php echo $domain; ?>
        </a>
    </div>
<?php
  }
} else {
  echo "No domains found.";
}
?>

</div>

      
    </div>
  </div>

<?php include('components/domain-details.php')?>

  <div id="notificationContainer"></div>

  <script>

    function openDomainForm(){
      document.getElementById('overlay').style.display = 'flex';
    }

    function openDomainDetails(row) {
    const overlay = document.getElementById("overlay");
    
    document.getElementById("domainId").value = row.id;
    document.getElementById("domain_name").value = row.domain_name;
    document.getElementById("project_name").value = row.project_name;
    document.getElementById("index_no").value = row.index_no;
    document.getElementById("datetimeInput").value = row.date_time;
    document.getElementById("lastUpdatedInput").value = row.updated_on;
    document.getElementById("statusInput").value = row.active_status;    
    document.getElementById("domainIndex").textContent = row.max_index;
    
    overlay.style.display = 'flex';
  }

    
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