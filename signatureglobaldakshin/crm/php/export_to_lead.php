<?php
// Include your database configuration file
include('config.php'); // Adjust the path as needed

// 1. Get the ID from the URL and validate it
$lead_id = $_GET['id'] ?? null;
if (!$lead_id || !filter_var($lead_id, FILTER_VALIDATE_INT)) {
    // Redirect with an error if the ID is missing or invalid
    header("Location: {$_SERVER['HTTP_REFERER']}?type=error&message=Invalid Lead ID.");
    exit();
}

// 2. Fetch the lead data from the 'number_fill_leads' table
// [MODIFIED] Added 'created_at' to the SELECT query
$stmt_select = $conn->prepare("SELECT name, email, number, domain, created_at FROM number_fill_leads WHERE id = ?");
if ($stmt_select === false) {
    die("Error preparing select statement: " . $conn->error);
}
$stmt_select->bind_param("i", $lead_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows === 0) {
    // If no lead is found with that ID, redirect with an error
    $stmt_select->close();
    $conn->close();
    header("Location: {$_SERVER['HTTP_REFERER']}?type=error&message=Lead with ID " . htmlspecialchars($lead_id) . " not found.");
    exit();
}

$lead = $result->fetch_assoc();
$stmt_select->close();

// 3. Prepare the data for insertion into the 'all_leads' table
$name      = $lead['name'];
$mobile    = $lead['number']; // Mapping 'number' to 'mobile'
$email     = $lead['email'];
$domain    = $lead['domain'];
$date_time = $lead['created_at']; // [NEW] Get the original creation date

// Set default values for other columns in 'all_leads'
$remark      = 'Exported from Raw Leads';
$read_status = 'unread';
$status      = 'New lead';

// 4. Insert the data into the 'all_leads' table
// [MODIFIED] Replaced NOW() with a placeholder for the date
$stmt_insert = $conn->prepare(
    "INSERT INTO all_leads (name, mobile, email, domain, date_time, remark, read_status, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);
if ($stmt_insert === false) {
    die("Error preparing insert statement: " . $conn->error);
}
// [MODIFIED] Added the $date_time variable and an extra 's' to the type string
$stmt_insert->bind_param("ssssssss", $name, $mobile, $email, $domain, $date_time, $remark, $read_status, $status);

// 5. Execute and redirect with a status message
if ($stmt_insert->execute()) {
    // Success
    $message = "Lead for " . htmlspecialchars($name) . " has been successfully exported.";
    header("Location: {$_SERVER['HTTP_REFERER']}?type=success&message=" . urlencode($message));
} else {
    // Handle potential errors, e.g., duplicate email if you have a unique constraint
    $message = "Error exporting lead: " . $stmt_insert->error;
    header("Location: {$_SERVER['HTTP_REFERER']}?type=error&message=" . urlencode($message));
}

$stmt_insert->close();
$conn->close();
exit();
?>

