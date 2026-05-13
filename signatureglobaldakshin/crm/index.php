<!-- admin.html -->
<?php include('php/check_login.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Home</title>

  <!-- ======= Styles ====== -->
  <!--<link rel="stylesheet" href="style.css">-->
  <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">

  <!-- AJAX -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- pie chart -->
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php include('resource.php'); ?>
</head>

<body>
  <!-- =============== Navigation ================ -->
  <div class="container">
    <?php include('components/navbar.php') ?>

    <!-- ========================= Main ==================== -->
    <div class="main">

      <!-- ======================= topbar ================== -->
      <?php include('components/topbar.php'); ?>

      <!-- ======================= Cards ================== -->
      <?php include('components/main_cards.php'); ?>

      <!-- =============== lead details form ================= -->
      <?php include('components/lead_details.php'); ?>

      <!-- =============== Graphs ================== -->
      <div class="graphs">        
        <div class="chart-container">
          <h3>Leads by Domain</h3>
          <canvas id="domainChart"></canvas>
        </div>
        
        <div class="pie-container">
          <h3>Lead Status Distribution</h3>
          <div id="statusPieChartContainer" style="height: 320px; max-width: 600px; margin: 30px auto; border-radius: 12px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 20px;"></div>
        </div>
      </div>


      <!-- bar chart for Domain -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        function loadDomainChart() {
          $.ajax({
            url: 'php/fetch_domain_chart_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              const ctx = document.getElementById('domainChart').getContext('2d');
              new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: data.domains,
                  datasets: [{
                    label: 'Leads per Domain',
                    data: data.counts,
                    backgroundColor: 'rgba(0, 88, 79, 1)'
                  }]
                },
                options: {
                  responsive: true,
                  scales: {
                    y: {
                      beginAtZero: true,
                      ticks: {
                        precision: 0
                      }
                    }
                  }
                }
              });
            }
          });
        }

        $(document).ready(function() {
          loadDomainChart();
        });
      </script>


      <!-- pie chart for Status -->
      <script>
        function load3DPieChart() {
          $.ajax({
            url: 'php/fetch_status_pie_data.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
              const statusColors = {
                closed: "#8de02c",
                switch_off: "#cfe103",
                call_not_picked: "#e9b10a",
                call_me_back: "#728b00fc",
                not_interested: "#f00",
                interested: "#1795ce",
                hot: "#bf17ce",
                very_hot: "#57016c",
                dumped: "#282829",
                broker: "#046b02",
                meeting_booked: "#dc1c9f",
                meeting_done: "#45002f",
                site_visited: "#08ec54"
              };

              const chartData = data.labels.map((label, i) => {
                const key = label.toLowerCase().replace(/\s+/g, "_");
                return {
                  y: data.counts[i],
                  label: label,
                  color: statusColors[key] || "#999" // fallback color
                };
              });

              const chart = new CanvasJS.Chart("statusPieChartContainer", {
                animationEnabled: true,
                title: {
                  fontSize: 20,
                  fontColor: "#163b6e",
                },
                legend: {
                  verticalAlign: "bottom",
                  horizontalAlign: "center"
                },
                data: [{
                  type: "pie",
                  startAngle: 240,
                  toolTipContent: "<b>{label}</b>: {y}",
                  indexLabel: "{label} - {y}",
                  dataPoints: chartData
                }]
              });

              chart.render();
            }
          });
        }

        $(document).ready(function() {
          load3DPieChart();
        });
      </script>




      <!-- ================ Order Details List ================= -->
      <div class="details">
        <div class="recentOrders">
          <div class="cardHeader">
            <h2>Recent Leads</h2>
          </div>

          <table>
            <thead>

              <tr>
                <td>S no.</td>
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
      updateCardNumber('.cardBox a:nth-child(1) .card .numbers', counts.total);
      updateCardNumber('.cardBox a:nth-child(2) .card .numbers', counts.interested);
      updateCardNumber('.cardBox a:nth-child(3) .card .numbers', counts.not_interested);
      updateCardNumber('.cardBox a:nth-child(4) .card .numbers', counts.hot);
      updateCardNumber('.cardBox a:nth-child(5) .card .numbers', counts.very_hot);
      updateCardNumber('.cardBox a:nth-child(6) .card .numbers', counts.dumped);
      updateCardNumber('.cardBox a:nth-child(7) .card .numbers', counts.meeting_booked);
      updateCardNumber('.cardBox a:nth-child(8) .card .numbers', counts.site_visited);
      updateCardNumber('.cardBox a:nth-child(9) .card .numbers', counts.raw_leads);
      updateCardNumber('.cardBox a:nth-child(10) .card .numbers', counts.ip_count);
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