<?php
// Set headers
header('Content-Type: application/json');
include('config.php'); // Main DB Connection

// Set the default timezone for the script
date_default_timezone_set('Asia/Kolkata');

// 1. Get parameters from the request
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 50; // Number of records per page
$offset = ($page - 1) * $limit;

$domain = 'm3mjacob.com';
$search = $_GET['search'] ?? '';
$fromDate = $_GET['fromDate'] ?? '';
$toDate = $_GET['toDate'] ?? '';

// 2. Build the WHERE clause for filtering
$whereClauses = [];
$params = [];
$types = '';

// [MODIFIED] Changed domain filter to use LIKE for partial matching
if ($domain !== 'all' && !empty($domain)) {
    $whereClauses[] = "domain_url LIKE ?";
    $params[] = "%" . $domain . "%"; // Add wildcards for partial match
    $types .= 's';
}
if (!empty($search)) {
    $whereClauses[] = "(ip_address LIKE ? OR domain_url LIKE ?)";
    $params[] = "%" . $search . "%";
    $params[] = "%" . $search . "%";
    $types .= 'ss';
}

if (!empty($fromDate)) {
    $whereClauses[] = "DATE(access_time) >= ?";
    $params[] = $fromDate;
    $types .= 's';
}
if (!empty($toDate)) {
    $whereClauses[] = "DATE(access_time) <= ?";
    $params[] = $toDate;
    $types .= 's';
}

$whereSql = "";
if (!empty($whereClauses)) {
    $whereSql = " WHERE " . implode(" AND ", $whereClauses);
}

// 3. Find all duplicate IP addresses to highlight them
$duplicate_ips_query = "SELECT ip_address FROM ip_logs GROUP BY ip_address HAVING COUNT(id) > 1";
$dup_result = $conn->query($duplicate_ips_query);
$duplicate_ips = [];
if ($dup_result) {
    while ($dup_row = $dup_result->fetch_assoc()) {
        $duplicate_ips[] = $dup_row['ip_address'];
    }
}


// 4. Get total count of records for pagination
$countQuery = "SELECT COUNT(*) as total FROM ip_logs" . $whereSql;
$countStmt = $conn->prepare($countQuery);
if (!empty($types)) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalRecords = $countStmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
$countStmt->close();

// 5. Fetch the paginated data
$dataQuery = "SELECT id, ip_address, domain_url, access_time FROM ip_logs" . $whereSql . " ORDER BY access_time DESC LIMIT ? OFFSET ?";
$dataStmt = $conn->prepare($dataQuery);

// Add limit and offset to params and types
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$dataStmt->bind_param($types, ...$params);
$dataStmt->execute();
$result = $dataStmt->get_result();

// 6. Build the HTML table rows
$tableHtml = '';
if ($result->num_rows > 0) {
    $sno = $offset + 1;
    while ($row = $result->fetch_assoc()) {
        $utc_time = new DateTime($row['access_time'], new DateTimeZone('UTC'));
        $utc_time->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formatted_time = $utc_time->format('d-m-Y h:i:s A');
        
        $domain_full = htmlspecialchars($row['domain_url']);
        $domain_short = (strlen($domain_full) > 30) ? substr($domain_full, 0, 30) . '...' : $domain_full;

        $ip_full = htmlspecialchars($row['ip_address']);
        
        // Check if the current IP is a duplicate
        $is_duplicate = in_array($row['ip_address'], $duplicate_ips);
        $duplicate_class = $is_duplicate ? " class='duplicate'" : "";

        // [FIXED] Apply the duplicate class only to the IP address <td>, not the <tr>
        $tableHtml .= "<tr" . $duplicate_class . ">";
        $tableHtml .= "<td>" . $sno++ . "</td>";
        $tableHtml .= "<td title='" . $ip_full . "'>" . $ip_full . "</td>";
        $tableHtml .= "<td title='" . $domain_full . "'>" . $domain_short . "</td>";
        $tableHtml .= "<td>" . htmlspecialchars($formatted_time) . "</td>";
        $tableHtml .= "</tr>";
    }
}
$dataStmt->close();

// 7. [MODIFIED] Build advanced pagination HTML
$paginationHtml = '';
if ($totalPages > 1) {
    $window = 2; // How many page numbers to show around the current page

    // First and Previous buttons
    $paginationHtml .= ($page > 1) ? "<a href='#' class='pagination-link' onclick='changePage(1); return false;'>&laquo; First</a>" : "<span class='pagination-link disabled'>&laquo; First</span>";
    $paginationHtml .= ($page > 1) ? "<a href='#' class='pagination-link' onclick='changePage(" . ($page - 1) . "); return false;'>&lsaquo; </a>" : "<span class='pagination-link disabled'>&lsaquo; </span>";

    // Ellipsis at the beginning if needed
    if ($page - $window > 1) {
        $paginationHtml .= "<span class='pagination-ellipsis'>...</span>";
    }

    // Page numbers
    for ($i = max(1, $page - $window); $i <= min($totalPages, $page + $window); $i++) {
        $activeClass = ($i == $page) ? 'active' : '';
        $paginationHtml .= "<a href='#' class='pagination-link {$activeClass}' onclick='changePage({$i}); return false;'>{$i}</a>";
    }

    // Ellipsis at the end if needed
    if ($page + $window < $totalPages) {
        $paginationHtml .= "<span class='pagination-ellipsis'>...</span>";
    }

    // Next and Last buttons
    $paginationHtml .= ($page < $totalPages) ? "<a href='#' class='pagination-link' onclick='changePage(" . ($page + 1) . "); return false;'> &rsaquo;</a>" : "<span class='pagination-link disabled'> &rsaquo;</span>";
    $paginationHtml .= ($page < $totalPages) ? "<a href='#' class='pagination-link' onclick='changePage(" . $totalPages . "); return false;'>Last &raquo;</a>" : "<span class='pagination-link disabled'>Last &raquo;</span>";
}

$conn->close();

// 8. Return the final JSON response
echo json_encode([
    'table' => $tableHtml,
    'pagination' => $paginationHtml
]);
?>

