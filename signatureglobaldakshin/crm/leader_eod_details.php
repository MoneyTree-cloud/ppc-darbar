<?php
require_once "php/config.php";
include('php/check_login.php');

// Get parameters from URL
$employeeName = $_GET['name'] ?? '';
$reportDate = $_GET['date'] ?? date('Y-m-d');

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Function to safely output values
function safeOutput($value) {
    return htmlspecialchars($value ?? 'N/A', ENT_QUOTES, 'UTF-8');
}

// Fetch employee's EOD data
$eodData = [];
$clientData = [];
$totalCalls = 0;
$totalProspects = 0;
$totalMeetings = 0;
$checkOutTime = '';

try {
    // First get all entries for this employee on this date
    $sql = "SELECT * FROM team_leader_eod 
            WHERE employ_id LIKE ? AND DATE(check_out) = ?
            ORDER BY id ASC";
    
    $stmt = $conn->prepare($sql);
    $searchParam = "%$employeeName%";
    $stmt->bind_param("ss", $searchParam, $reportDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $clientCount = 0;
    
    while ($row = $result->fetch_assoc()) {
        // For the first row, get the summary data
        if (empty($eodData)) {
            $eodData = [
                'calls' => $row['calls'],
                'prospects' => $row['prospects'],
                'total_team_hot_prospect' => $row['total_team_hot_prospect'],
                'total_team_very_hot_prospect' => $row['total_team_very_hot_prospect'],
                'meetings' => $row['meetings'],
                'no_of_ob' => $row['no_of_ob'],
                'project_training' => $row['project_training'],
                'check_out' => date("h:i:s A", strtotime($row['check_out']))
            ];
        }
        
        // Collect client data if available
        if (!empty($row['client_name']) && $row['client_name'] !== 'Na' && $row['client_name'] !== 'N/A') {
            $clientCount++;
            $clientData[] = [
                'count' => $clientCount,
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
    if (empty($eodData)) {
        die("<h2>No EOD data found for $employeeName on " . date('d-m-Y', strtotime($reportDate)) . "</h2>");
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
  <title>EOD Details - <?= safeOutput($employeeName) ?></title>
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
  </style>
  
  <?php include('resource.php'); ?>
</head>
<body>

  <div class="form-container">
    <h2>EOD Details</h2>
    <div class="close" onclick="window.history.back()">
      <ion-icon name="arrow-back-circle-outline"></ion-icon>
    </div>
    <h3 id="domainHeading">Submission By <?= safeOutput($employeeName) ?> on <?= date('d-m-Y', strtotime($reportDate)) ?></h3>
    
    <div class="container">
        <table class="summary-table">
          <tr><th>Total Calls</th><td><?= safeOutput($eodData['calls']) ?></td></tr>
          <tr><th>Prospects</th><td><?= safeOutput($eodData['prospects']) ?></td></tr>
          <tr><th>Team Hot Prospects</th><td><?= safeOutput($eodData['total_team_hot_prospect']) ?></td></tr>
          <tr><th>Team V. Hot Prospects</th><td><?= safeOutput($eodData['total_team_very_hot_prospect']) ?></td></tr>
          <tr><th>Meetings</th><td><?= safeOutput($eodData['meetings']) ?></td></tr>
          <tr><th>No. Of OB</th><td><?= safeOutput($eodData['no_of_ob']) ?></td></tr>
          <tr><th>Project Training</th><td><?= safeOutput($eodData['project_training']) ?></td></tr>
          <tr><th>Check Out Time</th><td><?= safeOutput($eodData['check_out']) ?></td></tr>
        </table>

        <?php if (!empty($clientData)): ?>
            <h2>Expected Sales Details</h2>
            <div class="expected_sale">
                <?php foreach ($clientData as $client): ?>
                <div class="client-wrapper">
                    <table class="client-table">
                        <tr><th colspan="2">Client #<?= $client['count'] ?></th></tr>
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
            <h3>No client data available for this EOD</h3>
        <?php endif; ?>
    </div>
  </div>

  <!-- ====== ionicons ======= -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>