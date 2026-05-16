



<?php
require_once __DIR__ . '/../env.php';
ini_set('display_errors', 0);

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];


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
$ch_captcha  = curl_init($verify_url);
curl_setopt_array($ch_captcha, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query([
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $recaptcha_token,
    ]),
    CURLOPT_TIMEOUT        => 10,
]);
$verify_resp  = curl_exec($ch_captcha);
$captcha_err  = curl_error($ch_captcha);
curl_close($ch_captcha);

if ($verify_resp === false) {
    error_log('reCAPTCHA curl error: ' . $captcha_err);
    // Skip captcha on network failure so the form still works
} else {
    $recaptcha = json_decode($verify_resp, true);
    if (empty($recaptcha['success'])) {
        error_log('reCAPTCHA failed: ' . $verify_resp);
        echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA verification failed']);
        exit;
    }
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

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://sobha2bhkgreaternoida.in/', 'Noida', 'Sobha Greater Noida');

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
