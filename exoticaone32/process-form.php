<?php
/**
 * Lead form handler — Exotica One32
 * Flow: validate -> MoneyTree API -> JSON response
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../env.php';

/** ------------------------------------------------------------------
 *  Helpers
 *  ----------------------------------------------------------------- */
function json_out(array $payload, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($payload);
    exit;
}

function clean(?string $v): string
{
    return htmlspecialchars(trim((string)$v), ENT_QUOTES, 'UTF-8');
}

function valid_name(string $n): bool
{
    return (bool)preg_match('/^[A-Za-z\s\-\.\']{2,100}$/u', $n);
}

function valid_phone(string $p): bool
{
    $digits = preg_replace('/\D+/', '', $p);
    return strlen($digits) >= 10 && strlen($digits) <= 15;
}

/** ------------------------------------------------------------------
 *  CSRF — issue token on GET, verify on POST
 *  ----------------------------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf'])) {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    json_out(['token' => $_SESSION['csrf_token']]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_out(['status' => 'error', 'message' => 'Invalid request method'], 405);
}

// XHR guard (cheap anti-CSRF layer)
$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
if (strcasecmp($xhr, 'XMLHttpRequest') !== 0) {
    json_out(['status' => 'error', 'message' => 'Invalid request'], 400);
}

// CSRF token check
$postedToken  = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['csrf_token'] ?? '';
if ($sessionToken === '' || !hash_equals($sessionToken, (string)$postedToken)) {
    json_out(['status' => 'error', 'message' => 'Security token invalid. Please refresh and try again.'], 419);
}

/** ------------------------------------------------------------------
 *  Input
 *  ----------------------------------------------------------------- */
$name           = clean($_POST['name']           ?? '');
$email          = clean($_POST['email']          ?? '');
$phoneRaw       = clean($_POST['phone']          ?? '');
$interested_in  = clean($_POST['interested_in']  ?? 'General Enquiry');
$form_source    = clean($_POST['form_source']    ?? 'website');

$phoneDigits = preg_replace('/\D+/', '', $phoneRaw);
if (strlen($phoneDigits) > 10 && str_starts_with($phoneDigits, '91')) {
    $phoneDigits = substr($phoneDigits, -10);
}

if (!valid_name($name)) {
    json_out(['status' => 'error', 'message' => 'Please enter a valid name.'], 422);
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_out(['status' => 'error', 'message' => 'Please enter a valid email.'], 422);
}
if (!valid_phone($phoneDigits)) {
    json_out(['status' => 'error', 'message' => 'Please enter a valid 10-digit phone number.'], 422);
}

/** ------------------------------------------------------------------
 *  Send to MoneyTree CRM
 *  ----------------------------------------------------------------- */
$apiUrl    = env('API_URL',    'https://moneytreerealty.com/api/ppc-organic');
$authToken = env('API_TOKEN',  '');
$source    = env('API_SOURCE', 'Exotica One32 | https://exoticaone32.org');

$payload = json_encode([
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phoneDigits,
    'source'       => $source,
]);

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $authToken,
    ],
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$apiResponse = curl_exec($ch);
$httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError   = curl_error($ch);

// Dev fallback: retry without SSL verification if cert path missing (WAMP)
if ($apiResponse === false && stripos($curlError, 'SSL certificate') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $apiResponse = curl_exec($ch);
    $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError   = curl_error($ch);
}
curl_close($ch);

$apiOk = ($httpCode >= 200 && $httpCode < 300);

/** ------------------------------------------------------------------
 *  Rotate CSRF token on success to prevent replay
 *  ----------------------------------------------------------------- */
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

if ($apiOk) {
    json_out([
        'status'    => 'success',
        'message'   => 'Thank you. Our team will reach out within 24 hours.',
        'csrf'      => $_SESSION['csrf_token'],
        'redirect'  => 'thank-you.php',
    ]);
}

json_out([
    'status'  => 'error',
    'message' => 'We received your details but could not reach our CRM. Our team will contact you shortly.',
    'csrf'    => $_SESSION['csrf_token'],
], 202);
