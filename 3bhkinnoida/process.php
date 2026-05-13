<?php
require_once __DIR__ . '/../env.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Sanitize and validate input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $recaptcha_response = $_POST['recaptcha_response'] ?? '';

    // Backend validation with improved phone validation
    $errors = [];

    // Name validation
    if (empty($name) || strlen($name) < 2) {
        $errors[] = "Name is required and must be at least 2 characters long";
    } elseif (strlen($name) > 50) {
        $errors[] = "Name must be less than 50 characters";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $errors[] = "Name can only contain letters and spaces";
    }

    // Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required";
    }

    // Improved phone validation (10-11 digits)
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } else {
        $cleanPhone = preg_replace('/\D/', '', $phone); // Remove all non-digits

        if (!preg_match('/^\d{10,11}$/', $cleanPhone)) {
            $errors[] = "Please enter a valid 10-11 digit phone number";
        } elseif (strlen($cleanPhone) === 11 && !preg_match('/^91/', $cleanPhone)) {
            $errors[] = "For 11-digit numbers, please start with 91 (India country code)";
        }

        // Update phone to clean version
        $phone = $cleanPhone;
    }

    // Verify reCAPTCHA
    if (empty($recaptcha_response)) {
        $errors[] = "Security verification failed. Please try again.";
    } else {
        // Verify with Google reCAPTCHA
        $recaptcha_secret = "6Lf-j8kqAAAAAMOzDUGjGA-e1ydJKU6jjKeNyJqq";
        $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";

        $recaptcha_data = [
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];

        $recaptcha_options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($recaptcha_data)
            ]
        ];

        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_response_data = json_decode($recaptcha_result, true);

        if (!$recaptcha_response_data['success'] || $recaptcha_response_data['score'] < 0.5) {
            $errors[] = "Security verification failed. Please try again.";
        }
    }

    // If there are validation errors, return them
    if (count($errors) > 0) {
        echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
        exit();
    }

    // --- Fire off the PPC/organic API call ---
    $apiUrl    = env('API_URL');
    $authToken = env('API_TOKEN');
    $payload   = json_encode([
        'name'         => $name,
        'email'        => $email,
        'phone_number' => $phone,
        'project'      => '3BHK in Noida',
        'source'       => '3BHK in Noida | https://3bhkinnoida.in/'
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $authToken
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 second timeout
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For testing - enable in production

    $apiResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

echo json_encode(['success' => true, 'message' => 'Thank you for your interest! Our executive will connect with you shortly.', 'redirect' => 'thankyou.php']);
exit();
