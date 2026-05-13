<?php
// Include necessary files for login check and database configuration
include('php/check_login.php');
include('php/config.php');

// --- PHP LOGIC FOR DATA FETCHING AND FILTERING ---

// Default date range to the current date
$from_date = date('Y-m-d');
$to_date = date('Y-m-d');
$selected_employees = [];

// If the form is submitted via GET, update filters from the inputs
if (isset($_GET['filter'])) {
    if (!empty($_GET['from_date'])) {
        $from_date = $_GET['from_date'];
    }
    if (!empty($_GET['to_date'])) {
        $to_date = $_GET['to_date'];
    }
    if (!empty($_GET['selected_employees']) && is_array($_GET['selected_employees'])) {
        $selected_employees = $_GET['selected_employees'];
    }
}

// Updated SQL query with LEFT JOIN
$sql = "SELECT 
            tl.name as invited_by, 
            tl.employ_id, 
            COUNT(e.id) as registration_count 
        FROM 
            team_login tl
        LEFT JOIN 
            event e ON tl.employ_id = e.employ_id AND DATE(e.created_at) BETWEEN ? AND ?";

$params = [$from_date, $to_date];
$types = 'ss';

if (!empty($selected_employees)) {
    $placeholders = implode(',', array_fill(0, count($selected_employees), '?'));
    $sql .= " WHERE tl.employ_id IN ($placeholders)";
    $types .= str_repeat('s', count($selected_employees));
    $params = array_merge($params, $selected_employees);
}

$sql .= " GROUP BY tl.employ_id, tl.name ORDER BY registration_count DESC, invited_by ASC";

// --- HANDLE THE EXCEL (CSV) DOWNLOAD REQUEST ---
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=event_report_' . $from_date . '_to_' . $to_date . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('S No.', 'Name (Employee ID)', 'Number of Registrations'));
    
    if ($result->num_rows > 0) {
        $sno = 1;
        $total_registrations_download = 0;
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, array($sno++, $row['invited_by'] . ' (' . $row['employ_id'] . ')', $row['registration_count']));
            $total_registrations_download += $row['registration_count'];
        }
        fputcsv($output, array('', 'Total Registrations:', $total_registrations_download));
    }
    
    fclose($output);
    $stmt->close();
    $conn->close();
    exit();
}

