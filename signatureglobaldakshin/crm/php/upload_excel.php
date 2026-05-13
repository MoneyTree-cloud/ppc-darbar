<?php
include 'config.php'; // apna DB connection file

require '../vendor/autoload.php'; // PhpSpreadsheet autoload

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['upload'])) {
    $fileName = $_FILES['excel_file']['tmp_name'];

    if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        die("File upload failed!");
    }

    try {
        $spreadsheet = IOFactory::load($fileName);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Skip header row (assume first row is header)
        $isHeader = true;
        foreach ($rows as $row) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            // Match columns as per your table
            $name        = $row[0] ?? '';
            $mobile      = $row[1] ?? '';
            $email       = $row[2] ?? '';
            $domain      = $row[3] ?? '';
            $remark      = $row[4] ?? '';
            $captcha     = $row[5] ?? '';
            $date_time   = !empty($row[6]) ? date('Y-m-d H:i:s', strtotime($row[6])) : null;
            $updated_on  = $row[7] ?? '';
            $read_status = $row[8] ?? '';
            $status      = $row[9] ?? '';
            $delete_status = $row[10] ?? '';
            $ip          = $row[11] ?? '';
            $access_url  = $row[12] ?? '';
            $bot         = $row[13] ?? '';

            $sql = "INSERT INTO uploaded_leads 
                (name, mobile, email, domain, remark, captcha, date_time, updated_on, read_status, status, delete_status, ip, access_url, bot) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssssss",
                $name, $mobile, $email, $domain, $remark, $captcha, $date_time,
                $updated_on, $read_status, $status, $delete_status, $ip, $access_url, $bot
            );
            $stmt->execute();
        }

        header("Location: ../uploaded_leads.php?type=success&message=Leads added successfully!!");
        exit();
    } catch (Exception $e) {
        die("Error loading file: " . $e->getMessage());
    }
}
?>
    