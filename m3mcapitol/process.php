<?php
require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Backend validation
$errors = [];
if (!$name) $errors[] = 'Name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (!preg_match('/^[0-9]{10,15}$/', $phone)) $errors[] = 'Valid phone number is required.';

if (count($errors) > 0) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit();
}

// --- Fire off the PPC/organic API call ---
$apiUrl    = env('API_URL');
$authToken = env('API_TOKEN');
$payload   = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'project'      => 'M3M Capitol',
    'source'       => 'M3M Capitol | https://m3mcapitol.in/'
]);
$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        "Authorization: Bearer {$authToken}"
    ],
]);
$apiResponse = curl_exec($ch);
curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://m3mcapitol.in/', 'Gurugram', 'M3M Capitol');

echo json_encode(['success' => true, 'message' => 'Thank you! Our team will contact you shortly.', 'redirect' => 'thankyou.php']);
exit();
