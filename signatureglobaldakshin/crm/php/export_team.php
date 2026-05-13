<?php
include 'config.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="team_members_export_' . date('Y-m-d') . '.xls"');

// Fetch team members data
$sql = "SELECT name, employ_id, contact, email, team_name, rights FROM team_login ORDER BY name";
$result = $conn->query($sql);

// Excel header
echo "<table border='1'>";
echo "<tr>
        <th>Name</th>
        <th>Employ ID</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Team Name</th>
        <th>Access Rights</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['employ_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['team_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['rights']) . "</td>";
    echo "</tr>";
}

echo "</table>";
$conn->close();
?>