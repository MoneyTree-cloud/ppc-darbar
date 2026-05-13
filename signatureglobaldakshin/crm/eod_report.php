<!-- admin.html -->
<?php include('php/check_login.php');
$statusFromURL = $_GET['status'] ?? 'all';
?>
<?php
$reportDate = $_GET['date'] ?? date('Y-m-d', strtotime('-1 day'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | EOD's Record</title>

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

            <!-- <script>
                document.getElementById("search_bar").style.display = 'none';
            </script> -->


            <style>
                td {
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
                        <h2 id="reportDateTitle" style="font-size: clamp(20px, 5vw, 34px);">Team EOD Report (<?= date('d-m-Y', strtotime($reportDate)) ?>)</h2>
                        <div style="display: flex;justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px;">

                            <input type="date" id="reportDate" value="<?= $reportDate ?>" style="padding: 5px 10px;" />

                            <div class="dropdown" style="position: relative; background: transparent; display: inline-block;">
                                <button class="btn" onclick="toggleDropdown()" style="border-radius: 5px;">
                                    Reports ▾
                                </button>
                                <div id="reportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 160px;">
                                    <a href="eod_date_details.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">View detailed Report</a>
                                    <a href="leader_eod_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;"> View Leader Report</a>
                                    <a href="eod_missing_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">Missing EOD Report</a>
                                </div>
                            </div>

                            <div class="dropdown" style="position: relative; display: inline-block;">
                                <button class="btn" onclick="toggleExportDropdown()" style="border-radius: 5px;">
                                    Download Report ▾
                                </button>
                                <div id="exportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 120px;">
                                    <a href="#" onclick="exportToPNG()" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">PNG</a>
                                    <a href="#" onclick="exportToPDF()" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">PDF</a>
                                    <a href="#" onclick="exportToExcel()" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">Excel</a>
                                </div>
                            </div>

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
    document.addEventListener("DOMContentLoaded", function() {
        const reportDateInput = document.getElementById('reportDate');
        const reportDateTitle = document.getElementById('reportDateTitle');

        // Function to fetch and display data
        function fetchData(date = null) {
            const selectedDate = date || reportDateInput.value;
            const url = `php/fetch/fetch_team_eod.php?date=${selectedDate}`;

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
                        const currentDate = reportDateInput.value; // Get the currently selected date

                        tr.innerHTML = `
                            <td>${row.sno}</td>
                            <td style="text-align:left;">${row.employ_id}</td>
                            <td>${row.calls}</td>
                            <td>${row.prospects}</td>
                            <td>${row.meetings}</td>
                            <td>${row.client_name}</td>
                            <td>${row.check_out}</td>
                            <td style="display:flex;justify-content: flex-end;">
                                <a class="btn" href="eod_details.php?name=${encodeURIComponent(row.employ_id)}&date=${currentDate}">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </a>
                                <a href="javascript:void(0);" onclick="confirmDelete('${row.employ_id}', '${row.date}')" class="btn">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </a>
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
            reportDateTitle.textContent = `Team EOD Report (${formatDateForDisplay(selectedDate)})`;
            fetchData(selectedDate);
        });

        // Auto-refresh every 30 seconds
        setInterval(() => {
            const currentDate = reportDateInput.value;
            fetchData(currentDate);
        }, 30000);

        // Helper function to format date for display
        function formatDateForDisplay(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
    });

        // Add this JavaScript function:
    function confirmDelete(employId, date) {
        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = `php/delete/delete_eod.php?employ_id=${encodeURIComponent(employId)}&date=${encodeURIComponent(date)}`;
        }
    }


</script>

    <script>
        // Toggle export dropdown
        function toggleExportDropdown() {
            const dropdown = document.getElementById('exportDropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.getElementById('exportDropdown').style.display = 'none';
            }
        });

        // Export functions
        function exportToPNG() {
            document.getElementById('exportDropdown').style.display = 'none';
            document.querySelector('#reportDate').style.display = 'none';
            html2canvas(document.querySelector('.details')).then(canvas => {
                const link = document.createElement('a');
                link.download = `EOD-Report-${document.getElementById('reportDate').value}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
            document.querySelector('#reportDate').style.display = 'block';
        }

        function exportToPDF() {
            document.getElementById('exportDropdown').style.display = 'none';
            document.querySelector('#reportDate').style.display = 'none';
            const element = document.querySelector('.details');
            html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`EOD-Report-${document.getElementById('reportDate').value}.pdf`);
            });
            document.querySelector('#reportDate').style.display = 'block';
        }

        function exportToExcel() {
            document.getElementById('exportDropdown').style.display = 'none';
            document.querySelector('#reportDate').style.display = 'none';
            const table = document.querySelector('table');
            const html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
            const link = document.createElement('a');
            link.download = `EOD-Report-${document.getElementById('reportDate').value}.xls`;
            link.href = url;
            link.click();
            document.querySelector('#reportDate').style.display = 'block';
        }
    </script>

    <!-- Add these script dependencies to your head section -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Initialize jsPDF
        const {
            jsPDF
        } = window.jspdf;
    </script>




    <!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>