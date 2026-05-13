<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';
// Get all filter parameters
$selectedDomain = $_GET['domain'] ?? 'all';
$selectedStatus = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$fromDate = $_GET['fromDate'] ?? '';
$toDate = $_GET['toDate'] ?? '';
$limit = 50;
$offset = ($page - 1) * $limit;

// Find duplicate emails and phones
$duplicateItems = [];
$dupSql = "SELECT mobile FROM all_leads GROUP BY mobile HAVING COUNT(*) > 1 
           UNION 
           SELECT email FROM all_leads GROUP BY email HAVING COUNT(*) > 1";
$dupResult = $conn->query($dupSql);
while ($row = $dupResult->fetch_row()) {
    $duplicateItems[] = $row[0];
}

// Build WHERE query
$where = [];
$params = [];
$types = "";

// Standard filters
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

// Fetch Leads
$sql = "SELECT * FROM all_leads";

$where[] = "(delete_status IS NULL OR delete_status != 'deleted')";
$where[] = "(bot IS NULL OR bot != 'Bot')";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY date_time DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii";

// Execute main query
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();


$tableRows = '';
$serialNumber = $offset + 1; // Start numbering from the first record of the current page
while ($row = $result->fetch_assoc()) {
    $isDuplicate = in_array($row['email'], $duplicateItems) || in_array($row['mobile'], $duplicateItems);
    $duplicateClass = $isDuplicate ? ' duplicate' : '';
    $statusClass = strtolower(str_replace(' ', '_', $row['status']));

    $id = htmlspecialchars($row['id']);

    $tableRows .= '<tr class="' . htmlspecialchars($row['read_status']) . $duplicateClass . '" 
        data-name="' . htmlspecialchars($row['name']) . '"
        data-email="' . htmlspecialchars($row['email']) . '"
        data-mobile="' . htmlspecialchars($row['mobile']) . '"
        data-domain="' . htmlspecialchars($row['domain']) . '"
        data-remark="' . htmlspecialchars($row['remark']) . '"
        data-datetime="' . htmlspecialchars($row['date_time']) . '"
        data-updatetime="' . htmlspecialchars($row['updated_on']) . '"
        data-read_status="' . htmlspecialchars($row['read_status']) . '"
        data-id="' . $id . '"
        data-status="' . htmlspecialchars($row['status']) . '">';

    // Add Serial Number column
    $tableRows .= '<td>' . $serialNumber++ . '</td>';
    
    $tableRows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['mobile']) . '</td>';
    $tableRows .= '<td style="display: none;">' . htmlspecialchars($row['email']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['domain']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['date_time']) . '</td>';
    $tableRows .= '<td><span class="status ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>';

    // Delete icon column
    $tableRows .= '<td>
        <a href="php/delete/delete_lead.php?id=' . $id . '" class="delete-lead" onclick="return confirm(\'Are you sure you want to delete this lead?\')">
            <ion-icon name="trash-outline" style="font-size: 20px; width: 40px"></ion-icon>
        </a>
    </td>';

    $tableRows .= '</tr>';
}


if ($tableRows === '') {
    $tableRows = '<tr><td colspan="6" style="text-align:center; color: red !important;">No records found</td></tr>';
}

// Total records for pagination
$countSql = "SELECT COUNT(*) FROM all_leads";
if (!empty($where)) {
    $countSql .= " WHERE " . implode(" AND ", $where);
}
$countStmt = $conn->prepare($countSql);
if (!empty($params)) {
    // Remove the last two parameters (LIMIT values)
    $countParams = array_slice($params, 0, -2);
    $countTypes = substr($types, 0, -2);
    if (!empty($countParams)) {
        $countStmt->bind_param($countTypes, ...$countParams);
    }
}
$countStmt->execute();
$countStmt->bind_result($totalRecords);
$countStmt->fetch();
$countStmt->close();

$totalPages = ceil($totalRecords / $limit);

// Smart Pagination
$pagination = '';
if ($totalPages > 1) {
    if ($page > 1) {
        $pagination .= '<button onclick="changePage(' . ($page - 1) . ')">« Prev</button>';
    }

    if ($page > 3) $pagination .= '<button disabled>...</button>';
    for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
        $active = ($i == $page) ? 'class="active"' : '';
        $pagination .= '<button ' . $active . ' onclick="changePage(' . $i . ')">' . $i . '</button>';
    }
    if ($page < $totalPages - 2) $pagination .= '<button disabled>...</button>';

    if ($page < $totalPages) {
        $pagination .= '<button onclick="changePage(' . ($page + 1) . ')">Next »</button>';
    }
}

// Count functions
function getCount($conn, $status = null) {
    $sql = $status ? "SELECT COUNT(*) FROM all_leads WHERE status = ? AND delete_status != 'deleted'" : "SELECT COUNT(*) FROM all_leads WHERE delete_status != 'deleted' AND bot != 'Bot'";
    $stmt = $conn->prepare($sql);
    if ($status) $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}
function getUnreadCount($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM all_leads WHERE read_status = 'unread' AND delete_status != 'deleted' AND bot != 'Bot'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($unreadCount);
    $stmt->fetch();
    $stmt->close();
    return $unreadCount;
}

function getRawLeadsCounts($conn){
    $sql_stmt = $conn->prepare("SELECT COUNT(*) FROM number_fill_leads");
    $sql_stmt->execute();
    $sql_stmt->store_result();
    $sql_stmt->bind_result($raw_leads);
    $sql_stmt->fetch();
    $sql_stmt->close();
    return $raw_leads;
}

function getDomailVisitCounts($conn){
    $domain_stmt = $conn->prepare("SELECT COUNT(*) FROM ip_logs");
    $domain_stmt->execute();
    $domain_stmt->store_result();
    $domain_stmt->bind_result($ip_count);
    $domain_stmt->fetch();
    $domain_stmt->close();
    return $ip_count;
}

$response = [
    'table' => $tableRows,
    'pagination' => $pagination,
    'counts' => [
        'total' => getCount($conn),
        'interested' => getCount($conn, 'interested'),
        'not_interested' => getCount($conn, 'not_interested'),
        'hot' => getCount($conn, 'hot'),
        'very_hot' => getCount($conn, 'very_hot'),
        'dumped' => getCount($conn, 'dumped'),
        'meeting_booked' => getCount($conn, 'meeting_booked'),
        'site_visited' => getCount($conn, 'site_visited'),
        'unread' => getUnreadCount($conn),
        'raw_leads' => getRawLeadsCounts($conn),
        'ip_count' => getDomailVisitCounts($conn)
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
