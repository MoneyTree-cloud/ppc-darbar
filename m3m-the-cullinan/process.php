<?php
require_once __DIR__ . '/../env.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $name     = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone    = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $interest = htmlspecialchars(trim($_POST['interest'] ?? ''));
    $message  = htmlspecialchars(trim($_POST['message'] ?? ''));

    // API endpoint
    $apiUrl      = 'https://moneytreerealty.com/api/post-lead';
    $bearerToken = env('API_TOKEN');

    $payload = [
        'name'          => $name,
        'number'        => $phone,
        'email'         => $email,
        'employee_code' => '2046',
        'project_name'  => 'M3M The Cullinan'
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $bearerToken
    ]);
    $apiResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Thank you for your interest in M3M The Cullinan!',
        'redirect' => 'thank-you.php'
    ]);
    exit();
}

header('Content-Type: application/json');
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit();
?>
