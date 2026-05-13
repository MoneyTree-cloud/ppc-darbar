<?php
include '../../php/config.php';

if (isset($_GET['unique_id']) && isset($_GET['meeting_status'])) {
    $unique_id = $_GET['unique_id'];
    $meeting_status = $_GET['meeting_status'];

    $stmt = $conn->prepare("UPDATE meeting SET meeting_status = ? WHERE unique_id = ?");
    $stmt->bind_param("ss", $meeting_status, $unique_id);

    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../meeting_client.php?type=success&message=Lead marked as $meeting_status successfully");
        // header("Location: ../../meeting_client.php?type=success&UPDATE meeting SET meeting_status = $meeting_status WHERE unique_id = $unique_id");
        exit();
    } else {
        header("Location: ../../meeting_client.php?type=error&message=Failed to mark Lead as $meeting_status");
        exit();
    }
} else {
    header("Location: ../../meeting_client.php?type=error&message=Invalid request");
    exit();
}
?>
