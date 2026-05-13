<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $conn->prepare("DELETE FROM kra_report WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        header("Location: ../../edit_kra_report.php?type=success&message=Kra's Data deleted successfully");
        exit();
    } else {
        header("Location: ../../edit_kra_report.php?type=error&message=Failed to delete team member's data");
        exit();
    }
} else {
    header("Location: ../../edit_kra_report.php?type=error&message=Invalid request");
    exit();
}
?>
