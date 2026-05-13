<?php
// Start session (for future use if needed)
session_start();

// Always return JSON
header('Content-Type: application/json');

function sanitize($value)
{
    return htmlspecialchars(stripslashes(trim($value)));
}

function valid_phone($phone)
{
    $digits = ltrim($phone, '0');
    return preg_match('/^[0-9]{10}$/', $digits);
}

// Only handle POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Grab & sanitize
$name      = sanitize($_POST['name']      ?? '');
$email     = sanitize($_POST['email']     ?? '');
$phone     = sanitize($_POST['phone']     ?? '');
$form_type = sanitize($_POST['form_type'] ?? 'contact');

// Basic validation
if ($name === '') {
    echo json_encode(['status' => 'error', 'message' => 'Name is required']);
    exit;
}
if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid email is required']);
    exit;
}
if (! valid_phone($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Valid 10-digit phone number is required']);
    exit;
}

// Send external API call
$apiUrl = 'https://moneytreerealty.in/api/ppc-organic';
$authToken = '5|piMqzEcvaQxxj3M78A7SxgZVx0w4LAmY6dIBTuKJ82d1d6cc';
$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'form_type'    => $form_type,
    'source'       => 'Exotica one | https://exoticaone32.org'
]);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $authToken
    ],
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Optionally, you could log $httpCode and $response to a file here

// All done: tell the front-end to redirect
echo json_encode([
    'status'   => 'success',
    'redirect' => 'thank-you.php'
]);
exit;
