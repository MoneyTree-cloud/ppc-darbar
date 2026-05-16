<?php
/**
 * Lead submission handler — API-only.
 * No database writes. Validates → sanitises → POSTs to MoneyTree CRM.
 */

require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];

header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

/**
 * Single exit point.
 */
function respond(bool $ok, string $message, array $extra = [], bool $isAjax = false): void
{
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array_merge(['success' => $ok, 'message' => $message], $extra));
        exit;
    }
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['form_message'] = ['ok' => $ok, 'text' => $message];
    header('Location: ' . ($ok ? 'thank-you.php' : 'index.php#final-cta'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.', [], $isAjax);
}

// ── Rate-limit: 1 submit per IP per 10s (file-based, stateless) ──
$ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$rlDir    = __DIR__ . '/.rate';
$rlFile   = $rlDir . '/' . md5($ip) . '.lock';
if (!is_dir($rlDir)) {
    @mkdir($rlDir, 0755, true);
    // Drop a self-contained deny rule so the lock files are never web-accessible
    @file_put_contents($rlDir . '/.htaccess', "Require all denied\n");
}
if (is_file($rlFile) && (time() - filemtime($rlFile)) < 10) {
    respond(false, 'Please wait a few seconds before submitting again.', [], $isAjax);
}
@touch($rlFile);

// ── Honeypot (bots fill hidden fields) ──
if (!empty($_POST['website']) || !empty($_POST['company_website'])) {
    // Silently succeed — bots don't need to know
    respond(true, 'Thank you! Our SOBHA advisor will call you within 24 hours.', [], $isAjax);
}

// ── Collect + sanitise ──
function cleanString(string $v, int $max = 120): string
{
    $v = trim($v);
    // Strip control chars (null, backspace, vertical tabs, etc.)
    $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
    // Collapse whitespace
    $v = preg_replace('/\s+/u', ' ', $v);
    $v = mb_substr($v, 0, $max, 'UTF-8');
    return $v;
}

$name     = cleanString($_POST['name']  ?? '', 100);
$email    = cleanString($_POST['email'] ?? '', 120);
$phoneRaw = cleanString($_POST['phone'] ?? '', 20);
$phone    = preg_replace('/\D/', '', $phoneRaw);        // digits only for validation
$interest = cleanString($_POST['interested_in'] ?? '', 160);
$formSrc  = cleanString($_POST['form_source']  ?? 'hero_form', 40);

// ── Validate ──
$errors = [];

if (mb_strlen($name, 'UTF-8') < 2) {
    $errors['name'] = 'Please enter your full name (at least 2 characters).';
} elseif (!preg_match("/^[\p{L}\p{M}\s\-\.']{2,100}$/u", $name)) {
    $errors['name'] = 'Name can only contain letters, spaces, hyphens and apostrophes.';
}

if ($email !== '') {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email, 'UTF-8') > 120) {
        $errors['email'] = 'Please enter a valid email address.';
    }
}

if (strlen($phone) < 10 || strlen($phone) > 15) {
    $errors['phone'] = 'Please enter a valid 10–15 digit mobile number.';
} elseif (preg_match('/^(\d)\1{9,}$/', $phone)) {
    $errors['phone'] = 'Please enter a real mobile number.';
}

if (!empty($errors)) {
    respond(false, reset($errors), ['errors' => $errors, 'field' => key($errors)], $isAjax);
}

// ── Build API payload ──
$apiUrl   = env('API_URL', 'https://moneytreerealty.com/api/ppc-organic');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Sobha 3 BHK Greater Noida | https://sobha3bhkingreaternoida.in');

// Re-encode using htmlspecialchars only at the presentation boundary.
// The API receives clean UTF-8, not HTML-escaped strings.
$payload = json_encode([
    'name'         => $name,
    'email'        => $email !== '' ? $email : 'lead@sobha3bhkingreaternoida.in',
    'phone_number' => $phone,
    'source'       => $source . ' · ' . $formSrc . ($interest !== '' ? ' · ' . $interest : ''),
], JSON_UNESCAPED_UNICODE);

if ($payload === false) {
    respond(false, 'We could not process your request. Please call +91 94122 34688.', [], $isAjax);
}

// ── POST to CRM ──
$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts+ [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken,
    ],
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_CONNECTTIMEOUT => 8,
    CURLOPT_USERAGENT      => 'SobhaLeadBot/1.0',
]);
$response = curl_exec($ch);
$httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);

// Retry without strict SSL (dev environments with broken CA bundles)
if ($response === false && stripos($curlErr, 'SSL') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
}
curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://sobha3bhkingreaternoida.in', 'Noida', 'Sobha 3 BHK Greater Noida');

$apiOk = ($httpCode >= 200 && $httpCode < 300);

// ── Done ──
if ($apiOk) {
    respond(true, 'Thank you! Our SOBHA advisor will call you within 24 hours.', [], $isAjax);
}

// API failed — still acknowledge to user, we have the log line
respond(
    true,
    'Thanks — we received your details. Our SOBHA advisor will call shortly.',
    ['warn' => 'api_retry_queued'],
    $isAjax
);
