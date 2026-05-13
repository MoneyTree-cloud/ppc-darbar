<?php
include 'config.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="leads_export_' . date('Y-m-d') . '.xls"');

// Get filter parameters
$selectedDomain = $_POST['domain'] ?? 'all';
$selectedStatus = $_POST['status'] ?? 'all';
$search = $_POST['search'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';

// Build WHERE query (same as fetch_leads.php)
$where = [];
$params = [];
$types = "";

$where[] = "(delete_status IS NULL OR delete_status != 'deleted')";
$where[] = "(bot IS NULL OR bot != 'Bot')";

if ($selectedDomain !== 'all') {
    $where[] = "domain = ?";
    $params[] = $selectedDomain;
    $types .= "s";
}
if ($selectedStatus !== 'all') {
    $where[] = "status = ?";
    $params[] = $selectedStatus;
    $types .= "s";
}
if (!empty($search)) {
    $where[] = "(name LIKE ? OR mobile LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "sss";
}

// Date range filtering
if (!empty($fromDate) && !empty($toDate)) {
    $where[] = "DATE(date_time) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
    $types .= "ss";
} elseif (!empty($fromDate)) {
    $where[] = "DATE(date_time) >= ?";
    $params[] = $fromDate;
    $types .= "s";
} elseif (!empty($toDate)) {
    $where[] = "DATE(date_time) <= ?";
    $params[] = $toDate;
    $types .= "s";
}

// Build query
$sql = "SELECT name, mobile, email, domain, date_time, status, remark FROM uploaded_leads";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY date_time DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Excel header
echo "<table border='1'>";
echo "<tr>
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Domain</th>
        <th>Date & Time</th>
        <th>Status</th>
        <th>Remarks</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['domain']) . "</td>";
    echo "<td>" . htmlspecialchars($row['date_time']) . "</td>";
    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
    echo "<td>" . htmlspecialchars($row['remark']) . "</td>";
    echo "</tr>";
}

echo "</table>";
$conn->close();
?>