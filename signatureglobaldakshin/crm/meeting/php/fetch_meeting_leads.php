<?php
/**
 * fetch_event_leads.php
 *
 * This script fetches records from the 'event' table,
 * with an optional search filter, and returns them as a JSON object.
 */

// Set the content type to JSON
header('Content-Type: application/json');

// Include the database configuration. The path is based on your provided file structure.
include '../../php/config.php';

// Get the search term from the query string, if it exists
$searchTerm = $_GET['search'] ?? '';

// Base SQL query
$sql = "SELECT id, name, phone, unique_id, meeting_on, timing, employ_id, invited_by, created_at, meeting_status, reminder FROM meeting";

// If a search term is provided, add a WHERE clause to filter the results
if (!empty($searchTerm)) {
    // Search across multiple relevant fields: client name, employee id, and inviter's name
    $sql .= " WHERE name LIKE ? OR employ_id LIKE ? OR invited_by LIKE ?";
}

// Add the ordering to show the most recent leads first
$sql .= " ORDER BY created_at DESC";

// Prepare the statement to prevent SQL injection
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    // Handle SQL error
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit();
}

// If there was a search term, bind the parameters
if (!empty($searchTerm)) {
    $likeTerm = "%" . $searchTerm . "%";
    // Bind the same search term to all three placeholders in the WHERE clause
    $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
}

// Execute the statement and get the result
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$sno = 1; // Initialize serial number

if ($result && $result->num_rows > 0) {
    // Fetch all matching rows into an array
    while ($row = $result->fetch_assoc()) {
        // Add a serial number to each row for display purposes
        $row['sno'] = $sno++;
        $data[] = $row;
    }
}

// Close the statement and the database connection
$stmt->close();
$conn->close();

// Encode the data array into a JSON string and output it
echo json_encode($data);

?>
