<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('X-Content-Type-Options: nosniff');

// CSRF — issue token on GET, verify on POST.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['csrf'])) {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['token' => $_SESSION['csrf_token']]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
    if (strcasecmp($xhr, 'XMLHttpRequest') !== 0) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }

    $postedToken  = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    if ($sessionToken === '' || !hash_equals($sessionToken, (string)$postedToken)) {
        http_response_code(419);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'message' => 'Security token invalid. Please refresh and try again.']);
        exit;
    }
}

// Strip a leading "91" country code, matching this site's prior behavior.
$phoneDigits = preg_replace('/\D+/', '', $_POST['phone'] ?? '');
if (strlen($phoneDigits) > 10 && str_starts_with($phoneDigits, '91')) {
    $phoneDigits = substr($phoneDigits, -10);
}
$_POST['phone'] = $phoneDigits;

handleLeadForm([
    'project'      => 'Exotica One32',
    'city'         => 'Noida',
    'website'      => 'https://exoticaone32.org',
    'redirect'     => 'thank-you.php',
    'requireEmail' => false,
    'message'      => 'Thank you. Our team will reach out within 24 hours.',
]);
