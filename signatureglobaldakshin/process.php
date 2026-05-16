<?php
require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

date_default_timezone_set('Asia/Kolkata');
header('Content-Type: application/json');

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? ($_POST['number'] ?? ''));
$message = trim($_POST['message'] ?? '');


// ==================================================
// 1. VALIDATION
// ==================================================

$errors = [];
if ($name === '') $errors[] = 'Name is required';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid Email is required';
if ($phone === '' || !preg_match('/^[0-9]{10,}$/', $phone)) $errors[] = 'Phone number must be at least 10 digits';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}




$domain = 'signatureglobaldakshin.in'; 
$domainName = 'Signature Global Dakshin'; // Changed to use projectName
$ip = $_SERVER['REMOTE_ADDR'];
$bot = 'Human';
$status = "New lead";
$read_status = "unread";
$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct Access';

$postedDateTime = $_POST['date_time'] ?? '';  // Example: 2025-09-25T16:42

// Correct parsing for datetime-local input
$date = date('Y-m-d H:i:s');



// ==================================================
// 5. SEND TO MONEYTREE CRM API
// ==================================================

$apiUrl   = env('API_URL');
$apiToken = env('API_TOKEN');
$source   = 'Signature Global Dakshin | https://signatureglobaldakshin.in';

$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'source'       => $source,
], JSON_UNESCAPED_UNICODE);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken,
    ],
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_CONNECTTIMEOUT => 8
]);

$apiResponse = curl_exec($ch);
$httpCode    = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($apiResponse === false && stripos(curl_error($ch), 'SSL') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $apiResponse = curl_exec($ch);
    $httpCode    = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
}
curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://signatureglobaldakshin.in', 'Gurugram', 'Signature Global Dakshin');

$apiOk = ($httpCode >= 200 && $httpCode < 300);

// ==================================================
// 6. JSON RESPONSE
// ==================================================

echo json_encode(['success' => true, 'message' => 'Thank you! Our team will contact you shortly.', 'redirect' => 'thankyou.php']);
exit;
?>
