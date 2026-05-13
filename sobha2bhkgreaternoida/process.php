



<?php
require_once __DIR__ . '/../env.php';
ini_set('display_errors', 0);

header('Content-Type: application/json');

// **IMPORTANT**: Replace with your actual reCAPTCHA secret key
define('RECAPTCHA_SECRET_KEY', '6Lf-j8kqAAAAAMOzDUGjGA-e1ydJKU6jjKeNyJqq');

// API Configuration
define('API_URL', env('API_URL'));
define('API_BEARER_TOKEN', env('API_TOKEN'));

if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Grab & trim
$name            = trim($_POST['name'] ?? '');
$email           = trim($_POST['email'] ?? '');
$phone           = trim($_POST['phone'] ?? '');
$recaptcha_token = $_POST['recaptcha_token'] ?? '';

// 1) reCAPTCHA check
if (empty($recaptcha_token)) {
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA token missing']);
    exit;
}

$verify_url  = 'https://www.google.com/recaptcha/api/siteverify';
$verify_resp = file_get_contents(
    $verify_url .
        '?secret=' . urlencode(RECAPTCHA_SECRET_KEY) .
        '&response=' . urlencode($recaptcha_token)
);

$recaptcha = json_decode($verify_resp, true);
if (empty($recaptcha['success'])) {
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA verification failed']);
    exit;
}

// 2) Validate form fields
$errors = [];
if ($name === '') {
    $errors[] = 'Name is required';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required';
}
if ($phone === '' || !preg_match('/^[0-9\-\+\s\(\)]+$/', $phone)) {
    $errors[] = 'Valid phone number is required';
}
if ($errors) {
    echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
    exit;
}

// 3) External API call
$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'source'       => 'Sobha Greater Noida | https://sobha2bhkgreaternoida.in/'
]);

$ch = curl_init(API_URL);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . API_BEARER_TOKEN,
    ],
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT        => 10, // 10 second timeout
]);
$api_response = curl_exec($ch);
$api_code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error   = curl_error($ch);
curl_close($ch);

// Continue with success response even if API fails
// reCAPTCHA verified successfully

// 5) Final JSON response
$response = [
    'status'   => 'success',
    'message'  => 'Lead processed successfully.',
    'redirect' => 'thank-you.php'
];

echo json_encode($response);
exit;
