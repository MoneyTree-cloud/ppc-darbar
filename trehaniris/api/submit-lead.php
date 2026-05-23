<?php
/**
 * Lead Submission Handler (AJAX)
 * Validates, sends to API, sends email, triggers webhook
 */
require_once __DIR__ . '/../config.php';

// Only accept POST + AJAX
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method.', 405);
}

// CSRF validation
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$csrf = $_POST['csrf_token'] ?? '';
if (!validateCSRFToken($csrf)) {
    jsonResponse(false, 'Invalid security token. Please refresh the page and try again.', 403);
}

// Honeypot check (bot detection)
if (!empty($_POST['website'])) {
    // Silently reject — looks like success to the bot
    jsonResponse(true, 'Thank you! We will contact you shortly.');
}

// Rate limiting
$ip = $_SERVER['REMOTE_ADDR'];
if (isRateLimited($ip)) {
    jsonResponse(false, 'Too many submissions. Please try again later or call us directly at ' . SITE_PHONE_DISPLAY . '.', 429);
}

// Sanitize & validate inputs
$name  = sanitize($_POST['name'] ?? '');
$phone = sanitize($_POST['phone'] ?? '');
$email = sanitize($_POST['email'] ?? '');

// Validation
$errors = [];
if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please enter your name.';
}
if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
    $errors[] = 'Please enter a valid 10-digit Indian mobile number.';
}
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if (!empty($errors)) {
    jsonResponse(false, implode(' ', $errors), 422);
}

// reCAPTCHA v3 validation (if configured)
if (RECAPTCHA_SECRET_KEY !== '') {
    $recaptcha_token = $_POST['g-recaptcha-response'] ?? '';
    if (!verifyRecaptcha($recaptcha_token)) {
        jsonResponse(false, 'Security verification failed. Please try again.', 403);
    }
}

// Build lead data
$lead = [
    'name'          => $name,
    'phone'         => $phone,
    'email'         => $email,
    'utm_source'    => sanitize($_POST['utm_source'] ?? ''),
    'utm_medium'    => sanitize($_POST['utm_medium'] ?? ''),
    'utm_campaign'  => sanitize($_POST['utm_campaign'] ?? ''),
    'utm_term'      => sanitize($_POST['utm_term'] ?? ''),
    'utm_content'   => sanitize($_POST['utm_content'] ?? ''),
    'gclid'         => sanitize($_POST['gclid'] ?? ''),
    'landing_page'  => sanitize($_POST['landing_page'] ?? ''),
    'ip_address'    => $ip,
    'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'ab_variant'    => sanitize($_POST['variant'] ?? 'A'),
];

// 1. Send to MoneyTree Realty API (primary)
$apiSuccess = sendToMoneyTreeAPI($lead);

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'http://trehaniris.info', 'Gurugram', 'Trehan Iris Broadway');

// Success
jsonResponse(true, 'Thank you! Our expert will call you within 30 minutes.');

// -------------------------------------------------------------------
// Helper functions
// -------------------------------------------------------------------

function jsonResponse(bool $success, string $message, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

function verifyRecaptcha(string $token): bool {
    if (empty($token)) return false;
    $sslVerify = env('SSL_VERIFY', 'true') === 'true';
    $sslOpts = [
        CURLOPT_SSL_VERIFYPEER => $sslVerify,
        CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
    ];


    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'],
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, $sslOpts + [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return false;

    $result = json_decode($response, true);
    return ($result['success'] ?? false) && ($result['score'] ?? 0) >= 0.5;
}
