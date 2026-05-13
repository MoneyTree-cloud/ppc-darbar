<?php
require_once "../config.php"; // Adjust path as needed

// Get the date parameter if provided, otherwise use today
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d', strtotime('-1 day'));

// Modified query to get only the latest entry (highest ID) for each employee on the selected date
$sql = "SELECT t1.* FROM team_eod t1
        INNER JOIN (
            SELECT employ_id, MAX(id) as max_id 
            FROM team_eod 
            WHERE DATE(check_out) = ? 
            GROUP BY employ_id
        ) t2 ON t1.employ_id = t2.employ_id AND t1.id = t2.max_id
        ORDER BY t1.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$sn = 1;

while ($row = $result->fetch_assoc()) {
    $timeOnly = date("h:i:s A", strtotime($row["check_out"])); // Extract time only

    $data[] = [
        "sno" => $sn++,
        "employ_id" => $row["employ_id"],
        "calls" => $row["calls"],
        "prospects" => $row["prospects"],
        "meetings" => $row["meetings"],
        "client_name" => $row["client_name"],
        "check_out" => $timeOnly,
        "date" => $row["check_out"]
    ];
}

echo json_encode($data);
?>