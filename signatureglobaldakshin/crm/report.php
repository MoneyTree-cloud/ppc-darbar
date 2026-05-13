<!-- admin.html -->
<?php include('php/check_login.php');
$statusFromURL = $_GET['status'] ?? 'all';
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


            <style>
                #callyzerTableBody tr td {
                    text-align: center;
                }

                #callyzer_td {
                    border-bottom: none;
                }

                #totalTarget {
                    text-align: center !important;
                }

                #totalMeetings {
                    text-align: center !important;
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

                    #prospect_td {
                        /* text-align: left; */
                        border-right: 4px solid transparent;
                    }

                    #meeting_td {
                        text-align: right;
                    }

                    #callyzer_td,
                    #target_achieved_td,
                    #action_button {
                        display: none !important;
                    }

                    #callyzerTableBody tr td:nth-child(4),
                    #callyzerTableBody tr td:nth-child(7),
                    #callyzerTableBody tr td:nth-child(10) {
                        display: none;
                    }
                }
            </style>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                        <h2 id="reportDateTitle" style="font-size: clamp(20px, 5vw, 34px);">KRA's Report (<?= date('d-m-Y') ?>)</h2>

                        <div style="display: flex;justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px;">
                            <input type="date" id="reportDate" value="<?= date('Y-m-d') ?>" style="padding: 5px 10px;" />
                            <button class="btn" id="filterSelectedBtn">Filter</button>
                            <button class="btn" id="showAllBtn">Show All</button> <!-- New button -->
                            <div class="dropdown">
                                <button class="btn">Download Report ▾</button>
                                <div class="dropdown-content">
                                    <a href="#" onclick="exportToPDF()">Export as PDF</a>
                                    <a href="#" onclick="exportToPNG()">Export as PNG</a>
                                    <a href="#" onclick="exportToExcel()">Export as Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table>
                        <thead>
                            <tr>

                                <th rowspan="2"><input type="checkbox" id="selectAllCheckbox" /></th>
                                <th rowspan="2">S no.</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Calling Target</th>
                                <th colspan="3" id="callyzer_td">Callyzer</th>
                                <th rowspan="2" id="target_achieved_td">Target Achieved (%)</th>
                                <th rowspan="2" id="prospect_td">Prospect</th>
                                <th rowspan="2" id="meeting_td">Meetings</th>
                                <!--<th rowspan="2">No Sale days</th>-->
                                <!--<th rowspan="2" id="action_button">Action</th>-->
                            </tr>
                            <tr>
                                <th>2PM</th>
                                <th>5PM</th>
                                <th>8PM</th>
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
        function loadKraTable(selectedEmployees = []) {
            const selectedDate = $('#reportDate').val();

            $.ajax({
                url: 'php/fetch_kra_report.php',
                method: 'GET',
                data: {
                    date: selectedDate,
                    employees: selectedEmployees
                },
                traditional: true,
                success: function(data) {
                    $('#callyzerTableBody').html(data);

                    // Add this to handle the select all checkbox
                    $('#selectAllCheckbox').on('change', function() {
                        $('.rowCheckbox').prop('checked', this.checked);
                    });
                },
                error: function() {
                    $('#callyzerTableBody').html('<tr><td colspan="10">Failed to load data</td></tr>');
                }
            });
        }

        $(document).ready(function() {
            loadKraTable();

            // Date change handler
            $('#reportDate').on('change', function() {
                const selectedDate = $(this).val();
                const parts = selectedDate.split('-');
                if (parts.length === 3) {
                    const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    $('#reportDateTitle').text(`KRA's Report (${formattedDate})`);
                }
                loadKraTable();
            });

            // Filter button
            $('#filterSelectedBtn').on('click', function() {
                const selectedNames = $('.rowCheckbox:checked').map(function() {
                    return $(this).data('name');
                }).get();

                if (selectedNames.length === 0) {
                    alert('Please select at least one employee.');
                    return;
                }
                loadKraTable(selectedNames.join(','));
            });

            // Show All button
            $('#showAllBtn').on('click', function() {
                $('#reportDate').val(new Date().toISOString().split('T')[0]);
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-GB').replace(/\//g, '-');
                $('#reportDateTitle').text(`KRA's Report (${formattedDate})`);
                loadKraTable();
                $('.rowCheckbox, #selectAllCheckbox').prop('checked', false);
            });

            // Select All functionality
            $(document).on('change', '#selectAllCheckbox', function() {
                $('.rowCheckbox').prop('checked', this.checked);
            });
        });

        function loadKraTable(selectedEmployees = []) {
            const selectedDate = $('#reportDate').val();

            $.ajax({
                url: 'php/fetch_kra_report.php',
                method: 'GET',
                data: {
                    date: selectedDate,
                    employees: selectedEmployees
                },
                traditional: true,
                success: function(data) {
                    $('#callyzerTableBody').html(data);

                    // Handle Select All checkbox
                    $('#selectAllCheckbox').on('change', function() {
                        $('.rowCheckbox').prop('checked', this.checked);
                    });
                },
                error: function() {
                    $('#callyzerTableBody').html('<tr><td colspan="10">Failed to load data</td></tr>');
                }
            });
        }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        async function exportToPDF() {
            const element = document.querySelector('.details');
            const canvas = await html2canvas(element, {
                scale: 2
            });
            const imageData = canvas.toDataURL('image/jpeg', 1.0);
            const pdf = new jspdf.jsPDF('p', 'mm', 'a4');

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgProps = pdf.getImageProperties(imageData);
            const imgWidth = pageWidth;
            const imgHeight = (imgProps.height * imgWidth) / imgProps.width;

            if (imgHeight < pageHeight) {
                pdf.addImage(imageData, 'JPEG', 0, 0, imgWidth, imgHeight);
            } else {
                let heightLeft = imgHeight;
                let position = 0;
                while (heightLeft > 0) {
                    pdf.addImage(imageData, 'JPEG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                    if (heightLeft > 0) {
                        pdf.addPage();
                        position = 0;
                    }
                }
            }

            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').replace(/\//g, '-'); // DD-MM-YYYY
            pdf.save(`KRA's Report (${formattedDate}).pdf`);
        }

        async function exportToPNG() {
            const element = document.querySelector('.details');
            const canvas = await html2canvas(element, {
                scale: 2
            });
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').replace(/\//g, '-'); // DD-MM-YYYY
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = `KRA's Report (${formattedDate}).png`;
            link.click();
        }

        function exportToExcel() {
            const table = document.querySelector('.details table');
            let csv = '';
            for (let row of table.rows) {
                let cells = Array.from(row.cells).map(cell => `"${cell.textContent.trim()}"`);
                csv += cells.join(',') + '\n';
            }

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').replace(/\//g, '-'); // DD-MM-YYYY
            a.download = `KRA's Report (${formattedDate}).csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>






    <!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>