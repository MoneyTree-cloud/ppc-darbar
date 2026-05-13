<?php
session_start();
require_once __DIR__ . '/../env.php';

function validateInput($data): string
{
    return htmlspecialchars(stripslashes(trim((string) $data)));
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isAjax) {
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }
    header('Location: index.php');
    exit;
}

$name = $email = $phone = $interestedIn = $formSource = '';
$errors = [];

// Name
if (isset($_POST['name'])) {
    $name = validateInput($_POST['name']);
    if ($name === '') {
        $errors[] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters long';
    } elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) {
        $errors[] = 'Name contains invalid characters';
    }
} else {
    $errors[] = 'Name field is missing';
}

// Email
if (isset($_POST['email'])) {
    $email = validateInput($_POST['email']);
    if ($email === '') {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
} else {
    $errors[] = 'Email field is missing';
}

// Phone (accept both 'phone' and legacy 'mobile')
$phoneRaw = $_POST['phone'] ?? $_POST['mobile'] ?? null;
if ($phoneRaw !== null) {
    $phone        = validateInput($phoneRaw);
    $phone_digits = preg_replace('/[^0-9]/', '', $phone);
    if ($phone === '') {
        $errors[] = 'Phone number is required';
    } elseif (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) {
        $errors[] = 'Phone number must be between 10 and 15 digits';
    }
} else {
    $errors[] = 'Phone field is missing';
}

// Optional context
$interestedIn = isset($_POST['interested_in']) ? validateInput($_POST['interested_in']) : '';
$formSource   = isset($_POST['form_source'])   ? validateInput($_POST['form_source'])   : 'hero_form';

$formTypeBase = 'Lead Form';
$formType     = trim($formTypeBase . ' | ' . $formSource . ($interestedIn ? ' | ' . $interestedIn : ''));

if (!empty($errors)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit;
    }
    $_SESSION['form_errors'] = $errors;
    header('Location: index.php');
    exit;
}

// --- 1. Send to CRM API ---
$apiUrl   = env('API_URL', 'https://moneytreerealty.com/api/ppc-organic');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Smartworld Elie Saab Residences | https://eliesaab98.in');

$postData = [
    'name'         => $name,
    'email'        => $email,
    'phone_number' => $phone,
    'source'       => $source,
];

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($postData),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken,
    ],
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// SSL retry fallback
if ($response === false && strpos(curl_error($ch), 'SSL certificate') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

$curlError = $response === false ? curl_error($ch) : '';
curl_close($ch);

$msg = 'Thank you for your interest in Smartworld Elie Saab Residences. Our team will contact you shortly.';

if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
    exit;
}

$_SESSION['form_success'] = $msg;
header('Location: thankyou.php');
exit;


