<?php
require_once __DIR__ . '/../env.php';
session_start();

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts   = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Sanitize and validate input data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$recaptcha_response = $_POST['recaptcha_response'] ?? '';

// Backend validation with improved phone validation
$errors = [];

// Name validation
if (empty($name) || strlen($name) < 2) {
    $errors[] = "Name is required and must be at least 2 characters long";
} elseif (strlen($name) > 50) {
    $errors[] = "Name must be less than 50 characters";
} elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
    $errors[] = "Name can only contain letters and spaces";
}

// Email validation
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email address is required";
}

// Improved phone validation (10-11 digits)
if (empty($phone)) {
    $errors[] = "Phone number is required";
} else {
    $cleanPhone = preg_replace('/\D/', '', $phone); // Remove all non-digits

    if (!preg_match('/^\d{10,11}$/', $cleanPhone)) {
        $errors[] = "Please enter a valid 10-11 digit phone number";
    } elseif (strlen($cleanPhone) === 11 && !preg_match('/^91/', $cleanPhone)) {
        $errors[] = "For 11-digit numbers, please start with 91 (India country code)";
    }

    // Update phone to clean version
    $phone = $cleanPhone;
}

// Verify reCAPTCHA (skipped in dev when SSL_VERIFY=false)
if (!$sslVerify) {
    error_log("3bhkinnoida [recaptcha] skipped in dev mode");
} elseif (empty($recaptcha_response)) {
    $errors[] = "Security verification failed. Please try again.";
} else {
    $recaptcha_secret = "6Lf-j8kqAAAAAMOzDUGjGA-e1ydJKU6jjKeNyJqq";

    $rch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($rch, $sslOpts + [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
    ]);

    $recaptcha_result = curl_exec($rch);
    $recaptchaError   = $recaptcha_result === false ? curl_error($rch) : null;

    if ($recaptchaError !== null) {
        error_log("3bhkinnoida [recaptcha] curl error: $recaptchaError");
        $errors[] = "Security verification failed. Please try again.";
    } else {
        $recaptcha_response_data = json_decode($recaptcha_result, true);
        error_log("3bhkinnoida [recaptcha] response: " . $recaptcha_result);

        if (empty($recaptcha_response_data['success']) || ($recaptcha_response_data['score'] ?? 0) < 0.5) {
            $errors[] = "Security verification failed. Please try again.";
        }
    }
}

// If there are validation errors, return them
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
    'project'      => '3BHK in Noida',
    'source'       => '3BHK in Noida | https://3bhkinnoida.in/'
]);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $authToken,
    ],
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 10,
]);

$apiResponse = curl_exec($ch);
$httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$chError     = $apiResponse === false ? curl_error($ch) : null;

if ($chError !== null) {
    error_log("3bhkinnoida [main API] curl error | URL: $apiUrl | $chError");
} elseif ($httpCode >= 200 && $httpCode < 300) {
    error_log("3bhkinnoida [main API] success | HTTP $httpCode | Response: " . substr($apiResponse, 0, 500));
} else {
    error_log("3bhkinnoida [main API] error | HTTP $httpCode | Response: " . substr($apiResponse, 0, 500));
}

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://3bhkinnoida.in/', 'Noida', '3BHK in Noida');


echo json_encode(['success' => true, 'message' => 'Thank you for your interest! Our executive will connect with you shortly.', 'redirect' => 'thankyou.php']);
exit();
