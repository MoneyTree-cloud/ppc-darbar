<?php
require_once __DIR__ . '/../env.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$mobile   = trim($_POST['mobile'] ?? '');
$property = trim($_POST['propertyname'] ?? 'Elan The Statement');

if (strlen($name) < 2 || !preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
    echo "<script>alert('Please fill all required fields correctly.'); window.history.back();</script>";
    exit;
}

$ch = curl_init(env('API_URL'));
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode([
        'name'         => $name,
        'email'        => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '',
        'phone_number' => $mobile,
        'source'       => $property . ' | Elan The Statement | https://elanthestatement49.in',
    ]),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . env('API_TOKEN'),
    ],
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2,
]);
$response = curl_exec($ch);
if ($response === false && stripos(curl_error($ch), 'SSL') !== false) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_exec($ch);
}
curl_close($ch);

// PPC Lead API Call
sendPpcLead($name, $email, $mobile, 'https://elanthestatement49.in', 'Gurugram', 'Elan The Statement');

header('Location: thankyou.php');
exit;
