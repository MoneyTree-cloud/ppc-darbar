<?php
include 'config.php';

$sql = "SELECT domain, COUNT(*) as count FROM all_leads GROUP BY domain ORDER BY count DESC";
$result = $conn->query($sql);

$domains = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $domains[] = $row['domain'];
    $counts[] = (int)$row['count'];
}

echo json_encode([
    'domains' => $domains,
    'counts' => $counts
]);

$conn->close();
?>
