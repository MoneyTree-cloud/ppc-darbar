<?php
require_once "php/config.php";
include('php/check_login.php');

// Fetch all distinct employee names for dropdown
$employeeNames = [];
try {
    $sql = "SELECT DISTINCT employ_id FROM team_eod ORDER BY employ_id ASC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $employeeNames[] = $row['employ_id'];
    }
} catch (Exception $e) {
    die("Error fetching employee names: " . $e->getMessage());
}

// Set timezone
date_default_timezone_set('Asia/Kolkata');
// Get parameters from URL
$selectedEmployee = $_GET['employee'] ?? ($employeeNames[0] ?? '');
$fromDate = $_GET['from_date'] ?? date('Y-m-01'); // First day of current month
$toDate = $_GET['to_date'] ?? date('Y-m-d');


// Function to safely output values
function safeOutput($value) {
    return htmlspecialchars($value ?? 'N/A', ENT_QUOTES, 'UTF-8');
}

// Function to check if a client should be counted
function isValidClient($clientName) {
    if (empty($clientName)) return false;
    
    $invalidValues = ['na', 'n/a', '00', '0', 'no', '-'];
    $lowerName = strtolower(trim($clientName));
    
    return !in_array($lowerName, $invalidValues);
}

// Fetch employee's EOD data for date range
$summaryData = [
    'calls' => 0,
    'prospects' => 0,
    'meetings' => 0,
    'total_days' => 0,
    'total_clients' => 0
];
$uniqueDates = [];
$clientData = [];

try {
    // First get all entries for this employee in the date range
    $sql = "SELECT * FROM team_eod 
            WHERE employ_id LIKE ? 
            AND DATE(check_out) BETWEEN ? AND ?
            ORDER BY check_out ASC";
    
    $stmt = $conn->prepare($sql);
    $searchParam = "%$selectedEmployee%";  // Changed from $employeeName to $selectedEmployee
    $stmt->bind_param("sss", $searchParam, $fromDate, $toDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $clientCount = 0;
    
    while ($row = $result->fetch_assoc()) {
        $currentDate = date('Y-m-d', strtotime($row['check_out']));
        
        // Track unique dates for total_days calculation
        if (!in_array($currentDate, $uniqueDates)) {
            $uniqueDates[] = $currentDate;
            $summaryData['total_days'] = count($uniqueDates);
        }
        
        // Sum up the metrics (only once per day)
        if (!isset($dailyAdded[$currentDate])) {
            $summaryData['calls'] += $row['calls'];
            $summaryData['prospects'] += $row['prospects'];
            $summaryData['meetings'] += $row['meetings'];
            $dailyAdded[$currentDate] = true;
        }
        
        // Count valid clients
        if (isValidClient($row['client_name'])) {
            $clientCount++;
            $summaryData['total_clients'] = $clientCount;
            
            $clientData[] = [
                'date' => date('d-m-Y', strtotime($row['check_out'])),
                'name' => $row['client_name'],
                'mobile' => $row['mobile'],
                'project' => $row['project'],
                'unit' => $row['unit'],
                'size' => $row['size'],
                'cost' => $row['total_cost'],
                'inventory' => $row['inventory_status']
            ];
        }
    }
    
    // If no data found, show message
    if ($summaryData['total_days'] === 0) {
        // die("<h2>No EOD data found for $selectedEmployee between " . 
        //     date('d-m-Y', strtotime($fromDate)) . " and " . 
        //     date('d-m-Y', strtotime($toDate)) . "</h2>");
        // header("Location: eod_date_details.php?type=error&message=No data found for $fromDate to $toDate dates, Please select the valid dates&employee=$selectedEmployee");
        // exit();
        
    }
    
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EOD Summary - <?= safeOutput($selectedEmployee) ?></title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:#fff;
      color: rgb(224, 250, 255);
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
        max-width: 100%;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    h2 {
        color: rgb(199, 236, 33);
        border-bottom: 2px solid goldenrod;
        padding-bottom: 10px;
        margin: 0px;
        text-align: center;
    }
    
    #domainHeading{
        text-align: center;
        margin: 0;
        color: gold;
    }
    .date-range {
        margin: 15px 0;
        padding: 10px;
        background: rgba(0,0,0,0.1);
        border-radius: 5px;
        text-align: center;
    }
    .expected_sale{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        min-width: 100%;
    }
    .summary-table{
        max-width: 700px;
    }
    .summary-table, .client-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    .summary-table th, .summary-table td,
    .client-table th, .client-table td {
      padding: 10px;
      border: 1px solid #fff;
      text-align: left;
    }
    .highlight {
      background-color: rgba(32, 166, 255, 0.73);
      padding: 3px 6px;
      border-radius: 4px;
      display: inline-block;
    }
    .client-wrapper {
      overflow-x: auto;
    }
    .client-table {
      min-width: 350px;
      background-color: rgba(255, 255, 255, 0.02);
      margin-bottom: 30px;
    }
    .form-container {
      display: flex;
      flex-direction: column;
      width: 100%;
      max-width: 1200px;
      position: relative;
      margin: 0;
      background: rgb(0, 85, 68);
      box-shadow: 5px 5px 10px #444;
      padding: 20px;
    }
    .close {
      text-align: right;
      font-size: 24px;
      cursor: pointer;
      margin-bottom: 10px;
      left: 20px;
      border-radius: 50%;
      background: rgb(0, 85, 68);
      width: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    h3 {
      margin-bottom: 10px;
    }
    .date-filter {
      margin: 20px 0;
      padding: 15px;
      background: rgba(0,0,0,0.2);
      border-radius: 5px;
    }
    .form-group {
        margin-bottom: 10px;
        gap: 20px;
        
    }
    .form-group label{
      position: relative;
      all: unset;
    }
    label {
        display: inline-block;
        width: 80px;
        color: gold;
    }
    select, input {
        padding: 8px 12px;
        border-radius: 4px;
        border: none;
        background: white;
        color: #333;
    }
    select {
        min-width: 200px;
    }
    .date-filter form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
    }
    .date-filter input, .date-filter button {
      padding: 8px 12px;
      border-radius: 4px;
      border: none;
    }
    .date-filter button {
      background: goldenrod;
      color: #000;
      cursor: pointer;
    }

    .dropdown{
      position: absolute;
      top: 20px;right: 20px;
    }
    .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: #000;
}

