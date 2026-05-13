<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Soft delete: update the delete_status column instead of deleting the row
    $stmt = $conn->prepare("UPDATE all_leads SET delete_status = 'deleted' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../leads.php?type=success&message=Lead marked as deleted successfully");
        exit();
    } else {
        header("Location: ../../leads.php?type=error&message=Failed to mark Lead as deleted");
        exit();
    }
} else {
    header("Location: ../../leads.php?type=error&message=Invalid request");
    exit();
}
?>
