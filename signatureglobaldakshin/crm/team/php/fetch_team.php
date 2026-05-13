<?php
session_start();
include 'config.php';

// Check if team_name is set in session
if (!isset($_SESSION['team_name'])) {
    echo '<tr><td colspan="6">Unauthorized access</td></tr>';
    exit;
}

$teamName = $_SESSION['team_name'];

$sql = "SELECT * FROM team_login WHERE team_name = ? ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teamName);
$stmt->execute();
$result = $stmt->get_result();

$rows = '';
while ($row = $result->fetch_assoc()) {
    $rows .= '<tr>';
    $rows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['employ_id']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['contact']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['email']) . '</td>';
    $rows .= '<td>' . htmlspecialchars($row['rights']) . '</td>';
    $rows .= '</tr>';
}

echo $rows;
$stmt->close();
$conn->close();
