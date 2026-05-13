<!-- admin.html -->
<?php include('php/check_login.php');
$statusFromURL = $_GET['status'] ?? 'all';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Call Record</title>

    <!-- ======= Styles ====== -->
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
                    <div class="cardHeader" style="display: flex; justify-content: space-between; align-items: center;">
                        <h2>KRA Records</h2>
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: center;">
                            <input type="date" id="fromDate" value="2025-05-01" style="padding: 5px 10px;" />
                            <input type="date" id="toDate" value="<?= date('Y-m-d') ?>" style="padding: 5px 10px;" />
                            <button class="btn" id="filterSelectedBtn" style="margin-left: 10px;">Filter Selected</button>
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
                                <th><input type="checkbox" id="selectAllCheckbox" /></th>
                                <th>S no.</th>
                                <th>Name</th>
                                <th>Calling Target</th>
                                <th>Total Callyzer</th>
                                <th>Target Achieved (%)</th>
                                <th>Prospect</th>
                                <th>Meetings</th>
                            </tr>
                        </thead>
                        <tbody id="callyzerTableBody">
                            <!-- Data Loads Here -->
                        </tbody>
                        <tfoot id="summaryFooter"></tfoot>

                    </table>

                    <!-- Update the JavaScript section -->
<script>
    function loadKraTable(selectedEmployees = []) {
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();

        $.ajax({
            url: 'php/fetch_date_kra_report.php',
            method: 'GET',
            data: {
                from: fromDate,
                to: toDate,
                employees: selectedEmployees.join(',') // Pass selected employees as CSV
            },
            success: function(data) {
                $('#callyzerTableBody').html(data);
                // Rebind checkbox events
                $('#selectAllCheckbox').on('change', function() {
                    $('.rowCheckbox').prop('checked', this.checked);
                });
            },
            error: function() {
                $('#callyzerTableBody').html('<tr><td colspan="8">Error loading report</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        loadKraTable(); // Initial load

        // Filter button for selected employees
        $('#filterSelectedBtn').on('click', function() {
            const selectedNames = $('.rowCheckbox:checked').map(function() {
                return $(this).data('name');
            }).get();

            if (selectedNames.length === 0) {
                alert('Please select at least one employee.');
                return;
            }
            loadKraTable(selectedNames);
        });
    });
</script>

                    <!-- html2canvas and jsPDF -->
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
                            const imgProps = pdf.getImageProperties(imageData);
                            const imgHeight = (imgProps.height * pageWidth) / imgProps.width;

                            let heightLeft = imgHeight;
                            let position = 0;

                            while (heightLeft > 0) {
                                pdf.addImage(imageData, 'JPEG', 0, position, pageWidth, imgHeight);
                                heightLeft -= pdf.internal.pageSize.getHeight();
                                if (heightLeft > 0) {
                                    pdf.addPage();
                                    position = 0;
                                }
                            }

                            const from = $('#fromDate').val();
                            const to = $('#toDate').val();
                            pdf.save(`KRA Report (${from} to ${to}).pdf`);
                        }

                        async function exportToPNG() {
                            const element = document.querySelector('.details');
                            const canvas = await html2canvas(element, {
                                scale: 2
                            });
                            const link = document.createElement('a');
                            link.href = canvas.toDataURL('image/png');
                            const from = $('#fromDate').val();
                            const to = $('#toDate').val();
                            link.download = `KRA Report (${from} to ${to}).png`;
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