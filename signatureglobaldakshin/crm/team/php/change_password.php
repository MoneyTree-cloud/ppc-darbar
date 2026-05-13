<?php
session_start();
include 'config.php'; // Your DB connection file

// Check if employ is logged in
if (!isset($_SESSION['employ_id'])) {
    // If employ_id not set in session, user is not logged in
    header("Location: ../../team_login.html");
    exit();
}

// Get form values
$oldPassword = $_POST['old-password'] ?? '';
$newPassword = $_POST['new-password'] ?? '';
$confirmNewPassword = $_POST['c-new-password'] ?? '';
$employId = $_SESSION['employ_id']; // Current logged in employ ID

if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
    // echo "<script>alert('All fields are required.')</script>";
    header("Location: ../setting.php?type=success&message=All fields are required.");
    exit();
}

// Check if new password and confirm password match
if ($newPassword !== $confirmNewPassword) {
    // echo "<script>alert('New Password and Confirm New Password do not match.')</script>";
    header("Location: ../setting.php?type=error&message=New Password and Confirm New Password do not match.");
    exit();
}

// Fetch current password from database
$stmt = $conn->prepare("SELECT password FROM team_login WHERE employ_id = ?");
$stmt->bind_param("i", $employId);
$stmt->execute();
$stmt->bind_result($dbPassword);
$stmt->fetch();
$stmt->close();

// Check if old password matches
if ($oldPassword !== $dbPassword) {
    echo "<script>alert('Old Password: $dbPassword and You are entering $oldPassword')</script>";
    header("Location: ../setting.php?type=error&message=Please Enter Correct Old Password.");
    exit();
}

// Update password
$updateStmt = $conn->prepare("UPDATE team_login SET password = ? WHERE employ_id = ?");
$updateStmt->bind_param("si", $newPassword, $employId);

if ($updateStmt->execute()) {
    // echo "<script>alert('Password updated successfully.')</script>";
    header("Location: ../setting.php?type=success&message=Password updated successfully.");
} else {
    // echo "<script>alert('Error updating password.')</script>";
    header("Location: ../setting.php?type=error&message=Error updating password.");
}

$updateStmt->close();
$conn->close();
?>
