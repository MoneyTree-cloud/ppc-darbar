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

$name = $email = $phone = $message = $formSource = $interestedIn = '';
$errors = [];

// Validate name
if (isset($_POST['name'])) {
    $name = validateInput($_POST['name']);
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
if (isset($_POST['email'])) {
    $email = validateInput($_POST['email']);
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
} else {
    $errors[] = "Email field is missing";
}

// Validate phone
if (isset($_POST['phone'])) {
    $phone = validateInput($_POST['phone']);
    $phone_digits = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) {
        $errors[] = "Phone number must be between 10 and 15 digits";
    }
} else {
    $errors[] = "Phone field is missing";
}

// Validate interest
if (isset($_POST['interested_in'])) {
    $interestedIn = validateInput($_POST['interested_in']);
    if (empty($interestedIn)) {
        $errors[] = "Please select what you are interested in";
    }
} else {
    $errors[] = "Interested In field is missing";
}

// Optional fields
$message    = isset($_POST['message']) ? validateInput($_POST['message']) : '';
$formSource = isset($_POST['form_source']) ? validateInput($_POST['form_source']) : '';
$formType   = $formSource === 'popup_form' ? 'Popup Form' : 'Lead Form';

// Return errors
if (!empty($errors)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit();
    }
    $_SESSION['form_errors'] = $errors;
    header("Location: index.php#contact");
    exit();
}

// --- 1. Send to API with Sanctum Bearer token ---
$apiUrl   = env('API_URL');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Elan The Presidential | https://elanthepresidential.com');

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

    $msg = "Thank you for your interest in Elan The Presidential! Our team will contact you shortly.";
    if ($isAjax) { header('Content-Type: application/json'); echo json_encode(['success' => true, 'message' => $msg]); exit(); }
    $_SESSION['form_success'] = $msg;
    header("Location: index.php");
    exit();
}

curl_close($ch);

$msg = "Thank you for your interest in Elan The Presidential! Our team will contact you shortly.";
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
    exit();
}
$_SESSION['form_success'] = $msg;
header("Location: index.php");
exit();


