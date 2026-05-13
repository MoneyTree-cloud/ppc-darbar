<?php
session_start(); // Start a session to manage login

include 'config.php'; // Connect to your database

// Get the form data
$member_id = $_POST['employId'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($member_id) && !empty($password)) {
    // Prepare and bind safely
    $stmt = $conn->prepare("SELECT * FROM team_login WHERE employ_id = ?");
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if member exists
    if ($result->num_rows === 1) {
        $member = $result->fetch_assoc();
        
        // Verify password (if stored hashed use password_verify(), otherwise direct match)
        if ($member['password'] === $password) { 
            // Login successful
            $_SESSION['id'] = $member['id']; // Store member id in session
            $_SESSION['name'] = $member['name'];
            $member_name = $member['name'];
            $_SESSION['rights'] = $member['rights'];
            $_SESSION['employ_id'] = $member['employ_id'];
            $_SESSION['team_name'] = $member['team_name'];

            header("Location: ../index.php?type=success&message=Welcome Back $member_name!!"); // Redirect to Team dashboard
            exit();
        } else {
            // Incorrect password
            header("Location: ../../team_login.html?type=error&message=Incorrect Password!!");
            exit();
        }
    } else {
        // No member found
        header("Location: ../../team_login.html?type=error&message=Member Not Found!!");
        exit();
    }

    $stmt->close();
} else {
    header("Location: ../../team_login.html?type=error&message=Please fill all fields");
    exit();
}

$conn->close();
?>
