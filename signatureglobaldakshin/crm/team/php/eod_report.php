<!-- admin.html -->
<?php include('php/check_login.php');
$statusFromURL = $_GET['status'] ?? 'all';
?>
<?php
$reportDate = $_GET['date'] ?? date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <title>Admin Dashboard | KRA's Record</title>

    <!-- ======= Styles ====== -->
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- html2canvas for converting HTML to image -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jsPDF for creating PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include('components/navbar.php') ?>

        <!-- ========================= Main ==================== -->
        <div class="main">


            <!-- ======================= topbar ================== -->
            <?php include('components/topbar.php'); ?>

            <!-- <script>
                document.getElementById("search_bar").style.display = 'none';
            </script> -->


            <style>
                td{
                    text-align: center;
                }


                @media (max-width: 480px) {
                    thead {
                        font-size: 12px;
                    }
                }

                @media (max-width: 768px) {
                    thead tr:nth-child(2) {
                        display: none;
                    }

                    
            </style>                

     
            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                        <h2 id="reportDateTitle" style="font-size: clamp(20px, 5vw, 34px);">EOD Report (<?= date('d-m-Y', strtotime($reportDate)) ?>)</h2>
                        <div style="display: flex;justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px;">
                            
                            <div class="dropdown" style="position: relative; background: transparent; display: inline-block;">
                                <button class="btn" onclick="toggleDropdown()" style="border-radius: 5px;">
                                    Reports ▾
                                </button>
                                <div id="reportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 160px;">
                                    <a href="eod_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">View Teal Report</a>
                                    <a href="eod_leader_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;"> View Leader Report</a>
                                 
                                </div>
                            </div>
                            <input type="date" id="reportDate" value="<?= $reportDate ?>" style="padding: 5px 10px;" />
                          
                        </div>
                    </div>

                    <script>
                            function toggleDropdown() {
                                const dropdown = document.getElementById('reportDropdown');
                                dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
                            }

                            // Optional: Hide dropdown when clicking outside
                            document.addEventListener('click', function(event) {
                                const dropdown = document.getElementById('reportDropdown');
                                if (!event.target.closest('.dropdown')) {
                                    dropdown.style.display = 'none';
                                }
                            });
                        </script>


                    <table>
                        <thead>
                            <tr>
                                <th>S no.</th>
                                <th>Name</th>
                                <th>Calls</th>
                                <th id="callyzer_td">Prospects</th>
                                <th id="target_achieved_td">Meetings</th>
                                <th id="prospect_td">Exp. Sales</th>
                                <th id="meeting_td">Checkout</th>
                                <th id="action_td">Action</th>
                                <!-- <th rowspan="2">No Sale</th> -->
                            </tr>
                           
                        </thead>



                        <tbody id="callyzerTableBody">
                            <!-- fetched rows here -->
                        </tbody>

                        <tfoot id="summaryFooter">
                            <!-- total summary will be inserted here -->
                        </tfoot>


                    </table>

                    <!-- <div id="paginationContainer" class="pagination" style="margin-top:20px; text-align:center;"></div> -->

                </div>

            </div>
        </div>
    </div>

    <div id="notificationContainer"></div>

   


   <script>
    document.addEventListener("DOMContentLoaded", function () {
    const reportDateInput = document.getElementById('reportDate');
    const reportDateTitle = document.getElementById('reportDateTitle');
    
    // Function to fetch and display data
    function fetchData(date = null) {
        const url = date ? `php/fetch/fetch_team_eod.php?date=${date}` : 'php/fetch/fetch_team_eod.php';
        
        fetch(url)
            .then((res) => res.json())
            .then((data) => {
                const tbody = document.getElementById("callyzerTableBody");
                tbody.innerHTML = "";

                if (!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="8">No data available for selected date.</td></tr>`;
                    return;
                }

                data.forEach((row, index) => {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td>${row.sno}</td>
                        <td style="text-align:left;">${row.employ_id}</td>
                        <td>${row.calls}</td>
                        <td>${row.prospects}</td>
                        <td>${row.meetings}</td>
                        <td>${row.client_name}</td>
                        <td>${row.check_out}</td>
                        <td style="display:flex;justify-content: flex-end;">
                            <button class="btn" data-id="${row.sno}"><ion-icon name="create-outline"></ion-icon></button>
                            <button class="btn" data-id="${row.sno}"><ion-icon name="trash-outline"></ion-icon></button>
                        </td>
                    `;

                    tbody.appendChild(tr);
                });
            })
            .catch((err) => {
                console.error(err);
                document.getElementById("callyzerTableBody").innerHTML = `<tr><td colspan="8">Error loading data.</td></tr>`;
            });
    }

    // Initial load with current date
    fetchData();
    
    // Update the report when date changes
    reportDateInput.addEventListener('change', function() {
        const selectedDate = this.value;
        reportDateTitle.textContent = `EOD Report (${formatDateForDisplay(selectedDate)})`;
        fetchData(selectedDate);
    });

    // Auto-refresh every 5 seconds
    setInterval(() => {
        const currentDate = reportDateInput.value;
        fetchData(currentDate);
    }, 5000);

    // Helper function to format date for display
    function formatDateForDisplay(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
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

