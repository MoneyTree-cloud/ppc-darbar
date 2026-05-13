<?php
session_start();
require_once __DIR__ . '/../env.php';

function validateInput($data): string
{
    return htmlspecialchars(stripslashes(trim((string) $data)));
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    if ($isAjax) {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        exit;
    }
    header("Location: index.php");
    exit;
}

$name = $email = $phone = $message = $formSource = $interestedIn = '';
$errors = [];

// Name
if (isset($_POST['name'])) {
    $name = validateInput($_POST['name']);
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) {
        $errors[] = "Name contains invalid characters";
    }
} else {
    $errors[] = "Name field is missing";
}

// Email
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

// Phone
if (isset($_POST['phone'])) {
    $phone = validateInput($_POST['phone']);
    $phoneDigits = preg_replace('/[^0-9]/', '', $phone);
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (strlen($phoneDigits) < 10 || strlen($phoneDigits) > 15) {
        $errors[] = "Phone number must be 10–15 digits";
    }
} else {
    $errors[] = "Phone field is missing";
}

// Optional
$interestedIn = isset($_POST['interested_in']) ? validateInput($_POST['interested_in']) : '';
$formSource   = isset($_POST['form_source']) ? validateInput($_POST['form_source']) : 'hero_form';
$message      = isset($_POST['message']) ? validateInput($_POST['message']) : '';

$formTypeMap = [
    'hero_form'      => 'Hero Form',
    'popup_form'     => 'Popup Form',
    'contact_form'   => 'Contact Form',
    'pricing_form'   => 'Pricing Form',
    'brochure_form'  => 'Brochure Form',
    'residence_form' => 'Residence Form',
    'final_cta_form' => 'Final CTA Form',
    'exit_intent'    => 'Exit Intent Form',
];
$formType = $formTypeMap[$formSource] ?? 'Lead Form';

if (!empty($errors)) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit;
    }
    $_SESSION['form_errors'] = $errors;
    header("Location: index.php#contact");
    exit;
}

// --- 1. Send to API ---
$apiUrl   = env('API_URL');
$apiToken = env('API_TOKEN');
$source   = env('API_SOURCE', 'M3M Jacob Co Residences | https://jewelcrestnoida.com');

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

if ($response === false && strpos((string) curl_error($ch), 'SSL certificate') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

curl_close($ch);

$msg = "Thank you for your interest in M3M Jacob & Co Residences. Our private client team will reach out shortly.";
if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
    exit;
}
$_SESSION['form_success'] = $msg;
header("Location: thankyou.php");
exit;


