<?php
session_start();
require_once __DIR__ . '/../env.php';

function validateInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if ($isAjax) { http_response_code(405); echo json_encode(['success' => false, 'message' => 'Method not allowed']); exit(); }
    header("Location: index.php");
    exit();
}

$name = $email = $phone = $formSource = '';
$errors = [];

// Accept both field-name formats (name / name_contact, etc.)
$rawName  = $_POST['name']  ?? $_POST['name_contact']  ?? null;
$rawEmail = $_POST['email'] ?? $_POST['email_contact'] ?? null;
$rawPhone = $_POST['phone'] ?? $_POST['phone_contact'] ?? null;

// Validate name
if ($rawName !== null) {
    $name = validateInput($rawName);
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters long";
    } elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) {
        $errors[] = "Name contains invalid characters";
    }
} else {
    $errors[] = "Name field is missing";
}

// Validate email
if ($rawEmail !== null) {
    $email = validateInput($rawEmail);
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
} else {
    $errors[] = "Email field is missing";
}

// Validate phone
if ($rawPhone !== null) {
    $phone = validateInput($rawPhone);
    $phone_digits = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) {
        $errors[] = "Phone number must be between 10 and 15 digits";
    }
} else {
    $errors[] = "Phone field is missing";
}

// Optional fields
$formSource = isset($_POST['form_source']) ? validateInput($_POST['form_source']) : 'website';
$formType   = $formSource === 'popup_form' ? 'Popup Form' : ($formSource === 'banner_form' ? 'Banner Form' : 'Lead Form');

// Return errors
if (!empty($errors)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit();
    }
    $_SESSION['form_errors'] = $errors;
    header("Location: index.php#contact-us");
    exit();
}

// --- 1. Send to API with Sanctum Bearer token ---
$apiUrl   = env('API_URL');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Central Park Delphine | https://centralparkdelphine.info');

$postData = [
    "name"         => $name,
    "email"        => $email,
    "phone_number" => $phone,
    "source"       => $source,
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

// Retry without SSL verification if certificate fails (dev/WAMP only)
if ($response === false && strpos(curl_error($ch), 'SSL certificate') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($response === false) {
    curl_close($ch);

    $msg = "Thank you for your interest in Central Park Delphine! Our team will contact you shortly.";
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['success' => true, 'message' => $msg]); exit(); }
    $_SESSION['form_success'] = $msg;
    header("Location: index.php");
    exit();
}

curl_close($ch);

$msg = "Thank you for your interest in Central Park Delphine! Our team will contact you shortly.";
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
    exit();
}
$_SESSION['form_success'] = $msg;
header("Location: index.php");
exit();


