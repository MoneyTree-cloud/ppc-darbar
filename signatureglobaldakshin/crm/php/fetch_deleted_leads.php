<?php
include 'config.php';

$selectedDomain = $_GET['domain'] ?? 'all';
$selectedStatus = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
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

// Fetch Leads
$sql = "SELECT * FROM all_leads";
$where[] = "delete_status = 'deleted'"; // Add this condition

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY date_time DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii";


$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$tableRows = '';
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
        data-read_status="' . htmlspecialchars($row['read_status']) . '"
        data-id="' . $id . '"
        data-status="' . htmlspecialchars($row['status']) . '">';

    // $tableRows .= '<td><input type="checkbox" class="rowCheckbox" data-name="' . htmlspecialchars($row['id']) . '" /></td>';
    $tableRows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['mobile']) . '</td>';
    $tableRows .= '<td style="display: none;">' . htmlspecialchars($row['email']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['domain']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['date_time']) . '</td>';
    $tableRows .= '<td><span class="status ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>';

    // ✅ Delete icon column
    $tableRows .= '<td>
        <a href="php/delete/permanent_delete_lead.php?id=' . $id . '" class="delete-lead" onclick="return confirm(\'Are you sure you want to delete this lead?\')">
            <ion-icon name="trash-outline" style="font-size: 20px;"></ion-icon>
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
    $countParams = array_slice($params, 0, count($params) - 2);
    $countTypes = substr($types, 0, strlen($types) - 2);
    if (!empty($countParams)) {
        $countStmt->bind_param($countTypes, ...$countParams);
    }
}
$countStmt->execute();
$countStmt->store_result();
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
    $sql = $status ? "SELECT COUNT(*) FROM all_leads WHERE status = ?" : "SELECT COUNT(*) FROM all_leads";
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
    $stmt = $conn->prepare("SELECT COUNT(*) FROM all_leads WHERE read_status = 'unread'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($unreadCount);
    $stmt->fetch();
    $stmt->close();
    return $unreadCount;
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
        'unread' => getUnreadCount($conn)
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
