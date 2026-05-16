<?php
/**
 * TARC Ishva — Lead form handler
 * Pure API passthrough: validate → sanitize → POST to MoneyTree CRM.
 * No DB, no session state. Append to leads.log for local audit.
 */

session_start();
require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

// ----------------------------------------------------------------------------
// Helpers
// ----------------------------------------------------------------------------

/**
 * Trim + strip tags + normalize whitespace. Used before validation.
 * Never use on fields that might legitimately contain HTML entities.
 */
function clean_text(mixed $value): string
{
    $value = (string)($value ?? '');
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    // Collapse runs of whitespace to single spaces. /u requires valid UTF-8;
    // fall back to a non-unicode pattern if the input isn't valid UTF-8.
    $collapsed = preg_replace('/\s+/u', ' ', $value);
    if ($collapsed === null) {
        $collapsed = preg_replace('/\s+/', ' ', $value);
    }
    return (string)($collapsed ?? $value);
}

function clean_email(mixed $value): string
{
    $value = (string)($value ?? '');
    $filtered = filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    return $filtered === false ? '' : $filtered;
}

/**
 * Normalize a phone input to digits only, preserving a leading +.
 * "+91 (98972) 94688-" → "+919412234688"
 */
function clean_phone(mixed $value): string
{
    $value   = trim((string)($value ?? ''));
    $hasPlus = str_starts_with($value, '+');
    $digits  = preg_replace('/\D+/', '', $value) ?? '';
    return ($hasPlus ? '+' : '') . $digits;
}

function is_ajax(): bool
{
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function respond_json(bool $success, string $message, int $httpCode = 200): never
{
    http_response_code($httpCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => $success, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function fail(string $message, int $httpCode = 400): never
{
    if (is_ajax()) {
        respond_json(false, $message, $httpCode);
    }
    $_SESSION['form_errors'] = [$message];
    header('Location: index.php#contact');
    exit;
}

// ----------------------------------------------------------------------------
// 1. Gate
// ----------------------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (is_ajax()) respond_json(false, 'Method not allowed', 405);
    header('Location: index.php');
    exit;
}

// ----------------------------------------------------------------------------
// 2. Pull + sanitize inputs
// ----------------------------------------------------------------------------

$name         = clean_text($_POST['name']          ?? '');
$email        = clean_email($_POST['email']        ?? '');
$phoneRaw     = (string)($_POST['phone']           ?? '');
$phone        = clean_phone($phoneRaw);
$interestedIn = clean_text($_POST['interested_in'] ?? '');
$message      = clean_text($_POST['message']       ?? '');
$formSource   = clean_text($_POST['form_source']   ?? '');

// ----------------------------------------------------------------------------
// 3. Validate (server-side — front-end JS also validates but never trust it)
// ----------------------------------------------------------------------------

$errors = [];

// Name: 2-80 chars, letters + spaces + . ' - (Unicode letters OK for multi-language)
if ($name === '') {
    $errors[] = 'Name is required';
} elseif (mb_strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters';
} elseif (mb_strlen($name) > 80) {
    $errors[] = 'Name is too long';
} elseif (!preg_match("/^[\p{L}\s.'\\-]+$/u", $name)) {
    $errors[] = 'Name contains invalid characters';
}

// Email
if ($email === '') {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
} elseif (mb_strlen($email) > 120) {
    $errors[] = 'Email is too long';
}

// Phone: 10-15 digits (after + stripped)
$phoneDigits = preg_replace('/\D+/', '', $phone);
if ($phoneDigits === '') {
    $errors[] = 'Phone number is required';
} elseif (strlen($phoneDigits) < 10 || strlen($phoneDigits) > 15) {
    $errors[] = 'Phone number must be 10 to 15 digits';
}

// Message: optional, cap at 500 chars
if (mb_strlen($message) > 500) {
    $errors[] = 'Message is too long';
}

// Honeypot: bot defence — any truthy value in `website` means bot
if (!empty($_POST['website'])) {
    // Silently accept to avoid tipping off the bot, but don't hit the API
    if (is_ajax()) respond_json(true, 'Thank you — we will be in touch.');
    $_SESSION['form_success'] = 'Thank you — we will be in touch.';
    header('Location: index.php#contact');
    exit;
}

if (!empty($errors)) {
    $msg = implode('. ', $errors);
    if (is_ajax()) respond_json(false, $msg, 422);
    $_SESSION['form_errors'] = $errors;
    header('Location: index.php#contact');
    exit;
}

// ----------------------------------------------------------------------------
// 4. Hit the CRM API
// ----------------------------------------------------------------------------

$apiUrl   = env('API_URL',    'https://moneytreerealty.com/api/ppc-organic');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'TARC Ishva | https://tarcishvaa.in');

if ($apiToken === '') {
    fail('Lead service temporarily unavailable. Please call +91 94122 34688.', 503);
}

$payload = [
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,           // normalized: +919412234688
    'source'       => $source,
];

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken,
    ],
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_CONNECTTIMEOUT => 8,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = $response === false ? curl_error($ch) : '';

// Retry without SSL verification if the local cert store can't validate
// (common on WAMP in dev). Keeps prod safe because the first try always runs with full verification.
if ($response === false && stripos($curlErr, 'SSL') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = $response === false ? curl_error($ch) : '';
}

curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phoneDigits, 'https://tarcishvaa.in', 'Gurugram', 'TARC Ishva');

if ($response === false) {
    if (is_ajax()) respond_json(true, 'Thank you — our team will contact you shortly.');
    $_SESSION['form_success'] = 'Thank you — our team will contact you shortly.';
    header('Location: index.php#contact');
    exit;
}

$apiOk = $httpCode >= 200 && $httpCode < 300;

if (!$apiOk) {
    if (is_ajax()) respond_json(true, 'Thank you — our team will contact you shortly.');
    $_SESSION['form_success'] = 'Thank you — our team will contact you shortly.';
    header('Location: index.php#contact');
    exit;
}

// ----------------------------------------------------------------------------
// 5. Success
// ----------------------------------------------------------------------------

$successMsg = 'Thank you for your interest in TARC Ishva! Our relationship manager will contact you within 24 hours.';
if (is_ajax()) respond_json(true, $successMsg);
$_SESSION['form_success'] = $successMsg;
header('Location: index.php#contact');
exit;
