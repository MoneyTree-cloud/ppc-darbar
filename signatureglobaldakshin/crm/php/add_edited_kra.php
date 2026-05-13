<?php
include 'config.php';

date_default_timezone_set('Asia/Kolkata');

// Get form data
$id = $_POST['id'] ?? '';
$name = trim($_POST['name']);
$date = $_POST['date'] ?? date('Y-m-d');

$calling_target = isset($_POST['totalCalling']) ? (int)$_POST['totalCalling'] : 0;
$prospect = isset($_POST['prospect']) ? (int)$_POST['prospect'] : 0;
$meetings = isset($_POST['meetings']) ? (int)$_POST['meetings'] : 0;

// Compare submitted date with today's date
$today = date('Y-m-d');

    $pm2 = isset($_POST['callyzer_2pm']) ? (int)$_POST['callyzer_2pm'] : 0;
    $pm5_raw = isset($_POST['callyzer_5pm']) ? (int)$_POST['callyzer_5pm'] : 0;
    $pm8_raw = isset($_POST['callyzer_8pm']) ? (int)$_POST['callyzer_8pm'] : 0;

    if ($pm8_raw > 0) {
        $callyzer_5pm = $pm5_raw;
        $callyzer_8pm = max(0, $pm8_raw - $pm2 - $pm5_raw);
    }

    else {
        $callyzer_5pm = max(0, $pm5_raw - $pm2);
        $callyzer_8pm = 0;
    }
    $callyzer_2pm = $pm2;

    $stmt = $conn->prepare("SELECT callyzer_2pm, callyzer_5pm, callyzer_8pm FROM kra_report WHERE id = ?");
    $stmt->bind_param("i", $id); // assuming $id is integer
    $stmt->execute();
    $result_callyzer = $stmt->get_result();

    if ($result_callyzer->num_rows > 0) {
        $row = $result_callyzer->fetch_assoc();
        $old_2pm = $row["callyzer_2pm"];
        $old_5pm = $row["callyzer_5pm"];
        $old_8pm = $row["callyzer_8pm"];
    }

    if($old_2pm > 0 & $old_5pm > 0 & $old_8pm > 0){
        $callyzer_2pm = $pm2;
        $callyzer_5pm = $pm5_raw;
        $callyzer_8pm = $pm8_raw;
    }

    if($old_2pm > 0 & $old_5pm > 0 & $old_8pm == 0){
        $callyzer_2pm = $pm2;
        $callyzer_5pm = $pm5_raw;
        $callyzer_8pm = max(0, $pm8_raw - $callyzer_2pm - $callyzer_5pm);
    }

    if($old_2pm > 0 & $old_5pm == 0 & $old_8pm > 0){
        $callyzer_2pm = $pm2;
        $callyzer_5pm = max(0, $pm5_raw - $pm2);
        $callyzer_8pm = $pm8_raw;
    }

    if($old_2pm == 0 & $old_5pm > 0 & $old_8pm > 0){
        $callyzer_2pm = $pm2;
        $callyzer_5pm = $pm5_raw;
        $callyzer_8pm = $pm8_raw;
    }


// Calculate total calls and target achieved
$total_calls = $callyzer_2pm + $callyzer_5pm + $callyzer_8pm;
$target_achieved = $calling_target > 0 ? round(($total_calls / $calling_target) * 100, 2) : 0;

// Check if entry exists for name + date
$check = $conn->prepare("SELECT id FROM kra_report WHERE name = ? AND DATE(date_time) = ?");
$check->bind_param("ss", $name, $date);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // UPDATE
    $update = $conn->prepare("UPDATE kra_report SET calling_target = ?, callyzer_2pm = ?, callyzer_5pm = ?, callyzer_8pm = ?, target_achieved = ?, prospects = ?, no_of_meetings = ? WHERE name = ? AND DATE(date_time) = ?");
    $update->bind_param("iiiiiiiss", $calling_target, $callyzer_2pm, $callyzer_5pm, $callyzer_8pm, $target_achieved, $prospect, $meetings, $name, $date);
    $update->execute();
    $update->close();

    $check->close();
    $conn->close();
    // Redirect back or send response
    $redirectDate = $_POST['date'] ?? date('Y-m-d');  // Preserve the submitted date
    header("Location: ../edit_kra_report.php?type=success&message=" . urlencode($name . "'s data updated Successfully") . "&date=$redirectDate");
    exit();
} else {
    // INSERT
    $insert = $conn->prepare("INSERT INTO kra_report (name, calling_target, callyzer_2pm, callyzer_5pm, callyzer_8pm, target_achieved, prospects, no_of_meetings, date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $fullDateTime = $date . ' ' . date('H:i:s'); // Combine date + current time
    $insert->bind_param("siiiiiiis", $name, $calling_target, $callyzer_2pm, $callyzer_5pm, $callyzer_8pm, $target_achieved, $prospect, $meetings, $fullDateTime);
    $insert->execute();
    $insert->close();

    $check->close();
    $conn->close();
    // Redirect back or send response
    header("Location: ../edit_kra_report.php?type=success&message=$name 's data Inserted for fullDateTime");
    exit;
}


?>
