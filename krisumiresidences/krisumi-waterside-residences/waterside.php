<?php
require_once __DIR__ . '/../../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    } else {
        echo "Invalid request method.";
    }
    exit;
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Collect form data (phone field: mobile, number, or phone)
$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['mobile'] ?? $_POST['number'] ?? $_POST['phone'] ?? '');

// Validate name (2+ chars)
if (strlen($name) < 2) {
    $err = 'Name must be at least 2 characters.';
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['success' => false, 'message' => $err]); exit; }
    echo "<script>alert('$err'); window.history.back();</script>"; exit;
}

// Validate phone (10+ digits)
$phoneDigits = preg_replace('/\D/', '', $phone);
if (strlen($phoneDigits) < 10) {
    $err = 'Please enter a valid phone number (10+ digits).';
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['success' => false, 'message' => $err]); exit; }
    echo "<script>alert('$err'); window.history.back();</script>"; exit;
}

// Validate email (optional but valid if present)
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = 'Please enter a valid email address.';
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['success' => false, 'message' => $err]); exit; }
    echo "<script>alert('$err'); window.history.back();</script>"; exit;
}

// Build API payload
$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phoneDigits,
    'source'       => 'Krisumi Waterside Residences | https://krisumiresidences.in',
]);

// POST to API
$apiUrl = env('API_URL');
$token  = env('API_TOKEN');

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token,
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 30,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_errno($ch);
curl_close($ch);

// SSL retry fallback for WAMP dev
if ($curlErr === 60 || $curlErr === 77) {
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => $payload,
        CURLOPT_HTTPHEADER      => [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $token,
        ],
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_TIMEOUT         => 30,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_SSL_VERIFYHOST  => 0,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
}

sendPpcLead($name, $email, $phone, 'https://krisumiresidences.in', 'Gurugram', 'Krisumi Waterside Residences');

// Handle response
$success = ($httpCode >= 200 && $httpCode < 300);

if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([
        'success'  => $success,
        'message'  => $success ? 'Thank you for your enquiry!' : 'Something went wrong. Please try again.',
        'redirect' => $success ? 'thankyou.php' : null,
    ]);
    exit;
}

if ($success) {
    header("Location: thankyou.php");
    exit;
}

echo "Something went wrong. Please try again.";
