<?php
session_start();
require_once __DIR__ . '/../env.php';

$sslVerify = env('SSL_VERIFY', 'true') === 'true';
$sslOpts = [
    CURLOPT_SSL_VERIFYPEER => $sslVerify,
    CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
];


function validateInput($data): string
{
    return htmlspecialchars(stripslashes(trim((string)$data)));
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if ($isAjax) {
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit();
    }
    header("Location: index.php");
    exit();
}

$name = $email = $phone = $message = $formSource = $interestedIn = '';
$errors = [];

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

if (isset($_POST['phone'])) {
    $phone = validateInput($_POST['phone']);
    $phone_digits = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) {
        $errors[] = "Phone number must be 10 digits";
    }
} else {
    $errors[] = "Phone field is missing";
}

$interestedIn = isset($_POST['interested_in']) ? validateInput($_POST['interested_in']) : '';
if (empty($interestedIn)) {
    $interestedIn = 'General Enquiry';
}

$message    = isset($_POST['message']) ? validateInput($_POST['message']) : '';
$formSource = isset($_POST['form_source']) ? validateInput($_POST['form_source']) : 'hero_form';
$formType   = $formSource === 'popup_form' ? 'Popup Form' : 'Lead Form';

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

// --- 1. Send to API with Bearer token ---
$apiUrl   = env('API_URL', 'https://moneytreerealty.com/api/ppc-organic');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'Great Value High Life | https://highlifenoida.in');

$postData = [
    "name"         => $name,
    "email"        => $email,
    "phone_number" => $phone,
    "source"       => $source,
];

$ch = curl_init($apiUrl);
curl_setopt_array($ch, $sslOpts + [
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
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Retry without SSL verification if cert fails (dev/WAMP fallback)
if ($response === false && strpos((string)curl_error($ch), 'SSL certificate') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $phone, 'https://highlifenoida.in', 'Noida', 'Great Value High Life');


$msg = "Thank you for your interest in Great Value High Life. Our team will contact you shortly.";
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
    exit();
}
$_SESSION['form_success'] = $msg;
header("Location: thankyou.php");
exit();


