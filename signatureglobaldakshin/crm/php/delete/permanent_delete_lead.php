<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $conn->prepare("DELETE FROM all_leads WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../deleted_leads.php?type=success&message=Lead deleted successfully");
        exit();
    } else {
        header("Location: ../../leads.php?type=error&message=Failed to delete Lead");
        exit();
    }
} else {
    header("Location: ../../leads.php?type=error&message=Invalid request");
    exit();
}
?>