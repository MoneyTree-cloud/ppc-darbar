<?php
// Database connection details
include('php/config.php');
include('php/check_login.php');
// --- 1. SETUP FILTERS ---
$report_date = $_GET['report_date'] ?? date('Y-m-d');
$selected_employees = $_GET['selected_employees'] ?? [];

// --- 2. IDENTIFY TEAM LEADERS ---
$leader_ids_query = "SELECT DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(employ_id, '(', -1), ')', 1) as id FROM team_leader_eod";
$leader_result = $conn->query($leader_ids_query);
$leader_ids = [];
while ($row = $leader_result->fetch_assoc()) {
    $leader_ids[] = $row['id'];
}
$leader_placeholders = !empty($leader_ids) ? implode(',', array_fill(0, count($leader_ids), '?')) : "''";

// --- [MODIFIED] HANDLE CSV DOWNLOAD REQUEST ---
if (isset($_GET['download'])) {
    $report_type = $_GET['download']; // 'team_csv' or 'leader_csv'
    $sql = '';
    $params = [];
    $types = '';
    $filename = "missing_report_{$report_date}.csv";

    if ($report_type === 'team_csv') {
        $filename = "missing_team_eod_report_{$report_date}.csv";
        $sql = "SELECT tl.name, tl.employ_id FROM team_login tl LEFT JOIN team_eod te ON tl.employ_id = SUBSTRING_INDEX(SUBSTRING_INDEX(te.employ_id, '(', -1), ')', 1) AND DATE(te.check_out) = ? WHERE te.id IS NULL AND tl.employ_id NOT IN ($leader_placeholders) ORDER BY tl.name ASC";
        $params = array_merge([$report_date], $leader_ids);
        $types = 's' . str_repeat('s', count($leader_ids));
    } elseif ($report_type === 'leader_csv' && !empty($leader_ids)) {
        $filename = "missing_leader_eod_report_{$report_date}.csv";
        $sql = "SELECT tl.name, tl.employ_id FROM team_login tl LEFT JOIN team_leader_eod tle ON tl.employ_id = SUBSTRING_INDEX(SUBSTRING_INDEX(tle.employ_id, '(', -1), ')', 1) AND DATE(tle.check_out) = ? WHERE tle.id IS NULL AND tl.employ_id IN ($leader_placeholders) ORDER BY tl.name ASC";
        $params = array_merge([$report_date], $leader_ids);
        $types = 's' . str_repeat('s', count($leader_ids));
    }

    if (!empty($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['S.No.', 'Employee Name', 'Employee ID']);
        $sno = 1;
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [$sno++, $row['name'], $row['employ_id']]);
        }
        fclose($output);
        exit();
    }
}

// --- Database queries for page display (unchanged) ---
// ... (queries for team and leader reports for page display)
// --- 3. FIND MISSING TEAM EOD REPORTS (for display) ---
$sql_team = "SELECT tl.name, tl.employ_id FROM team_login tl LEFT JOIN team_eod te ON tl.employ_id = SUBSTRING_INDEX(SUBSTRING_INDEX(te.employ_id, '(', -1), ')', 1) AND DATE(te.check_out) = ? WHERE te.id IS NULL AND tl.employ_id NOT IN ($leader_placeholders)";
$params_team = array_merge([$report_date], $leader_ids);
$types_team = 's' . str_repeat('s', count($leader_ids));
if (!empty($selected_employees)) {
    $selected_placeholders = implode(',', array_fill(0, count($selected_employees), '?'));
    $sql_team .= " AND tl.employ_id IN ($selected_placeholders)";
    $params_team = array_merge($params_team, $selected_employees);
    $types_team .= str_repeat('s', count($selected_employees));
}
$sql_team .= " ORDER BY tl.name ASC";
$stmt_team = $conn->prepare($sql_team);
$stmt_team->bind_param($types_team, ...$params_team);
$stmt_team->execute();
$result_team = $stmt_team->get_result();

