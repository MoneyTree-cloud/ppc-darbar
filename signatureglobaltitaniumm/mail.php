<?php
require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$country = trim($_POST['country'] ?? '');
$mobile  = trim($_POST['mobile'] ?? '');

// Validate name
if (strlen($name) < 2) {
    $err = 'Name must be at least 2 characters.';
    if ($isAjax) { echo json_encode(['success' => false, 'message' => $err]); exit; }
    die($err);
}

// Combine country code + mobile, strip non-digits
$countryDigits = preg_replace('/\D/', '', $country);
$mobileDigits  = preg_replace('/\D/', '', $mobile);
$phoneDigits   = $countryDigits . $mobileDigits;

// Validate phone (10+ digits)
if (strlen($phoneDigits) < 10) {
    $err = 'Phone number must have at least 10 digits.';
    if ($isAjax) { echo json_encode(['success' => false, 'message' => $err]); exit; }
    die($err);
}

// Validate email (optional but must be valid if present)
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err = 'Invalid email format.';
    if ($isAjax) { echo json_encode(['success' => false, 'message' => $err]); exit; }
    die($err);
}

// Build API payload
$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phoneDigits,
    'source'       => 'Signature Global Titanium | https://signatureglobaltitaniumm.in',
]);

// POST to API
$ch = curl_init(env('API_URL'));
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . env('API_TOKEN'),
    ],
    CURLOPT_TIMEOUT => 15,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phoneDigits, 'https://signatureglobaltitaniumm.in', 'Gurugram', 'Signature Global Titanium');

$ok = $httpCode >= 200 && $httpCode < 300;

if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([
        'success'  => $ok,
        'message'  => $ok ? 'Thank you for your enquiry!' : 'Something went wrong. Please try again.',
        'redirect' => $ok ? 'thankyou.php' : null,
    ]);
    exit;
}

if ($ok) {
    header('Location: thankyou.php');
    exit;
}

echo 'Something went wrong. Please try again.';
