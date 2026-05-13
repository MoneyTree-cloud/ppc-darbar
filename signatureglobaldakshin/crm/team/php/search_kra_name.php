<?php
session_start();
include 'config.php';

$term = $_GET['term'] ?? '';
$teamName = $_SESSION['team_name'] ?? '';

if (!$term || !$teamName) {
    echo json_encode([]);
    exit;
}

// Search within the same team only
$sql = "SELECT 
            k.id, 
            k.name, 
            t.employ_id, 
            k.calling_target, 
            k.callyzer_2pm, 
            k.callyzer_5pm, 
            k.callyzer_8pm, 
            k.target_achieved, 
            k.prospects, 
            k.no_of_meetings,
            k.not_sale
        FROM kra k
        JOIN team_login t ON k.name = t.name
        WHERE t.team_name = ?
          AND (k.name LIKE CONCAT('%', ?, '%') OR t.employ_id LIKE CONCAT('%', ?, '%'))
        LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $teamName, $term, $term);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row;
}

header('Content-Type: application/json');
echo json_encode($suggestions);
$conn->close();
