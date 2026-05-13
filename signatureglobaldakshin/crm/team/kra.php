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
    <?php include('../resource.php'); ?>
    <!-- ======= Styles ====== -->
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="../style.css?v=<?= filemtime('../style.css'); ?>">

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include('components/navbar.php') ?>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <!-- ======================= topbar ================== -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="tabName">
                    <p class="pageName">Dashboard / <span>KRA</span></p>
                </div>

                <!-- <div class="search">
                    <label>
                        <input type="text" id="searchKra" placeholder="Search by name or ID" autocomplete="off">
                        <ion-icon name="search-outline"></ion-icon>
                        <ul id="suggestionsList" class="suggestion-box"></ul>
                    </label>
                </div> -->


                <div class="user">
                <img src="../assets/imgs/default_profile.png" onclick="openPopup('<img src=\'../assets/imgs/default_profile.png\' alt=\'Image\' /><p><?php echo $username; ?></p>')">
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



            <div class="upper_container">
                <?php include('components/kra_details.html') ?>
                <div class="pie-chart" style="max-width: 400px; margin: 30px;">
                    <canvas id="kraSummaryChart"></canvas>
                </div>
            </div>




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
                    <div class="cardHeader">
                        <h2>KRA Records</h2>
                        <div style="display: flex;flex-wrap: wrap; justify-content: center; align-items: center; gap: 10px;">
                            <!-- <a onclick="openResetPopup('<p>Are You Sure, You want to Reset KRA?</p>', true)" class="btn">Reset Report</a> -->
                            <!-- <a href="php/reset_kra.php" class="btn">Reset Report</a> -->
                            <!-- <div class="dropdown" style="position: relative; background: transparent; display: inline-block;">
                                <button class="btn" onclick="toggleDropdown()" style="border-radius: 5px;">
                                    Reports ▾
                                </button>
                                <div id="reportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 160px;">
                                    <a href="report.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">Day Report</a>
                                    <a href="report_date.php" style="padding: 10px 16px; display: block; text-decoration: none; color: #333;">Customize Report</a>
                                </div>
                            </div> -->
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


                    </div>

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
                                <!-- <th rowspan="2">No Sale</th> -->
                                <th rowspan="2" id="action_button">Action</th>
                            </tr>
                            <tr>
                                <th>2PM</th>
                                <th>5PM</th>
                                <th>8PM</th>
                            </tr>
                        </thead>


                        <tbody id="callyzerTableBody">
                            <!-- fetech kra data from php/fetch_kra.php -->
                        </tbody>
                        <tfoot id="summaryFooter"></tfoot>


                    </table>

                    <!-- <div id="paginationContainer" class="pagination" style="margin-top:20px; text-align:center;"></div> -->

                </div>

            </div>
        </div>
    </div>

    <div id="notificationContainer"></div>

    <script>
        $(document).ready(function() {
            loadKraTable(); // Initial load
            setInterval(loadKraTable, 5000); // Refresh every 5s if needed

            function loadKraTable() {
                $.ajax({
                    url: 'php/fetch_kra.php',
                    method: 'GET',
                    success: function(data) {
                        $('#callyzerTableBody').html(data);
                    },
                    error: function() {
                        $('#callyzerTableBody').html('<tr><td colspan="9">Failed to load data</td></tr>');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            const btn = $(this);

            $('#id').val(btn.data('id'));
            $('#name').val(btn.data('name'));
            $('#totalCalling').val(btn.data('calling'));
            $('#callyzer_2pm').val(btn.data('2pm'));
            $('#callyzer_5pm').val(btn.data('5pm'));
            $('#callyzer_8pm').val(btn.data('8pm'));
            $('#prospect').val(btn.data('prospect'));
            $('#meetings').val(btn.data('meeting'));
            $('#not_sale').val(btn.data('not_sale')); // Changed from 'noSale' to 'nosale'

            $('.kra-row').removeClass('selected');
            btn.closest('tr').addClass('selected');
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                const query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: 'php/search_kra_name.php',
                        method: 'GET',
                        data: {
                            term: query
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

    <script>
        $(document).ready(function() {
            $('#searchKra').on('input', function() {
                let query = $(this).val();

                if (query.length > 1) {
                    $.ajax({
                        url: 'php/kra_suggestions.php',
                        method: 'GET',
                        data: {
                            search: query
                        },
                        success: function(data) {
                            let suggestions = JSON.parse(data);
                            let listHtml = '';

                            if (suggestions.length > 0) {
                                suggestions.forEach(item => {
                                    listHtml += `<li data-json='${JSON.stringify(item)}'>${item.name} (${item.employ_id})</li>`;
                                });
                            } else {
                                listHtml = '<li>No matches found</li>';
                            }

                            $('#suggestionsList').html(listHtml).show();
                        }
                    });
                } else {
                    $('#suggestionsList').hide();
                }
            });

            // When user clicks on a suggestion
            $(document).on('click', '#suggestionsList li', function() {
                const data = $(this).data('json');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#totalCalling').val(data.calling_target);
                $('#callyzer_2pm').val(data.callyzer_2pm);
                $('#callyzer_5pm').val(data.callyzer_5pm);
                $('#callyzer_8pm').val(data.callyzer_8pm);
                $('#prospect').val(data.prospects);
                $('#meetings').val(data.no_of_meetings);
                $('#not_sale').val(data.not_sale != null ? data.not_sale : 0);
                $('#searchKra').val(`${data.name} (${data.employ_id})`);
                $('#suggestionsList').hide();
            });

            // Hide suggestions on outside click
            $(document).click(function(e) {
                if (!$(e.target).closest('.search').length) {
                    $('#suggestionsList').hide();
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