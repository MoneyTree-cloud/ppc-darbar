<?php
require_once __DIR__ . '/../env.php';
session_start();

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];


function validateInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function jsonResponse(array $data): void
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$name = $email = $phone = '';
$errors = [];

if (isset($_POST['name'])) {
    $name = validateInput($_POST['name']);
    if (empty($name)) {
        $errors[] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters long';
    } elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) {
        $errors[] = 'Name contains invalid characters';
    }
} else {
    $errors[] = 'Name field is missing';
}

if (isset($_POST['email'])) {
    $email = validateInput($_POST['email']);
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
} else {
    $errors[] = 'Email field is missing';
}

if (isset($_POST['phone'])) {
    $phone       = validateInput($_POST['phone']);
    $phoneDigits = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    } elseif (strlen($phoneDigits) < 10 || strlen($phoneDigits) > 15) {
        $errors[] = 'Phone number must be between 10 and 15 digits';
    }
} else {
    $errors[] = 'Phone field is missing';
}

if (!empty($errors)) {
    if ($isAjax) {
        jsonResponse(['success' => false, 'message' => implode('. ', $errors)]);
    }
    $_SESSION['form_errors'] = $errors;
    header('Location: index.php#contact');
    exit();
}

// Main API
$apiUrl   = env('API_URL');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Paras Meerut Plots | https://parasmeerutplots.com');

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode([
        'name'         => $name,
        'email'        => $email,
        'phone_number' => $phone,
        'source'       => $source,
    ]),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiToken,
    ],
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_CONNECTTIMEOUT => 10,
]);

$response  = curl_exec($ch);
$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$chError   = $response === false ? curl_error($ch) : null;

if ($chError !== null) {
    error_log("parasmeerutplots [main API] curl error | URL: $apiUrl | $chError");
    if ($isAjax) {
        jsonResponse(['success' => false, 'message' => 'Server error. Please try again later.']);
    }
    $_SESSION['form_error'] = 'Server error. Please try again later.';
    header('Location: index.php#contact');
    exit();
} elseif ($httpCode >= 200 && $httpCode < 300) {
    error_log("parasmeerutplots [main API] success | HTTP $httpCode | Response: " . substr($response, 0, 500));
} else {
    error_log("parasmeerutplots [main API] error | HTTP $httpCode | Response: " . substr($response, 0, 500));
}

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://parasmeerutplots.com', 'Meerut', 'Paras Meerut Plots');

if ($httpCode >= 200 && $httpCode < 300) {
    if ($isAjax) {
        jsonResponse(['success' => true, 'message' => 'Thank you! Our team will contact you shortly.', 'redirect' => 'thank-you.php']);
    }
    header('Location: thank-you.php');
    exit();
}

if ($isAjax) {
    jsonResponse(['success' => false, 'message' => 'Sorry, there was an error. Please try again later.']);
}
$_SESSION['form_error'] = 'Sorry, there was an error processing your request. Please try again later.';
header('Location: index.php#contact');
exit();
