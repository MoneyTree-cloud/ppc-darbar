<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $employ_id = trim($_POST['employId'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['phone'] ?? '');
    $team_name = trim($_POST['team_name'] ?? '');
    $rights = trim($_POST['rights'] ?? '');
    $zero = 0;
    $calling_target = 300;
    $not_sale = 0;
    $firstName = explode(' ', trim($name))[0];  
    // Concatenate with employ_id
    $password = $firstName . "@" . $employ_id;

    if ($name && $employ_id && $email && $contact && $rights) {
        if ($id) {
            // Update
            $stmt = $conn->prepare("UPDATE team_login SET name=?, employ_id=?, email=?, contact=?, team_name=?, rights=? WHERE id=?");
            $stmt->bind_param("ssssssi", $name, $employ_id, $email, $contact, $team_name, $rights, $id);
            $success = $stmt->execute();
            $stmt->close();
            
            if ($success) {
                header("Location: ../team.php?type=success&message=Team member updated successfully");
                exit();
            } else {
                header("Location: ../team.php?type=error&message=Failed to update member");
                exit();
            }            
        } else {
            // Insert
            $check = $conn->prepare("SELECT id FROM team_login WHERE email = ? OR employ_id = ?");
            $check->bind_param("ss", $email, $employ_id);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                header("Location: ../team.php?type=error&message=Email or Employ ID already exists");
                exit();

            } else {
                $stmt = $conn->prepare("INSERT INTO team_login (name, employ_id,password, email, contact, team_name, rights) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $name, $employ_id, $password, $email, $contact, $team_name, $rights);
                $success = $stmt->execute();
                $stmt->close();

                $fullDateTime = date("Y-m-d H:i:s");
                // $fullDateTime = $date . ' ' . date('H:i:s'); // Combine date + current time
                // Insert new record into KRA table
                $stmt2 = $conn->prepare("INSERT INTO kra_report (name, calling_target, callyzer_2pm, callyzer_5pm, callyzer_8pm, target_achieved, prospects, no_of_meetings, not_sale, date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt2->bind_param("siiiiiiiis", $name, $calling_target, $zero, $zero, $zero, $zero, $zero, $zero, $zero, $fullDateTime);
                $success2 = $stmt2->execute();
                $stmt2->close();

                if ($success) {
                    header("Location: ../team.php?type=success&message=Team member added successfully");
                    exit();
                } else {
                    header("Location: ../team.php?type=error&message=Failed to insert record");
                    exit();
                }
                
            }

            $check->close();
        }
    } else {
        header("Location: ../team.php?type=error&message=All fields are required");
        exit();
    }
}

$conn->close();
?>
