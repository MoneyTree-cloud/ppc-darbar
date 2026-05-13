<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include '../php/config.php'; // adjust path as needed

$method = $_SERVER['REQUEST_METHOD'];

if (isset($_GET['count']) && $_GET['count'] === 'true') {
    $result = $conn->query("SELECT COUNT(*) as total FROM master_login_activity"); // ✅ Corrected table name
    $row = $result->fetch_assoc();
    echo json_encode(['total' => $row['total']]);
    exit;
}


if ($method === 'GET') {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 25;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    
    $stmt = $conn->prepare("SELECT * FROM master_login_activity ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    echo json_encode($rows);
    exit();
}


elseif ($method == 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $username = $data['username'];
    $stmt = $conn->prepare("UPDATE master_login_activity SET username=? WHERE id=?");
    $stmt->bind_param("si", $username, $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Updated successfully"]);
    } else {
        echo json_encode(["message" => "Update failed"]);
    }
}

elseif ($method == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $stmt = $conn->prepare("DELETE FROM master_login_activity WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Deleted successfully"]);
    } else {
        echo json_encode(["message" => "Delete failed"]);
    }
}
?>
