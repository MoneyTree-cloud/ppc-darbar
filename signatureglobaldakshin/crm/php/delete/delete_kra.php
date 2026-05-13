<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $conn->prepare("DELETE FROM kra WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../kra.php?type=success&message=Team member deleted successfully");
        exit();
    } else {
        header("Location: ../../kra.php?type=error&message=Failed to delete team member");
        exit();
    }
} else {
    header("Location: ../../kra.php?type=error&message=Invalid request");
    exit();
}
?>
