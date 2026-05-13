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

            <div class="upper_container">
                <div class="form-container">
                    <h2>KRA's Detail</h2>
                    <form action="php/add_edited_kra.php" method="post">
                        <input type="hidden" id="id" name="id">
                        <div class="form-group" style="width: 100%;">
                            <input type="text" id="name" style="font-size: 14px; width: 100%;" name="name" placeholder="Name" autocomplete="off" required>
                            <label for="name">Name</label>
                            <div id="nameSuggestions" class="autocomplete-suggestions"></div>
                        </div>
                        <!-- <div class="row"> -->
                        <!-- </div> -->
                        <div class="col">

                            <div class="row">
                                <div class="form-group">
                                    <input type="number" id="callyzer_2pm" name="callyzer_2pm" placeholder="2 PM" required>
                                    <label for="callyzer_2pm">2 PM</label>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="callyzer_5pm" name="callyzer_5pm" placeholder="5 PM" required>
                                    <label for="callyzer_5pm">5 PM</label>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="callyzer_8pm" name="callyzer_8pm" placeholder="8 PM" required>
                                    <label for="callyzer_8pm">8 PM</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <input type="number" id="totalCalling" name="totalCalling" placeholder="Total Calling" required>
                                    <label for="EmployId">Total Calling</label>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="prospect" name="prospect" placeholder="Prospect" required>
                                    <label for="prospect">Prospect</label>
                                </div>
                                <div class="form-group">
                                    <input type="number" id="meetings" name="meetings" placeholder="No. of Meetings" required>
                                    <label for="meetings">No. of Meetings</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="width: 100%;">
                            <input type="date" id="dateInput" style="font-size: 14px; width: 100%;" name="date" placeholder="Date" required>
                            <label for="dateInput">Date</label>
                        </div>
                        <!-- <div class="form-group">
                        <input type="number" id="not_sale" name="not_sale" placeholder="No Sale Days" required>
                        <label for="not_sale">No Sale Days</label>
                    </div> -->
                        <button class="btn">Submit</button>
                    </form>
                </div>


                <!-- <div class="pie-chart" style="max-width: 400px; margin: 30px;">
                    <canvas id="kraSummaryChart"></canvas>
                </div> -->


                <script>
                    let kraChart = null; // chart instance

                    if (kraChart) {
                        kraChart.data.datasets[0].data = [res.totalTarget, res.totalCallyzer];
                        kraChart.update();
                    } else {
                        const ctx = document.getElementById('kraSummaryChart').getContext('2d');
                        kraChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['Total Target', 'Total Callyzer'],
                                datasets: [{
                                    data: [res.totalTarget, res.totalCallyzer],
                                    backgroundColor: ['rgba(0, 88, 79, 1)', '#f8c200'],
                                    borderWidth: 3,
                                    borderColor: '#ffffff'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Target vs Callyzer Summary',
                                        font: {
                                            size: 18
                                        }
                                    }
                                }
                            }
                        });
                    }
                </script>

            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                        <h2 id="reportDateTitle" style="font-size: clamp(20px, 5vw, 34px);">KRA's Data (<?= date('d-m-Y', strtotime($reportDate)) ?>)</h2>
                        <div style="display: flex;justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px;">
                            <input type="date" id="reportDate" value="<?= $reportDate ?>" style="padding: 5px 10px;" />
                            <div class="dropdown" style="position: relative; background: transparent; display: inline-block;">
                                <button class="btn" onclick="toggleDropdown()" style="border-radius: 5px;">
                                    Reports ▾
                                </button>
                                <div id="reportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 160px;">
                                    <a href="report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">View Day Report</a>
                                    <a href="report_date.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;"> View Customize Report</a>
                                    <!-- <a href="edit_kra_report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">Edit Report</a> -->
                                </div>
                            </div>
                            <a href="#" id="generateReportBtn" class="btn">Reset Report</a>
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
                                <th rowspan="2">S no.</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Calling Target</th>
                                <th colspan="3" id="callyzer_td">Callyzer</th>
                                <th rowspan="2" id="target_achieved_td">Target Achieved (%)</th>
                                <th rowspan="2" id="prospect_td">Prospect</th>
                                <th rowspan="2" id="meeting_td">Meetings</th>
                                <th rowspan="2" id="action_td">Action</th>
                                <!-- <th rowspan="2">No Sale</th> -->
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

    <!-- <script>
        document.getElementById('generateReportBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            const confirmed = confirm("Do you want to generate report?");
            if (confirmed) {
                window.location.href = 'php/generate_kra_report.php';
            }
        });
    </script> -->

    <script>
        document.getElementById("generateReportBtn").addEventListener("click", function(e) {
            e.preventDefault(); // ❗ Prevent the anchor's default behavior

            const selectedDate = document.getElementById("reportDate").value;

            if (!selectedDate) {
                alert("Please select a date first.");
                return;
            }

            const confirmGenerate = confirm(`Do you want to generate KRA report for ${selectedDate}?`);

            if (confirmGenerate) {
                // fetch(`php/generate_kra_report.php?date=${selectedDate}`)
                window.location.href = `php/generate_kra_report.php?date=${selectedDate}`;
            } else {
                console.log("User cancelled report generation.");
            }
        });
    </script>


    <script>
        function loadKraTable(selectedEmployees = []) {
            const selectedDate = $('#reportDate').val();

            $.ajax({
                url: 'php/fetch_editable_kra_report.php',
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

            setInterval(loadKraTable, 5000); // Refresh every 5s if needed

            // Date change handler
            $('#reportDate').on('change', function() {
                const selectedDate = $(this).val();
                const parts = selectedDate.split('-');
                if (parts.length === 3) {
                    const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                    $('#reportDateTitle').text(`KRA's Report (${formattedDate})`);
                }

                loadKraTable();
                updateKraSummaryChart(selectedDate); // ✅ update chart as well
            });

        });

        $(document).on('click', '.edit-btn', function() {
            const btn = $(this);

            $('#id').val(btn.data('id'));
            $('#name').val(btn.data('name'));
            $('#callyzer_2pm').val(btn.data('2pm'));
            $('#callyzer_5pm').val(btn.data('5pm'));
            $('#callyzer_8pm').val(btn.data('8pm'));

            // const total = parseInt(btn.data('2pm')) + parseInt(btn.data('5pm')) + parseInt(btn.data('8pm'));
            $('#totalCalling').val(btn.data('target'));

            $('#prospect').val(btn.data('prospect'));
            $('#meetings').val(btn.data('meetings'));

            // Set the date field if you added one
            $('#dateInput').val(btn.data('date'));

            // Scroll to top smoothly
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                const query = $(this).val();
                const selectedDate = $('#reportDate').val(); // get date filter

                if (query.length > 1) {
                    $.ajax({
                        url: 'php/search_kra_name_report.php',
                        method: 'GET',
                        data: {
                            term: query,
                            date: selectedDate
                        },
                        dataType: 'json',
                        success: function(data) {
                            const suggestions = $('#nameSuggestions');
                            suggestions.empty();

                            if (data.length === 0) {
                                suggestions.hide();
                                return;
                            }

                            data.forEach(item => {
                                const div = $('<div>')
                                    .text(`${item.name} (${item.employ_id})`)
                                    .data('details', item);
                                suggestions.append(div);
                            });

                            suggestions.show();
                        }
                    });
                } else {
                    $('#nameSuggestions').hide();
                }
            });

            $(document).on('click', '#nameSuggestions div', function() {
                const data = $(this).data('details');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#totalCalling').val(data.calling_target);
                $('#callyzer_2pm').val(data.callyzer_2pm);
                $('#callyzer_5pm').val(data.callyzer_5pm);
                $('#callyzer_8pm').val(data.callyzer_8pm);
                $('#prospect').val(data.prospects);
                $('#meetings').val(data.no_of_meetings);
                const dateOnly = data.date_time?.split(' ')[0]; // remove time
                $('#dateInput').val(dateOnly);
                $('#not_sale').val(data.not_sale != null ? data.not_sale : 0);

                $('#nameSuggestions').hide();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#nameSuggestions, #name').length) {
                    $('#nameSuggestions').hide();
                }
            });
        });
    </script>





    <!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>