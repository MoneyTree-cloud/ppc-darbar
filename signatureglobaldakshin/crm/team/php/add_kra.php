<?php
include 'config.php';

$name = $_POST['name'] ?? '';
$calling = $_POST['totalCalling'] ?? '';
$pm2 = isset($_POST['callyzer_2pm']) ? (int)$_POST['callyzer_2pm'] : 0;
$pm5_raw = isset($_POST['callyzer_5pm']) ? (int)$_POST['callyzer_5pm'] : 0;
$pm8_raw = isset($_POST['callyzer_8pm']) ? (int)$_POST['callyzer_8pm'] : 0;
$not_sale = $_POST['not_sale'] ?? '';

// Adjust logic as per user input order
if ($pm8_raw > 0) {
    $pm5 = $pm5_raw;
    $pm8 = max(0, $pm8_raw - $pm2 - $pm5_raw);
} else {
    $pm5 = max(0, $pm5_raw - $pm2);
    $pm8 = 0;
}

$prospect = $_POST['prospect'] ?? '';
$meetings = $_POST['meetings'] ?? '';
$id = $_POST['id'] ?? '';

// Calculate target achieved
$totalCallyzer = $pm2 + $pm5 + $pm8;
$target_achieved = ($calling > 0) ? round(($totalCallyzer / $calling) * 100) : 0;

// Insert or Update into KRA table
if (!empty($id)) {
    $stmt = $conn->prepare("UPDATE kra SET name = ?, calling_target = ?, callyzer_2pm = ?, callyzer_5pm = ?, callyzer_8pm = ?, target_achieved = ?, prospects = ?, no_of_meetings = ?, not_sale = ? WHERE id = ?");
    $stmt->bind_param("siiiiiiiii", $name, $calling, $pm2, $pm5, $pm8, $target_achieved, $prospect, $meetings, $not_sale, $id);
    $success = $stmt->execute();
    $stmt->close();
} else {
    $stmt = $conn->prepare("INSERT INTO kra (name, calling_target, callyzer_2pm, callyzer_5pm, callyzer_8pm, target_achieved, prospects, no_of_meetings, not_sale) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiiiiiii", $name, $calling, $pm2, $pm5, $pm8, $target_achieved, $prospect, $meetings, $not_sale);
    $success = $stmt->execute();
    $stmt->close();
}

// ✅ Sync KRA to KRA_REPORT table
if ($success) {
    $today = date('Y-m-d');
    $result = $conn->query("SELECT * FROM kra");

    while ($kra = $result->fetch_assoc()) {
        $n = $kra['name'];
        $ct = $kra['calling_target'];
        $c2 = $kra['callyzer_2pm'];
        $c5 = $kra['callyzer_5pm'];
        $c8 = $kra['callyzer_8pm'];
        $achieved = $kra['target_achieved'];
        $prospects = $kra['prospects'];
        $meet = $kra['no_of_meetings'];
        $no_sale = $kra['not_sale'];

        // Check if entry for that name already exists for today
        $stmtCheck = $conn->prepare("SELECT id FROM kra_report WHERE name = ? AND DATE(date_time) = ?");
        $stmtCheck->bind_param("ss", $n, $today);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $stmtCheck->bind_result($reportId);
            $stmtCheck->fetch();
            $stmtCheck->close();

            // Update existing record
            $stmtUpdate = $conn->prepare("UPDATE kra_report SET calling_target = ?, callyzer_2pm = ?, callyzer_5pm = ?, callyzer_8pm = ?, target_achieved = ?, prospects = ?, no_of_meetings = ?, not_sale = ?, date_time = NOW() WHERE id = ?");
            $stmtUpdate->bind_param("iiiiiiiii", $ct, $c2, $c5, $c8, $achieved, $prospects, $meet, $no_sale, $reportId);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            $stmtInsert = $conn->prepare("INSERT INTO kra_report (name, calling_target, callyzer_2pm, callyzer_5pm, callyzer_8pm, target_achieved, prospects, no_of_meetings, not_sale, date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmtInsert->bind_param("siiiiiiii", $n, $ct, $c2, $c5, $c8, $achieved, $prospects, $meet, $no_sale);
            $stmtInsert->execute();
            $stmtInsert->close();
        }
    }
}

$conn->close();

// Redirect after insert/update
if ($success) {
    $msg = !empty($id) ? 'Record updated successfully' : 'Record added successfully';
    header("Location: ../kra.php?type=success&message=" . urlencode($msg));
} else {
    $msg = !empty($id) ? 'Failed to update record' : 'Failed to insert record';
    header("Location: ../kra.php?type=error&message=" . urlencode($msg));
}
?>
