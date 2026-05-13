<?php
// Include the Composer autoloader for PhpSpreadsheet and your DB config
require '../../vendor/autoload.php';
include('config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Set the default timezone
date_default_timezone_set('Asia/Kolkata');

// 1. Get filter parameters from the POST request
$domain = 'm3mjacob.com';
$search = $_POST['search'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';

// 2. Build the WHERE clause dynamically based on filters
$whereClauses = [];
$params = [];
$types = '';

if ($domain !== 'all' && !empty($domain)) {
    $whereClauses[] = "domain_url LIKE ?";
    $params[] = "%" . $domain . "%";
    $types .= 's';
}
if (!empty($search)) {
    $whereClauses[] = "ip_address LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= 's';
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

// 3. Fetch all matching data (no pagination)
$dataQuery = "SELECT ip_address, domain_url, access_time FROM ip_logs" . $whereSql . " ORDER BY access_time DESC";
$dataStmt = $conn->prepare($dataQuery);

if (!empty($types)) {
    $dataStmt->bind_param($types, ...$params);
}
$dataStmt->execute();
$result = $dataStmt->get_result();

// 4. Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('IP Logs Report');

// 5. Set the headers
$sheet->setCellValue('A1', 'S.No.');
$sheet->setCellValue('B1', 'IP Address');
$sheet->setCellValue('C1', 'Domain / URL');
$sheet->setCellValue('D1', 'Access Time (IST)');

// Style the header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '00584F']]
];
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// 6. Populate the spreadsheet with data
$rowNumber = 2;
$sno = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Convert time to IST
        $utc_time = new DateTime($row['access_time'], new DateTimeZone('UTC'));
        $utc_time->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $formatted_time = $utc_time->format('d-m-Y h:i:s A');

        $sheet->setCellValue('A' . $rowNumber, $sno++);
        $sheet->setCellValue('B' . $rowNumber, $row['ip_address']);
        $sheet->setCellValue('C' . $rowNumber, $row['domain_url']);
        $sheet->setCellValue('D' . $rowNumber, $formatted_time);
        $rowNumber++;
    }
}

// 7. Auto-size columns for better readability
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);

// 8. Set headers to prompt download
$fileName = "ip_logs_report_" . date('Y-m-d') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// 9. Create the writer and output the file
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

$dataStmt->close();
$conn->close();
exit();
?>
