<?php
include 'config.php'; // Your DB connection

// Set the correct header to output JSON
header('Content-Type: application/json');

// Set the default timezone
date_default_timezone_set('Asia/Kolkata');

// --- Collect and sanitize form POST data ---
$id = $_POST['id'] ?? '';
$name = trim($_POST['name'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$email = trim($_POST['email'] ?? '');
$status = $_POST['status'] ?? 'New lead';
// The 'read_status' checkbox will send 'on' if checked, otherwise it won't be set.
$read_status = isset($_POST['read_status']) && $_POST['read_status'] === 'on' ? 'unread' : 'read';
$remark = trim($_POST['remark'] ?? '');


// --- Basic Validation ---
// Check if ID is provided, as it's essential for an update.
if (empty($id)) {
    // Exit and return a JSON error message
    echo json_encode(['success' => false, 'message' => 'Error: Lead ID is missing. Cannot update.']);
    exit;
}
if (empty($name) || empty($mobile)) {
    // Exit and return a JSON error message for other required fields
    echo json_encode(['success' => false, 'message' => 'Error: Name and Mobile fields cannot be empty.']);
    exit;
}


// --- Prepare and Execute the Update Query ---
// We only update an existing lead since the form is for editing.
// This will use the timezone set at the top of the script ('Asia/Kolkata').
$updated_on = date('Y-m-d H:i:s');
$stmt = $conn->prepare("UPDATE number_fill_leads 
                        SET name = ?, number = ?, email = ?, status = ?, read_status = ?, remark = ?, updated_on = ?
                        WHERE id = ?");

// Bind parameters to the prepared statement
$stmt->bind_param("sssssssi", $name, $mobile, $email, $status, $read_status, $remark, $updated_on, $id);

// Execute the statement and check for success
if ($stmt->execute()) {
    // Check if any row was actually changed.
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Lead updated successfully!']);
    } else {
        // This case occurs if the user clicks "Update" without making any changes.
        // It's technically not an error, so we can treat it as a success.
        echo json_encode(['success' => true, 'message' => 'No changes were made to the lead.']);
    }
} else {
    // If the execute() method fails, return a database error.
    echo json_encode(['success' => false, 'message' => 'Database error while updating the lead.']);
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
