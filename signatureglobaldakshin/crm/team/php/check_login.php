<?php
include('config.php');
session_start(); // Always start session

if (!isset($_SESSION['employ_id'])) {
    // If employ_id not set in session, user is not logged in
    $stmt = $conn->prepare("SELECT name FROM team_login WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['employ_id']);
    $stmt->execute();
    $stmt->bind_result($member_id);
    $stmt->fetch();
    $stmt->close();
    header("Location: ../team_login.html");
    exit();
}

// Else, continue normally
// If needed, you can also check who is logged in:
$username =  $_SESSION['name'];
?>
