<?php include('php/check_login.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | IP Captured Logs</title>
    <?php include('resource.php'); ?>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /*.main { width: 100%; overflow-x: hidden; }*/
        .details .recentOrders { overflow-x: auto; }
        .details table { width: 100%; min-width: 600px; }
        .duplicate { color: red; font-weight: bold; }
        .export-btn {
             background-color: #28a745;
             color: white;
             padding: 8px 12px;
             border: none;
             border-radius: 6px;
             cursor: pointer;
             font-weight: 500;
             display: inline-flex;
             align-items: center;
             gap: 8px;
        }
        .export-btn:hover {
            background-color: #218838;
        }
        .pagination{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-top: 10px;
            user-select: none;
        }
        .pagination-link{
            padding: 5px 10px;
            font-size: 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            background: var(--primary-color);
        }
        .pagination-link.disabled {
            background: #ccc;
            pointer-events: none;
            color: #666;
        }
        .pagination-link.active {
            background: var(--gold-color);
            /* font-weight: bold; */
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include('components/navbar.php') ?>
        <div class="main">
            <?php include('components/topbar.php'); ?>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Captured IP Logs</h2>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <button id="exportExcelBtn" class="export-btn">
                                <ion-icon name="download-outline"></ion-icon>
                                Export to Excel
                            </button>
                        </div>
                    </div>
                    <table>
                        <thead>
                             <tr>
                                <td style="background: transparent;">
                                    <button id="clearDates" class="filter-select" style="padding: 8px;">Clear Dates</button>
                                </td>
                                <td style="text-align: left; background: transparent; align-content: flex-end;">
                                  <select class="filter-select" id="domainSelect">
                                    <option value="all">All Domains</option>
                                    <?php include('php/fetch_domain.php') ?>
                                  </select>
                                </td>
                                <td style="background: transparent;">
                                    <label for="fromDate">From: &nbsp;</label><input type="date" id="fromDate" class="filter-select">
                                </td>
                                <td style="background: transparent;">
                                    <label for="toDate">To: &nbsp;</label><input type="date" id="toDate" class="filter-select">
                                </td>
                            </tr>
                            <tr>
                                <th>S No.</th>
                                <th>IP Address</th>
                                <th>Domain / URL</th>
                                <th>Access Time</th>
                            </tr>
                        </thead>
                        <tbody id="ipLogsTableBody"></tbody>
                    </table>
                    <div id="paginationContainer" class="pagination" style="margin-top:20px; text-align:center;"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="notificationContainer"></div>
    <script>
        let currentPage = 1;
        $(document).ready(function() {
            fetchIpLogs();
            $('#domainSelect, #fromDate, #toDate, #searchInput').on('input change', function() {
                currentPage = 1;
                fetchIpLogs();
            });
            $('#clearDates').on('click', function() {
                $('#fromDate').val('');
                $('#toDate').val('');
                currentPage = 1;
                fetchIpLogs();
            });
            $('#exportExcelBtn').on('click', exportToExcel);
            setInterval(fetchIpLogs, 30000);
        });

        function fetchIpLogs() {
            let selectedDomain = $('#domainSelect').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            let searchQuery = $('#searchInput').val();

            $.ajax({
                url: 'php/fetch/fetch_ip_logs.php',
                method: 'GET',
                data: {
                    domain: selectedDomain,
                    page: currentPage,
                    search: searchQuery,
                    fromDate: fromDate,
                    toDate: toDate
                },
                dataType: 'json',
                success: function(response) {
                    if (response.table && response.table.trim() !== '') {
                        $('#ipLogsTableBody').html(response.table);
                    } else {
                        $('#ipLogsTableBody').html(`
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #888;">
                                    No IP logs found matching your criteria.
                                </td>
                            </tr>
                        `);
                    }
                    $('#paginationContainer').html(response.pagination);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching IP logs:', error);
                }
            });
        }

        function changePage(page) {
            currentPage = page;
            fetchIpLogs();
        }

        function exportToExcel() {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'php/export_ip_logs.php';
            form.style.display = 'none';

            const params = {
                domain: $('#domainSelect').val(),
                search: $('#searchInput').val(),
                fromDate: $('#fromDate').val(),
                toDate: $('#toDate').val()
            };

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = params[key];
                    form.appendChild(input);
                }
            }

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

