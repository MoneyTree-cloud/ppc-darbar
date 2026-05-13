<?php
include 'config.php';

$date = $_GET['date'] ?? date('Y-m-d');

// Check if data already exists for selected date
$checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM kra_report WHERE DATE(date_time) = ?");
$checkStmt->bind_param("s", $date);
$checkStmt->execute();
$checkResult = $checkStmt->get_result()->fetch_assoc();
$checkStmt->close();

if ($checkResult['count'] == 0) {
    // Insert default rows
    $teamQuery = "SELECT name FROM team_login";
    $teamResult = $conn->query($teamQuery);

    $insertStmt = $conn->prepare("INSERT INTO kra_report (name, calling_target, callyzer_2pm, callyzer_5pm, callyzer_8pm, target_achieved, prospects, no_of_meetings, date_time) VALUES (?, 300, 0, 0, 0, 0, 0, 0, ?)");

    while ($teamRow = $teamResult->fetch_assoc()) {
        $name = $teamRow['name'];
        $insertStmt->bind_param("ss", $name, $date);
        $insertStmt->execute();
    }

    $insertStmt->close();
    $conn->close();

    header("Location: ../edit_kra_report.php?type=success&message=Default report generated successfully for $date");
    exit();
} else {
    $conn->close();
    header("Location: ../edit_kra_report.php?type=processing&message=Report for $date already exists in database!");
    exit();
}
?>
