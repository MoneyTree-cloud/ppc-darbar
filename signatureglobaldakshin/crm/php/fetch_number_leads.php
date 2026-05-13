<?php
include 'config.php';

$selectedDomain = $_GET['domain'] ?? 'all';
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$fromDate = $_GET['fromDate'] ?? '';
$toDate = $_GET['toDate'] ?? '';
$limit = 50;
$offset = ($page - 1) * $limit;

// Find duplicate emails and numbers
$duplicateItems = [];

$dupSql = "
    SELECT number 
    FROM number_fill_leads 
    WHERE number <> '' 
    GROUP BY number 
    HAVING COUNT(*) > 1

    UNION

    SELECT email 
    FROM number_fill_leads 
    WHERE email <> '' 
    GROUP BY email 
    HAVING COUNT(*) > 1
";

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

if (!empty($search)) {
    $where[] = "(name LIKE ? OR email LIKE ? OR number LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "sss";
}

// Date range filtering
if (!empty($fromDate) && !empty($toDate)) {
    $where[] = "DATE(created_at) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
    $types .= "ss";
} elseif (!empty($fromDate)) {
    $where[] = "DATE(created_at) >= ?";
    $params[] = $fromDate;
    $types .= "s";
} elseif (!empty($toDate)) {
    $where[] = "DATE(created_at) <= ?";
    $params[] = $toDate;
    $types .= "s";
}

// Build main query
$sql = "SELECT * FROM number_fill_leads";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY created_at DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii";

// Execute main query
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Build table rows
$tableRows = '';
$serialNumber = $offset + 1; // Start numbering from the first record of the current page

while ($row = $result->fetch_assoc()) {
    $isDuplicate = in_array($row['email'], $duplicateItems) || in_array($row['number'], $duplicateItems);
    $duplicateClass = $isDuplicate ? ' duplicate' : '';

    $id = htmlspecialchars($row['id']);

    $tableRows .= '<tr class="' . $duplicateClass . '" 
        data-name="' . htmlspecialchars($row['name']) . '"
        data-email="' . htmlspecialchars($row['email']) . '"
        data-mobile="' . htmlspecialchars($row['number']) . '"
        data-domain="' . htmlspecialchars($row['domain']) . '"
        data-ip="' . htmlspecialchars($row['ip']) . '"
        data-datetime="' . htmlspecialchars($row['created_at']) . '"
        data-id="' . $id . '">';

    // Add Serial Number column
    $tableRows .= '<td>' . $serialNumber++ . '</td>';
    
    $tableRows .= '<td>' . htmlspecialchars($row['name']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['number']) . '</td>';
    $tableRows .= '<td style="display: none;">' . htmlspecialchars($row['email']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['domain']) . '</td>';
    $tableRows .= '<td>' . htmlspecialchars($row['created_at']) . '</td>';
    $tableRows .= '<td><span class="status">Number Fill Lead</span></td>';

    // Delete icon column
    $tableRows .= '<td style="display: flex;">
        <a href="php/export_to_lead.php?id=' . $id . '" class="export-lead" onclick="return confirm(\'Are you sure you want to export (Copy) this lead to main Leads?\')">
            <ion-icon name="cloud-upload-outline" style="font-size: 20px; width: 40px"></ion-icon>
        </a>
        <a href="php/delete/delete_number_lead.php?id=' . $id . '" class="delete-lead" onclick="return confirm(\'Are you sure you want to delete this lead?\')">
            <ion-icon name="trash-outline" style="font-size: 20px; width: 40px"></ion-icon>
        </a>
    </td>';

    $tableRows .= '</tr>';
}

if ($tableRows === '') {
    $tableRows = '<tr><td colspan="7" style="text-align:center; color: red !important;">No records found</td></tr>';
}

// Total records for pagination
$countSql = "SELECT COUNT(*) FROM number_fill_leads";
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
function getCount($conn, $whereClause = '', $params = [], $types = '') {
    $sql = "SELECT COUNT(*) FROM number_fill_leads";
    if (!empty($whereClause)) {
        $sql .= " WHERE " . $whereClause;
    }
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}

$response = [
    'table' => $tableRows,
    'pagination' => $pagination,
    'counts' => [
        'total' => getCount($conn, implode(" AND ", $where), array_slice($params, 0, -2), substr($types, 0, -2))
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>