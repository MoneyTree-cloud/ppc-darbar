<?php
include 'config.php';

// Step 1: Get today's date
$today = date('Y-m-d');

// Step 2: Fetch all KRA rows that are NOT already updated today
$sql = "SELECT id, not_sale FROM kra WHERE date != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$rowsToUpdate = [];

while ($row = $result->fetch_assoc()) {
    $rowsToUpdate[] = [
        'id' => $row['id'],
        'not_sale' => $row['not_sale'] + 1 // increment by 1
    ];
}
$stmt->close();

// Step 3: Update all KRA rows
$updateAllStmt = $conn->prepare("
    UPDATE kra 
    SET 
        calling_target = 300,
        callyzer_2pm = 0,
        callyzer_5pm = 0,
        callyzer_8pm = 0,
        target_achieved = 0,
        prospects = 0,
        no_of_meetings = 0,
        date = ?
");
$updateAllStmt->bind_param("s", $today);
$updateSuccess = $updateAllStmt->execute();
$updateAllStmt->close();

// Step 4: Increment not_sale only where date != today
$updateNotSaleStmt = $conn->prepare("UPDATE kra SET not_sale = ? WHERE id = ?");
foreach ($rowsToUpdate as $row) {
    $updateNotSaleStmt->bind_param("ii", $row['not_sale'], $row['id']);
    $updateNotSaleStmt->execute();
}
$updateNotSaleStmt->close();

$conn->close();

// Redirect after success
if ($updateSuccess) {
    header("Location: ../kra.php?type=success&message=KRA data has been reset successfully");
} else {
    header("Location: ../kra.php?type=error&message=Failed to reset KRA data");
}
