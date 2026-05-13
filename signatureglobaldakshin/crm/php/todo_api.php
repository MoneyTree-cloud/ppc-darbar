<?php
session_start();
include('config.php'); // Your DB connection
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? null;
$response = ['success' => false, 'message' => 'Invalid action.'];

// [MODIFIED] Added search logic to the 'fetch' case
switch ($action) {
    case 'fetch':
        $search = $_GET['search'] ?? '';
        $query = "SELECT id, title, description, status, image_path, assigned_to, due_date, created_at FROM todos";
        $params = [];
        $types = '';

        if (!empty($search)) {
            $query .= " WHERE (title LIKE ? OR description LIKE ?)";
            $likeTerm = "%" . $search . "%";
            $params[] = $likeTerm;
            $params[] = $likeTerm;
            $types .= 'ss';
        }

        $query .= " ORDER BY created_at DESC";
        $stmt = $conn->prepare($query);

        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $tasks = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($tasks);
        exit;

    case 'get':
        $id = $_GET['id'];
        // [FIXED] Added the 'due_date' column to the SELECT statement
        $stmt = $conn->prepare("SELECT id, title, description, assigned_to, due_date FROM todos WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc());
        exit;

    case 'add':
    case 'update':
        $id = $_POST['task_id'] ?? null;
        $title = $_POST['title'];
        $description = $_POST['description'] ?? null;
        $assigned_to = $_POST['assigned_to'];
        $due_date = $_POST['due_date'];
        $image_path = null;
        
        // --- Image Upload Handling ---
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/todos/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('task_', true) . '.' . $extension;
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $image_path = $fileName;
            } else {
                $response['message'] = 'Failed to upload image.';
                echo json_encode($response);
                exit;
            }
        }
        
        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO todos (title, description, image_path, assigned_to, due_date, status, created_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->bind_param("sssss", $title, $description, $image_path, $assigned_to, $due_date);
        } else { // Update
            if ($image_path) {
                $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ?, image_path = ?, assigned_to = ?, due_date = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $title, $description, $image_path, $assigned_to, $due_date, $id);
            } else {
                $stmt = $conn->prepare("UPDATE todos SET title = ?, description = ?, assigned_to = ?, due_date = ? WHERE id = ?");
                $stmt->bind_param("ssssi", $title, $description, $assigned_to, $due_date, $id);
            }
        }
        
        if ($stmt->execute()) {
            $response = ['success' => true];
        } else {
            $response['message'] = 'Database error: ' . $stmt->error;
        }
        break;

    case 'toggle_status':
        $id = $_POST['task_id'];
        $stmt = $conn->prepare("UPDATE todos SET status = IF(status = 'pending', 'completed', 'pending') WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $response = ['success' => true];
        }
        break;

    case 'delete':
        $id = $_POST['task_id'];
        // First, get the image path to delete the file
        $stmt_get = $conn->prepare("SELECT image_path FROM todos WHERE id = ?");
        $stmt_get->bind_param('i', $id);
        $stmt_get->execute();
        $result = $stmt_get->get_result();
        $task = $result->fetch_assoc();
        
        if ($task && $task['image_path']) {
            $filePath = '../uploads/todos/' . $task['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt_get->close();

        // Then, delete the record from the database
        $stmt_del = $conn->prepare("DELETE FROM todos WHERE id = ?");
        $stmt_del->bind_param('i', $id);
        if ($stmt_del->execute()) {
            $response = ['success' => true];
        }
        break;
}

$conn->close();
echo json_encode($response);
?>

