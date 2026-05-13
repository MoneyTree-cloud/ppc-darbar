<?php
session_start();
include 'config.php'; // Your DB connection file

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.html");
    exit();
}
$adminId = $_SESSION['admin_id'];

$newProfileFileName = null;
$newPassword = null;

// --- 1. HANDLE PROFILE PICTURE UPLOAD ---
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profile_picture'];
    $uploadDir = '../assets/imgs/admin/';
    
    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        header("Location: ../setting.php?type=error&message=Invalid file type. Please upload a JPG, PNG, or GIF.");
        exit();
    }

    // Validate file size (e.g., 2MB limit)
    if ($file['size'] > 2 * 1024 * 1024) {
        header("Location: ../setting.php?type=error&message=File is too large. Maximum size is 2MB.");
        exit();
    }

    // Generate a unique filename to prevent overwriting
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newProfileFileName = 'admin_' . $adminId . '_' . time() . '.' . $extension;
    $uploadPath = $uploadDir . $newProfileFileName;

    // Move the uploaded file
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        header("Location: ../setting.php?type=error&message=Failed to upload profile picture.");
        exit();
    }
}

// --- 2. HANDLE PASSWORD CHANGE ---
$oldPassword = $_POST['old-password'] ?? '';
$newPasswordInput = $_POST['new-password'] ?? '';
$confirmNewPassword = $_POST['c-new-password'] ?? '';

// Only proceed with password validation if user is trying to change it
if (!empty($oldPassword) || !empty($newPasswordInput) || !empty($confirmNewPassword)) {
    // All password fields are required if one is filled
    if (empty($oldPassword) || empty($newPasswordInput) || empty($confirmNewPassword)) {
        header("Location: ../setting.php?type=error&message=To change your password, all three password fields are required.");
        exit();
    }

    if ($newPasswordInput !== $confirmNewPassword) {
        header("Location: ../setting.php?type=error&message=New password and confirmation do not match.");
        exit();
    }

    // Fetch current password from the database
    $stmt = $conn->prepare("SELECT password FROM master_login WHERE id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || $oldPassword !== $user['password']) {
        header("Location: ../setting.php?type=error&message=Old password does not match.");
        exit();
    }
    
    // If all checks pass, set the new password for update
    $newPassword = $newPasswordInput;
}

// --- 3. BUILD AND EXECUTE THE UPDATE QUERY ---
if ($newPassword === null && $newProfileFileName === null) {
    header("Location: ../setting.php?type=error&message=Nothing to update. Please provide a new picture or new password details.");
    exit();
}

$queryParts = [];
$params = [];
$types = '';

if ($newPassword !== null) {
    $queryParts[] = "password = ?";
    $params[] = $newPassword;
    $types .= 's';
}
if ($newProfileFileName !== null) {
    $queryParts[] = "profile_img = ?";
    $params[] = $newProfileFileName;
    $types .= 's';
}

$params[] = $adminId;
$types .= 'i';

$sql = "UPDATE master_login SET " . implode(', ', $queryParts) . " WHERE id = ?";
$updateStmt = $conn->prepare($sql);
$updateStmt->bind_param($types, ...$params);

if ($updateStmt->execute()) {
    header("Location: ../setting.php?type=success&message=Profile updated successfully!");
} else {
    header("Location: ../setting.php?type=error&message=Error updating profile.");
}

$updateStmt->close();
$conn->close();
?>