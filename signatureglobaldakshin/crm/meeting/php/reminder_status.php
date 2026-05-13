<?php
include '../../php/config.php';

if (isset($_GET['unique_id']) && isset($_GET['reminder'])) {
    $unique_id = $_GET['unique_id'];
    $reminder = $_GET['reminder'];

    $stmt = $conn->prepare("UPDATE meeting SET reminder = ? WHERE unique_id = ?");
    $stmt->bind_param("ss", $reminder, $unique_id);

    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../meeting_client.php?type=success&message=reminder is $reminder successfully");
        // header("Location: ../../meeting_client.php?type=success&UPDATE meeting SET reminder = $reminder WHERE unique_id = $unique_id");
        exit();
    } else {
        header("Location: ../../meeting_client.php?type=error&message=Failed to set reminder $reminder");
        exit();
    }
} else {
    header("Location: ../../meeting_client.php?type=error&message=Invalid request");
    exit();
}
?>
