<?php
include 'config.php';

$term = $_GET['term'] ?? '';
$date = $_GET['date'] ?? date('Y-m-d');

if (!$term) {
    echo json_encode([]);
    exit;
}

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
            k.not_sale,
            k.date_time
        FROM kra_report k
        JOIN team_login t ON k.name = t.name
        WHERE (k.name LIKE CONCAT('%', ?, '%') 
           OR t.employ_id LIKE CONCAT('%', ?, '%')) 
           AND DATE(k.date_time) = ?
        LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $term, $term, $date);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row;
}

header('Content-Type: application/json');
echo json_encode($suggestions);
$conn->close();
?>
