<?php

require_once "../config.php"; // Adjust path as needed

// Check if required parameters are provided
if (!isset($_GET['employ_id']) || !isset($_GET['date'])) {
    die('Employee ID and date are required');
}

$employ_id = trim($_GET['employ_id']);
$date = trim($_GET['date']);

try {
    // Prepare the DELETE statement
    $sql = "DELETE FROM team_leader_eod 
            WHERE employ_id = ? 
            AND check_out = ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $employ_id, $date);
    $stmt->execute();
    
    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Redirect back with success message
        header("Location: ../../leader_eod_report.php?type=success&message=$employ_id Data Deleted Successfully!!");
    } else {
        // Redirect back with error message
        header("Location: ../../leader_eod_report.php?type=error&message=Something Went Wrong!!");
    }
    
    $stmt->close();
    $conn->close();
    exit();
    
} catch (Exception $e) {
    // Log the error (you might want to implement proper error logging)
    error_log("Delete error: " . $e->getMessage());
    
    // Redirect back with error message
    header("Location: ../../leader_eod_report.php?type=error&message=Something Went Wrong!!");
    exit();
}
?>