<?php
include 'config.php';

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("SELECT k.id, k.name, t.employ_id, k.calling_target, k.callyzer_2pm, k.callyzer_5pm, k.callyzer_8pm, k.target_achieved, k.prospects, k.no_of_meetings, k.not_sale 
                        FROM kra k
                        JOIN team_login t ON k.name = t.name
                        WHERE k.name LIKE CONCAT('%', ?, '%') OR t.employ_id LIKE CONCAT('%', ?, '%') 
                        LIMIT 10");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
  $suggestions[] = $row;
}

echo json_encode($suggestions);
$conn->close();
