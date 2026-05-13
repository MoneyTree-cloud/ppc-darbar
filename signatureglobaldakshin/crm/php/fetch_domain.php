<?php
include 'config.php'; // Your database connection

$sql = "SELECT domain_name FROM domains ORDER BY domain_name ASC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $domain = htmlspecialchars($row['domain_name']);
        echo "<option value=\"$domain\">$domain</option>\n";
    }
}

$conn->close();