// Prepare and execute the query for displaying the data on the page
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Event Registration Report</title>
    <?php include('resource.php'); ?>

    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="container">
        <?php include('components/navbar.php') ?>

        <div class="main">
            <?php include('php/admin_details.php'); ?>
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="user">
                    <img src="assets/imgs/admin/<?php echo $admin_profile; ?>" onclick="openPopup('<img src=\'assets/imgs/admin/<?php echo $admin_profile; ?>\' alt=\'Image\' /><p><?php echo $admin_name; ?></p>')">
                </div>
                <div class="popup-overlay" id="reusablePopup">
                    <div class="popup-content">
                        <button class="popup-close" onclick="closePopup()">&times;</button>
                        <div id="popup-body"></div>
                        <div id="popup-actions" class="popup-actions"></div>
                    </div>
                </div>
            </div>

            <style>
                .recentOrders{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                }
            </style>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2 style="margin-bottom: 20px;">Event Registration Report</h2>
                    </div>

                    <form method="get" action="">
                        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap; margin-bottom: 20px; padding: 0 10px;">
                            <label for="from_date" style="font-weight: bold;">From:</label>
                            <input type="date" id="from_date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">

                            <label for="to_date" style="font-weight: bold;">To:</label>
                            <input type="date" id="to_date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                        </div>

                        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 20px; padding: 0 10px;">
                            <button type="submit" name="filter" value="true" class="btn">Filter Selection</button>
                            <a href="event_report.php" class="btn" style="color: white; text-decoration: none;">Reset</a>
                            <!--<a href="event_client.php" class="btn" style="color: white; text-decoration: none;">Details</a>-->
                            
                            <div class="dropdown" style="position: relative; display: inline-block;">
                                <button type="button" class="btn" onclick="toggleExportDropdown(event)" >Download Report ▾</button>
                                <div id="exportDropdown" class="dropdown-content" style="display: none; position: absolute; background: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 10; border-radius: 5px; min-width: 120px;">
                                    <a href="#" onclick="downloadExcel()">Excel</a>
                                    <a href="#" onclick="downloadPNG()">PNG</a>
                                    <a href="#" onclick="downloadPDF()">PDF</a>
                                </div>
                            </div>
                        </div>

                        <table id="reportTable" style="max-width: 600px;">
                            <thead>
                                <tr>
                                    <th class="checkbox-column"><input type="checkbox" id="selectAllCheckbox"></th>
                                    <th>S No.</th>
                                    <th style="text-align: left;">Name (Employee ID)</th>
                                    <th>No of Registrations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_registrations = 0; // Initialize total
                                if ($result && $result->num_rows > 0) {
                                    $sno = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        $total_registrations += $row['registration_count']; // Add to total
                                        $isChecked = in_array($row['employ_id'], $selected_employees) ? 'checked' : '';
                                        echo "<tr>";
                                        echo "<td class='checkbox-column'><input type='checkbox' class='employee-checkbox' name='selected_employees[]' value='" . htmlspecialchars($row['employ_id']) . "' $isChecked></td>";
                                        echo "<td style='text-align: center;'>" . $sno++ . "</td>";
                                        echo "<td style='text-align: left;'>" . htmlspecialchars($row['invited_by']) . " (" . htmlspecialchars($row['employ_id']) . ")</td>";
                                        echo "<td style='text-align: center;'>" . htmlspecialchars($row['registration_count']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' style='text-align: center;'>No registration data found for the selected criteria.</td></tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr style="background: rgba(0, 88, 79, 1); color: #f8c200;">
                                    <th class="checkbox-column" style="padding: 10px;"></th>
                                    <th colspan="2" style="text-align: right;padding: 10px;">Total Registrations:</th>
                                    <th style="text-align: center;padding: 10px;"><?php echo $total_registrations; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationContainer"></div>
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        document.getElementById('selectAllCheckbox').addEventListener('click', function(event) {
            document.querySelectorAll('.employee-checkbox').forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });

        function toggleExportDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('exportDropdown');
            dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        }

        window.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.getElementById('exportDropdown').style.display = 'none';
            }
        });

        const { jsPDF } = window.jspdf;

        function toggleCheckboxColumn(show) {
            const displayStyle = show ? '' : 'none';
            document.querySelectorAll('.checkbox-column').forEach(cell => {
                cell.style.display = displayStyle;
            });
        }

        function downloadExcel() {
            const fromDate = document.getElementById('from_date').value;
            const toDate = document.getElementById('to_date').value;
            let url = `?download=csv&from_date=${fromDate}&to_date=${toDate}&filter=true`;
            document.querySelectorAll('.employee-checkbox:checked').forEach(checkbox => {
                url += `&selected_employees[]=${checkbox.value}`;
            });
            window.location.href = url;
        }

        function downloadPNG() {
            toggleCheckboxColumn(false); // Hide column
            html2canvas(document.getElementById('reportTable')).then(canvas => {
                const link = document.createElement('a');
                link.download = `Event-Report-${new Date().toISOString().slice(0,10)}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).finally(() => {
                toggleCheckboxColumn(true); // Show column again
            });
        }

        function downloadPDF() {
            toggleCheckboxColumn(false); // Hide column
            const doc = new jsPDF();
            html2canvas(document.getElementById('reportTable')).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                doc.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight - 20);
                doc.save(`Event-Report-${new Date().toISOString().slice(0,10)}.pdf`);
            }).finally(() => {
                toggleCheckboxColumn(true); // Show column again
            });
        }
    </script>
</body>
</html>