.export-btn {
    background: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
}

.export-btn:hover {
    background: #45a049;
}
  </style>
  
  <?php include('resource.php'); ?>
  
</head>
<body>

  <div class="form-container">
    <h2>EOD Summary Report</h2>
    <a class="close" href="/eod_report.php">
      <ion-icon name="arrow-back-circle-outline"></ion-icon>
    </a>
    
    <!-- Add this to your form in the HTML section -->
<div class="date-filter">
    <form method="get" action="">
        <div class="form-group">
            <label for="employee">Employee:</label>
            <select name="employee" id="employee" required>
                <?php foreach ($employeeNames as $name): ?>
                    <option value="<?= safeOutput($name) ?>" 
                        <?= ($name === $selectedEmployee) ? 'selected' : '' ?>>
                        <?= safeOutput($name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="from_date">From:</label>
            <input type="date" name="from_date" value="<?= safeOutput($fromDate) ?>" required>
        </div>
        <div class="form-group">
            <label for="to_date">To:</label>
            <input type="date" name="to_date" value="<?= safeOutput($toDate) ?>" required>
        </div>
        <button type="submit">Generate Report</button>
        
    </form>
</div>

<div class="dropdown" style="display: block;">
    <button onclick="toggleExportDropdown()" class="export-btn" 
            style="background: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">
        Export Report <ion-icon name="chevron-down-outline"></ion-icon>
    </button>
    <div id="exportDropdown" class="dropdown-content" 
         style="display: none; position: absolute; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;">
        <a href="#" onclick="exportToPNG()">PNG</a>
        <a href="#" onclick="exportToPDF()">PDF</a>
        <a href="#" onclick="exportToExcel()">Excel</a>
    </div>
</div>
    
    <h3 id="domainHeading">Summary for <?= safeOutput($selectedEmployee) ?></h3>
    <div class="date-range">
      From <?= date('d-m-Y', strtotime($fromDate)) ?> to <?= date('d-m-Y', strtotime($toDate)) ?>
    </div>
    
    <div class="container">
        <table class="summary-table">
          <tr><th>Total Days</th><td><?= safeOutput($summaryData['total_days']) ?></td></tr>
          <tr><th>Total Calls</th><td><?= safeOutput($summaryData['calls']) ?></td></tr>
          <tr><th>Total Prospects</th><td><?= safeOutput($summaryData['prospects']) ?></td></tr>
          <tr><th>Total Meetings</th><td><?= safeOutput($summaryData['meetings']) ?></td></tr>
          <tr><th>Total Expected Sale</th><td><?= safeOutput($summaryData['total_clients']) ?></td></tr>
        </table>

        <?php if (!empty($clientData)): ?>
            <h2>Client Details</h2>
            <div class="expected_sale">
                <?php foreach ($clientData as $client): ?>
                <div class="client-wrapper">
                    <table class="client-table">
                        <tr><th colspan="2">Client from <?= safeOutput($client['date']) ?></th></tr>
                        <tr><th>Client Name</th><td><?= safeOutput($client['name']) ?></td></tr>
                        <tr><th>Mobile</th><td><?= safeOutput($client['mobile']) ?></td></tr>
                        <tr><th>Project</th><td><?= safeOutput($client['project']) ?></td></tr>
                        <tr><th>Unit</th><td><?= safeOutput($client['unit']) ?></td></tr>
                        <tr><th>Size</th><td><?= safeOutput($client['size']) ?></td></tr>
                        <tr><th>Total Cost</th><td><?= safeOutput($client['cost']) ?></td></tr>
                        <tr><th>Inventory Hold</th>
                            <td>
                                <span class="highlight">
                                    <?= safeOutput(ucfirst($client['inventory'])) ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h3>No client data available for this period</h3>
        <?php endif; ?>
    </div>
  </div>

      <div id="notificationContainer"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    // Initialize jsPDF
    const { jsPDF } = window.jspdf;
    
    // Toggle export dropdown
    function toggleExportDropdown() {
        const dropdown = document.getElementById('exportDropdown');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        event.stopPropagation(); // Prevent immediate close
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.getElementById('exportDropdown').style.display = 'none';
        }
    });

    // Export functions
    function exportToPNG() {
        const dropdown = document.getElementById('exportDropdown');
        dropdown.style.display = 'none';
        
        // Hide elements you don't want in the export
        document.querySelector('.date-filter').style.display = 'none';
        document.querySelector('.close').style.visibility = 'hidden';
        document.querySelector('.dropdown').style.display = 'none';
        
        html2canvas(document.querySelector('.form-container')).then(canvas => {
            const link = document.createElement('a');
            link.download = `EOD-Report-<?= $selectedEmployee ?>-<?= $fromDate ?>-to-<?= $toDate ?>.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            // Restore visibility
            document.querySelector('.date-filter').style.display = 'block';
            document.querySelector('.close').style.visibility = 'visible';
            document.querySelector('.dropdown').style.display = 'block';
        });
    }

    function exportToPDF() {
        const dropdown = document.getElementById('exportDropdown');
        dropdown.style.display = 'none';
        
        // Hide elements you don't want in the export
        document.querySelector('.date-filter').style.display = 'none';
        document.querySelector('.close').style.visibility = 'hidden';
        document.querySelector('.dropdown').style.display = 'none';
        
        html2canvas(document.querySelector('.form-container')).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save(`EOD-Report-<?= $selectedEmployee ?>-<?= $fromDate ?>-to-<?= $toDate ?>.pdf`);
            
            // Restore visibility
            document.querySelector('.date-filter').style.display = 'block';
            document.querySelector('.close').style.visibility = 'visible';
            document.querySelector('.dropdown').style.display = 'block';
        });
    }

    function exportToExcel() {
        const dropdown = document.getElementById('exportDropdown');
        dropdown.style.display = 'none';
        
        // Create a temporary table with just the data you want to export
        const tempTable = document.createElement('table');
        tempTable.innerHTML = `
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Total Days</th>
                <th>Total Calls</th>
                <th>Total Prospects</th>
                <th>Total Meetings</th>
                <th>Total Expected Sales</th>
            </tr>
            <tr>
                <td><?= $selectedEmployee ?></td>
                <td><?= date('d-m-Y', strtotime($fromDate)) ?> to <?= date('d-m-Y', strtotime($toDate)) ?></td>
                <td><?= $summaryData['total_days'] ?></td>
                <td><?= $summaryData['calls'] ?></td>
                <td><?= $summaryData['prospects'] ?></td>
                <td><?= $summaryData['meetings'] ?></td>
                <td><?= $summaryData['total_clients'] ?></td>
            </tr>
        `;
        
        // Add client data if available
        if (<?= !empty($clientData) ? 'true' : 'false' ?>) {
            tempTable.innerHTML += `
                <tr><td colspan="7"><strong>Client Details</strong></td></tr>
                <tr>
                    <th>Date</th>
                    <th>Client Name</th>
                    <th>Mobile</th>
                    <th>Project</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Total Cost</th>
                </tr>
            `;
            
            <?php foreach ($clientData as $client): ?>
                tempTable.innerHTML += `
                    <tr>
                        <td><?= $client['date'] ?></td>
                        <td><?= $client['name'] ?></td>
                        <td><?= $client['mobile'] ?></td>
                        <td><?= $client['project'] ?></td>
                        <td><?= $client['unit'] ?></td>
                        <td><?= $client['size'] ?></td>
                        <td><?= $client['cost'] ?></td>
                    </tr>
                `;
            <?php endforeach; ?>
        }
        
        const html = tempTable.outerHTML;
        const url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
        const link = document.createElement('a');
        link.download = `EOD-Report-<?= $selectedEmployee ?>-<?= $fromDate ?>-to-<?= $toDate ?>.xls`;
        link.href = url;
        link.click();
    }
</script>



<!-- scripts -->
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>
  

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>