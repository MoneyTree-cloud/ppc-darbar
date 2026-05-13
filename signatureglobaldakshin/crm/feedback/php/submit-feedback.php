<?php
// Include your database configuration file
// Make sure the path is correct relative to this file's location
include '../../php/config.php';

// Initialize a response message
$response_message = '';
$response_type = 'error';

// 1. Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Sanitize and retrieve form data
    $client_name = trim($_POST['client_name']);
    $contact_no  = trim($_POST['contact_no']);
    $email       = trim($_POST['email']);
    $feedback    = trim($_POST['feedback']);

    // 3. Basic Validation
    if (empty($client_name) || empty($contact_no) || empty($email)) {
        $response_message = "Error: Name, Contact, and Email are required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response_message = "Error: Please enter a valid email address.";
    } elseif (!preg_match('/^[0-9]{10}$/', $contact_no)) {
        $response_message = "Error: Please enter a valid 10-digit contact number.";
    } else {
        
        // 4. Prepare an INSERT statement to prevent SQL injection
        $stmt = $conn->prepare(
            "INSERT INTO feedback (name, contact, email, feedback_message) VALUES (?, ?, ?, ?)"
        );

        if ($stmt === false) {
            // Handle error in preparing the statement
            error_log("Error preparing statement: " . $conn->error);
            $response_message = "A server error occurred. Please try again later.";
        } else {
            // Bind parameters to the statement
            $stmt->bind_param("ssss", $client_name, $contact_no, $email, $feedback);

            // 5. Execute the statement and handle the result
            if ($stmt->execute()) {
                $response_type = 'success';
                $response_message = "Thank you! Your feedback has been submitted successfully.";
            } else {
                // Handle execution error
                error_log("Error executing statement: " . $stmt->error);
                $response_message = "Could not process your feedback. Please try again later.";
            }
            
            // Close the statement
            $stmt->close();
        }
    }
} else {
    // If the request method is not POST
    $response_message = "Invalid request method.";
}

// Close the database connection
$conn->close();

// 6. Redirect back to the form with a status message
// We use urlencode() to safely pass the message in the URL
header("Location: ../index.html?type=" . $response_type . "&message=" . urlencode($response_message));
exit();

?>
