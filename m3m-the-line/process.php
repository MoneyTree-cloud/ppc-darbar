<?php
require_once __DIR__ . '/../env.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Prevent caching
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// Helper to send JSON errors
function sendJsonError($message, $code = 400)
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit;
}

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonError('Invalid request method.', 405);
}

// Sanitize inputs
$name  = isset($_POST['name'])  ? trim(htmlspecialchars($_POST['name']))  : '';
$email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
$phone = isset($_POST['phone']) ? trim(htmlspecialchars($_POST['phone'])) : '';

// Validate
// Name: required, only letters & spaces, between 2–100 chars
if (empty($name) || !preg_match("/^[A-Za-z\s]{2,100}$/", $name)) {
    sendJsonError('Name is required and should contain only letters and spaces (2–100 characters).');
}

// Email: sanitize then validate
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJsonError('A valid email address is required.');
}

// Phone: required, digits only
if (empty($phone) || !preg_match('/^[0-9]+$/', $phone)) {
    sendJsonError('A valid phone number is required (digits only).');
}

// --- Fire off the PPC/organic API call ---
$apiUrl    = env('API_URL');
$authToken = env('API_TOKEN');
$payload   = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'source'       => 'M3M The Line | https://m3m-the-line.in'
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
$apiResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Thank you! We will get back to you shortly.',
    'redirect' => 'thankyou.php'
]);
exit;
