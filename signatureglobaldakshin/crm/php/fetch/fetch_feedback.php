<?php
header('Content-Type: application/json');

// Include your database configuration file
include('../../php/config.php'); // Adjust path if needed

// Get the search term from the URL
$search = $_GET['search'] ?? '';

// Base SQL query
$sql = "SELECT id, name, contact, email, feedback_message, submitted_at FROM feedback";

$params = [];
$types = '';

// Add search condition if a search term is provided
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    // Search across multiple relevant columns
    $sql .= " WHERE name LIKE ? OR contact LIKE ? OR email LIKE ? OR feedback_message LIKE ?";
    // Add the search term for each placeholder
    for ($i = 0; $i < 4; $i++) {
        $params[] = $searchTerm;
    }
    $types .= 'ssss';
}

$sql .= " ORDER BY submitted_at DESC";

// --- Prepare and execute the statement ---
$stmt = $conn->prepare($sql);

if ($stmt) {
    if (!empty($types)) {
        // Bind parameters dynamically
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    $sno = 1; // Initialize serial number
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add the serial number to each row
            $row['sno'] = $sno++;
            // Sanitize output to prevent XSS
            foreach ($row as $key => $value) {
                $row[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            $data[] = $row;
        }
    }
    
    $stmt->close();
} else {
    // Handle SQL error
    $data = ['error' => 'Failed to prepare the SQL statement.'];
}

$conn->close();

// Return the data as JSON
echo json_encode($data);
?>
