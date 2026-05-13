<?php
// include('config.php');
// session_start(); // Always start session
error_reporting(E_ALL);
ini_set('display_errors', 1);

// if (!isset($_SESSION['admin_id'])) {
    // If admin_id not set in session, user is not logged in
    // $stmt = $conn->prepare("SELECT adminName FROM master_login WHERE id = ?");
    // $stmt->bind_param("i", $adminId);
    // $stmt->execute();
    // $stmt->bind_result($adminName);
    // $stmt->fetch();
    // $stmt->close();
    // header("Location: login.html");
    // exit();
// }

// Else, continue normally
// If needed, you can also check who is logged in:
// echo $_SESSION['admin_name'];

// Above code is of login check but without session expiration with time


// Below is the code for login check with session expire with time
include('config.php');
session_start();

// ⏱ 5 hour timeout (18000 seconds)
$timeout_duration = 18000;

// Check if admin is logged in
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_role'])) {

    // Session timeout check
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.html?type=error&message=Session expired due to inactivity. Please login again.");
        exit();
    }

    // Update last activity time
    $_SESSION['LAST_ACTIVITY'] = time();

    // echo $_SESSION["admin_role"];

    // OPTIONAL: Role-based restriction example
    /*
    if ($_SESSION['admin_role'] !== 'super_admin') {
        header("Location: dashboard.php");
        exit();
    }
    */

} else {
    // Session missing (id or role)
    session_unset();
    session_destroy();
    header("Location: login.html?type=error&message=Unauthorized access. Please login.");
    exit();
}
?>

