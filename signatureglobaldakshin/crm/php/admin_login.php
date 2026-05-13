<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
date_default_timezone_set('Asia/Kolkata');

// Get form data
$adminName = $_POST['adminName'] ?? '';
$password  = $_POST['password'] ?? '';
$now = date('Y-m-d H:i:s');

if (!empty($adminName) && !empty($password)) {

    // Fetch admin
    $stmt = $conn->prepare("SELECT * FROM master_login WHERE adminName = ?");
    $stmt->bind_param("s", $adminName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();

        // ✅ CORRECT PASSWORD CHECK
        if (password_verify($password, $admin['password'])) {

            // Login success
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['adminName'];
            $_SESSION['admin_email'] = $admin['email'] ?? null;
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['LAST_ACTIVITY'] = time();

            // Log activity
            $username = $admin['adminName'];
            $stmt2 = $conn->prepare(
                "INSERT INTO master_login_activity (username, logged_in_at) VALUES (?, ?)"
            );
            $stmt2->bind_param("ss", $username, $now);
            $stmt2->execute();
            $stmt2->close();

            header(
                'Location: ../index.php?type=success&message=' .
                urlencode('Welcome back ' . $_SESSION['admin_name'])
            );
            exit();

        } else {
            header("Location: ../login.html?type=error&message=Incorrect Password!!");
            exit();
        }

    } else {
        header("Location: ../login.html?type=error&message=Admin Not Found!!");
        exit();
    }

    $stmt->close();

} else {
    header("Location: ../login.html?type=error&message=Please fill all fields");
    exit();
}

$conn->close();
?>
