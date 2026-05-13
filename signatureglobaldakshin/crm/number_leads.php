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
  <?php include('resource.php'); ?>
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
            <h2>All Leads</h2>
            <td style="background: transparent; align-content: flex-end;">
              <div>
              <div class="dropdown">
                    <button type="button" class="btn" onclick="toggleDropdown('teamExportDropdown')">Other Leads ▾</button>
                    <div id="teamExportDropdown" class="dropdown-content">
                        <a href="uploaded_leads.php">Uploaded Leads</a>
                        <a href="number_leads.php">Raw Leads</a>
                        <a href="deleted_leads.php">Deleted Leads</a>
                        <a href="ip_captured.php">IP Captured</a>
                        <a href="spam_leads.php">Junk Leads</a>
                    </div>
                </div>
            
              <button id="exportExcel" class="filter-select" style="padding: 8px; background-color: #28a745; color: white;">
                <ion-icon name="download-outline"></ion-icon> Export to Excel
              </button>
              </div>
            </td>
          </div>

          <table>
            <thead>
              <tr>
                <td style="background: transparent; align-content: flex-end;">
                  <button id="clearDates" class="filter-select" style="padding: 8px;">Clear Dates</button>
                </td>
                <td style="background: transparent"></td>

                <td style="text-align: left; background: transparent; align-content: flex-end;">
                  <select class="filter-select" id="domainSelect">
                    <option value="all">All Domains</option>
                    <?php include('php/fetch_domain.php') ?>
                  </select>
                </td>
                <td style="background: transparent; align-content: flex-end;">
                  <label for="fromDate">From: &nbsp;</label><input type="date" id="fromDate" class="filter-select">
                </td>
                <td style="background: transparent; align-content: flex-end;">
                  <label for="toDate">To: &nbsp;</label><input type="date" id="toDate" class="filter-select">
                </td>
                <td style="background: transparent; align-content: flex-end;">
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
                <td>S No.</td>
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
    // This variable gets the status from the URL via PHP.
    // It will be used once for the initial page load.
    let defaultStatus = '<?php echo $statusFromURL; ?>';

    // =================================================================
    // MAIN DOCUMENT READY FUNCTION
    // =================================================================
    $(document).ready(function() {
        // Initial load. The fetchLeads function will now handle the defaultStatus.
        fetchLeads();

        // --- EVENT LISTENERS FOR FILTERS ---
        // Listener for domain and date filters
        $('#domainSelect, #fromDate, #toDate').on('change', function() {
            currentPage = 1;
            fetchLeads();
        });

        // Specific listener for the status filter
        $('#statusSelect').on('change', function() {
            currentPage = 1;
            // Clear the initial URL status so it's not used again
            defaultStatus = '';
            const baseUrl = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, baseUrl); 
            fetchLeads();
        });

        $('#clearDates').on('click', function() {
            $('#fromDate').val('');
            $('#toDate').val('');
            currentPage = 1;
            fetchLeads();
        });

        $('#searchInput').on('input', function() {
            searchQuery = $(this).val();
            currentPage = 1;
            fetchLeads();
        });

        // --- AJAX FORM SUBMISSION FOR UPDATING LEADS ---
        $(document).on('submit', '.lead_form', function(e) {
            e.preventDefault(); // Prevent page reload
            var formData = $(this).serialize();

            $.ajax({
                url: 'php/update_number_lead.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        notificationMessage('success', response.message);
                        closeForm();
                        fetchLeads();
                    } else {
                        notificationMessage('error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    notificationMessage('error', 'An unexpected error occurred. Please try again.');
                }
            });
            document.getElementById('overlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        // --- EXPORT TO EXCEL ---
        $('#exportExcel').on('click', exportToExcel);

        // --- AUTO-REFRESH ---
        setInterval(fetchLeads, 5000);
    });

    // =================================================================
    // HELPER FUNCTIONS
    // =================================================================

    /**
     * Fetches leads from the server.
     * On the first run, it uses the status from the URL if available.
     */
    function fetchLeads() {
        // Check if a default status was passed from the URL and set it case-insensitively.
        // This logic runs only on the first call.
        if (defaultStatus && defaultStatus !== 'all' && defaultStatus !== '') {
            const statusSelect = $('#statusSelect');
            const defaultStatusLower = defaultStatus.toLowerCase();

            // Loop through each option in the dropdown
            statusSelect.find('option').each(function() {
                const option = $(this);
                const optionValueLower = option.val().toLowerCase();

                // If the lowercase values match, select this option
                if (optionValueLower === defaultStatusLower) {
                    statusSelect.val(option.val()); // Set the value using the original case from the <option>
                    return false; // Exit the .each() loop since we found a match
                }
            });
            
            // Clear the variable so subsequent calls (from setInterval or filters)
            // don't keep resetting the status dropdown.
            defaultStatus = '';
        }

        let selectedDomain = $('#domainSelect').val();
        let selectedStatus = $('#statusSelect').val(); // Reads the current state of the dropdown
        let fromDate = $('#fromDate').val();
        let toDate = $('#toDate').val();
        // searchQuery is a global variable

        $.ajax({
            url: 'php/fetch_number_leads.php',
            method: 'GET',
            data: {
                domain: selectedDomain,
                status: selectedStatus,
                page: currentPage,
                search: searchQuery,
                fromDate: fromDate,
                toDate: toDate
            },
            dataType: 'json',
            success: function(response) {
                if (response.table && response.table.trim() !== '') {
                    $('#leadsTableBody').html(response.table);
                } else {
                    $('#leadsTableBody').html(`
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                                No records found matching your criteria.
                            </td>
                        </tr>
                    `);
                }
                $('#paginationContainer').html(response.pagination);
                updateCardNumbers(response.counts);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching leads:', error);
                $('#leadsTableBody').html(`
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: red;">
                            Failed to load data. Please check the console for errors.
                        </td>
                    </tr>
                `);
            }
        });
    }

    /**
     * Updates the count numbers in the dashboard cards.
     */
    function updateCardNumbers(counts) {
        if (!counts) return;
        const mapping = {
            '.cardBox .card:nth-child(1) .numbers': counts.total,
            '.cardBox .card:nth-child(2) .numbers': counts.interested,
            '.cardBox .card:nth-child(3) .numbers': counts.not_interested,
            '.cardBox .card:nth-child(4) .numbers': counts.hot,
            '.cardBox .card:nth-child(5) .numbers': counts.very_hot,
            '.cardBox .card:nth-child(6) .numbers': counts.dumped,
            '.cardBox .card:nth-child(7) .numbers': counts.meeting_booked,
            '.cardBox .card:nth-child(8) .numbers': counts.site_visited,
            '.unread_notification': counts.unread,
            '.cardUnread_notification': counts.unread
        };

        for (const selector in mapping) {
            const element = document.querySelector(selector);
            const newValue = mapping[selector];
            if (element && element.textContent != newValue) {
                element.textContent = newValue;
            }
        }
    }

    /**
     * Changes the current page for pagination and re-fetches leads.
     */
    function changePage(page) {
        currentPage = page;
        fetchLeads();
    }

    /**
     * Creates and submits a hidden form to export data to Excel.
     */
    function exportToExcel() {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'php/export_leads.php';
        form.style.display = 'none';

        const params = {
            domain: $('#domainSelect').val(),
            status: $('#statusSelect').val(),
            search: $('#searchInput').val(),
            fromDate: $('#fromDate').val(),
            toDate: $('#toDate').val()
        };

        for (const key in params) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = params[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>


  <!-- scripts -->
  <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>