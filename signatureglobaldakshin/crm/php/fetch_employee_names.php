<?php
include 'config.php';

$names = [];

$result = $conn->query("SELECT DISTINCT name FROM kra_report ORDER BY name ASC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $names[] = ['name' => $row['name']];
    }
}

header('Content-Type: application/json');
echo json_encode($names);
$conn->close();