// --- 4. FIND MISSING LEADER EOD REPORTS (for display) ---
$sql_leader = "SELECT tl.name, tl.employ_id FROM team_login tl LEFT JOIN team_leader_eod tle ON tl.employ_id = SUBSTRING_INDEX(SUBSTRING_INDEX(tle.employ_id, '(', -1), ')', 1) AND DATE(tle.check_out) = ? WHERE tle.id IS NULL AND tl.employ_id IN ($leader_placeholders)";
$params_leader = array_merge([$report_date], $leader_ids);
$types_leader = 's' . str_repeat('s', count($leader_ids));
if (!empty($selected_employees)) {
    $selected_placeholders = implode(',', array_fill(0, count($selected_employees), '?'));
    $sql_leader .= " AND tl.employ_id IN ($selected_placeholders)";
    $params_leader = array_merge($params_leader, $selected_employees);
    $types_leader .= str_repeat('s', count($selected_employees));
}
$sql_leader .= " ORDER BY tl.name ASC";
$stmt_leader = $conn->prepare($sql_leader);
if (!empty($leader_ids)) {
    $stmt_leader->bind_param($types_leader, ...$params_leader);
    $stmt_leader->execute();
    $result_leader = $stmt_leader->get_result();
} else {
    $result_leader = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Missing EOD Report</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
    <?php include('resource.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <style>
        /* body { font-family: sans-serif; background-color: #f4f4f9;} */
        
        h2 { text-align: center; color: rgba(0, 88, 79, 1); margin-bottom: 20px;}
        .table-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ecf0f1; }
        .table-header h3 { color: #c0392b; margin-top: 40px; margin-bottom: 10px; border: none; }
        .filters { display: flex; justify-content: center; align-items: center; gap: 15px; margin-bottom: 25px; flex-wrap: wrap; }
        .filters label { font-weight: bold; }
        .filters input[type="date"], .filters button, .download-btn { padding: 10px 15px; border-radius: 5px; font-size: 14px; text-decoration: none; display: inline-block; }
        .filters input[type="date"] { border: 1px solid #ccc; }
        /*.filters button { background-color: #007bff; color: white; cursor: pointer; border: none; }*/
        .download-btn { background-color: #28a745; color: white; border: 1px solid #218838; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .no-data { text-align: center; padding: 20px; color: #27ae60; font-weight: bold; }
        
        /* [NEW] Dropdown Styles */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background-color: #f9f9f9; min-width: 100px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px; }
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; }
        .dropdown-content a:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <?php include('components/navbar.php') ?>

        <!-- ========================= Main ==================== -->
        <div class="main">


            <!-- ======================= topbar ================== -->
            <?php include('components/topbar.php'); ?>

            <script>
                document.getElementById("search_bar").style.display = 'none';
            </script>

    <div class="container" style=" margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2>Missing EOD Report</h2>
        <form method="get" action="">
            <div class="filters">
                <label for="report_date">Select Date:</label>
                <input type="date" id="report_date" name="report_date" value="<?php echo htmlspecialchars($report_date); ?>">
                <button type="submit" class="btn" name="filter">Filter</button>
            </div>

            <div class="table-header">
                <h3>Missing Team EOD Reports</h3>
                <div class="dropdown">
                    <button type="button" class="download-btn" onclick="toggleDropdown('teamExportDropdown')">Download ▾</button>
                    <div id="teamExportDropdown" class="dropdown-content">
                        <a href="?download=team_csv&report_date=<?php echo htmlspecialchars($report_date); ?>">CSV</a>
                        <a href="#" onclick="exportTableToPNG('teamTable', event)">PNG</a>
                        <a href="#" onclick="exportTableToPDF('teamTable', 'Missing Team EOD Report', event)">PDF</a>
                    </div>
                </div>
            </div>
            <table id="teamTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAllTeam"></th>
                        <th>S.No.</th>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_team && $result_team->num_rows > 0): ?>
                        <?php $sno = 1; while ($row = $result_team->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" class="team-checkbox" name="selected_employees[]" value="<?php echo htmlspecialchars($row['employ_id']); ?>" <?php echo in_array($row['employ_id'], $selected_employees) ? 'checked' : ''; ?>></td>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['employ_id']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="no-data">✅ All team members have submitted their EOD reports.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="table-header">
                <h3>Missing Leader EOD Reports</h3>
                <div class="dropdown">
                    <button type="button" class="download-btn" onclick="toggleDropdown('leaderExportDropdown')">Download ▾</button>
                    <div id="leaderExportDropdown" class="dropdown-content">
                        <a href="?download=leader_csv&report_date=<?php echo htmlspecialchars($report_date); ?>">CSV</a>
                        <a href="#" onclick="exportTableToPNG('leaderTable', event)">PNG</a>
                        <a href="#" onclick="exportTableToPDF('leaderTable', 'Missing Leader EOD Report', event)">PDF</a>
                    </div>
                </div>
            </div>
           
            <table id="leaderTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAllLeader"></th>
                        <th>S.No.</th>
                        <th>Leader Name</th>
                        <th>Employee ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_leader && $result_leader->num_rows > 0): ?>
                        <?php $sno = 1; while ($row = $result_leader->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" class="leader-checkbox" name="selected_employees[]" value="<?php echo htmlspecialchars($row['employ_id']); ?>" <?php echo in_array($row['employ_id'], $selected_employees) ? 'checked' : ''; ?>></td>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['employ_id']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="no-data">✅ All team leaders have submitted their EOD reports.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </div>

</div>
</div>

    <div id="notificationContainer"></div>
    
        <!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>

    <script>
        // --- [NEW] JAVASCRIPT FOR EXPORTING ---

        function toggleDropdown(id) {
            // Close all dropdowns first
            document.querySelectorAll('.dropdown-content').forEach(d => {
                if(d.id !== id) d.style.display = 'none';
            });
            // Toggle the target dropdown
            const dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Close dropdowns if clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.download-btn')) {
                document.querySelectorAll('.dropdown-content').forEach(d => d.style.display = 'none');
            }
        }

       function exportTableToPNG(tableId, event) {
           event.preventDefault();
           const table = document.getElementById(tableId);
           const reportDate = "<?php echo $report_date; ?>";
           
           // 1. Select all cells in the first column (header and body)
           const firstColumnCells = table.querySelectorAll('th:first-child, td:first-child');
           
           // 2. Temporarily hide the first column before capturing
           firstColumnCells.forEach(cell => {
               cell.style.display = 'none';
           });
       
           // 3. Run html2canvas to capture the table
           html2canvas(table).then(canvas => {
               
               // 4. IMPORTANT: Show the first column again immediately after capture
               firstColumnCells.forEach(cell => {
                   cell.style.display = 'block';
               });
           
               // 5. Create the download link and trigger it
               const link = document.createElement('a');
               link.download = `missing-report-${tableId}-${reportDate}.png`;
               link.href = canvas.toDataURL("image/png");
               link.click();
               
           }).catch(err => {
               // In case of an error, still make sure to show the column again
               console.error("PNG export failed:", err);
               firstColumnCells.forEach(cell => {
                   cell.style.display = 'block';
               });
           });
       }


        function exportTableToPDF(tableId, title, event) {
            event.preventDefault();
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const reportDate = "<?php echo $report_date; ?>";

            doc.text(`${title} (${reportDate})`, 14, 15);
            doc.autoTable({
                html: '#' + tableId,
                startY: 20,
                theme: 'grid',
                headStyles: { fillColor: [41, 128, 185] },
                columns: [ // Select all columns except the first one (checkbox)
                    { header: 'S.No.', dataKey: 1 },
                    { header: 'Name', dataKey: 2 },
                    { header: 'Employee ID', dataKey: 3 },
                ]
            });
            doc.save(`missing-report-${tableId}-${reportDate}.pdf`);
        }
        
        // --- Existing checkbox logic ---
         document.getElementById('selectAllTeam').addEventListener('click', function(event) {
            document.querySelectorAll('.team-checkbox').forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
        document.getElementById('selectAllLeader').addEventListener('click', function(event) {
            document.querySelectorAll('.leader-checkbox').forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
</body>
</html>
<?php
// Close connections
$stmt_team->close();
if ($result_leader) $stmt_leader->close();
$conn->close();
?>