<?php
require_once "config.php"; // connection file

// Get POST data
$id           = isset($_POST['id']) ? trim($_POST['id']) : '';
$index_no     = trim($_POST['index_no']);
$project_name = trim($_POST['Project_name']);
$domain_name  = trim($_POST['domain_name']);
$status       = isset($_POST['status']) ? $_POST['status'] : 'active';

date_default_timezone_set('Asia/Kolkata');
$now_timestamp = date("Y-m-d H:i:s");

// =======================
// INSERT (Add New Domain)
// =======================
if ($id == '') {

    $sql = "INSERT INTO domains 
            (index_no, project_name, domain_name, active_status, date_time, updated_on)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isssss",
        $index_no,
        $project_name,
        $domain_name,
        $status,
        $now_timestamp,
        $now_timestamp
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../domain.php?type=success&message=Domain added successfully!!");
        exit;
    } else {
        // die("Insert failed: " . mysqli_error($conn));
         header("Location: ../domain.php?type=error&message=something went wrong!!");
        exit;
    }

// =======================
// UPDATE (Edit Domain)
// =======================
} else {

    $sql = "UPDATE domains SET
                index_no = ?,
                project_name = ?,
                domain_name = ?,
                active_status = ?,
                updated_on = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "issssi",
        $index_no,
        $project_name,
        $domain_name,
        $status,
        $now_timestamp,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../domain.php?type=success&message=Domain Updated successfully!!");
        exit;
    } else {
        // die("Update failed: " . mysqli_error($conn));
         header("Location: ../domain.php?type=error&message=something went wrong!!");
        exit;
    }
}
