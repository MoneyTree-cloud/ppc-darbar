<?php
include 'config.php';

$date = $_GET['date'] ?? date('Y-m-d');

$sql = "SELECT 
            SUM(calling_target) as totalTarget,
            SUM(callyzer_2pm + callyzer_5pm + callyzer_8pm) as totalCallyzer 
        FROM kra_report 
        WHERE DATE(date_time) = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'totalTarget' => (int)$result['totalTarget'],
    'totalCallyzer' => (int)$result['totalCallyzer']
]);
?>
