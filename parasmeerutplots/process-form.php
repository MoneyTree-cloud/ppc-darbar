<?php
require_once __DIR__ . '/../env.php';
session_start();

// Environment configuration
$isDevelopment = false; // Set to false for production
$sslVerification = !$isDevelopment; // Disable SSL verification in development

// Input validator
function validateInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $email = $phone = '';
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

    // Determine form type
    $formType = isset($_POST['lead_form']) ? 'Lead Form' : 'Popup Form';

    // If errors
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

    // Data for API
    $apiUrl   = env('API_URL');
    $apiToken = env('API_TOKEN');
    $source   = env('API_SOURCE', 'Paras Meerut Plots | https://parasmeerutplots.com');

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
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
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $curlError = curl_error($ch);
        error_log("parasmeerutplots curl error: $curlError");
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
            exit();
        }
        $_SESSION['form_error'] = "Server error. Please try again later.";
        header("Location: index.php#contact");
        exit();
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode >= 200 && $httpCode < 300) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Thank you! Our team will contact you shortly.', 'redirect' => 'thank-you.php']);
            exit();
        }
        header("Location: thank-you.php");
        exit();
    } else {
        error_log("parasmeerutplots form error | HTTP $httpCode | Response: " . substr($response, 0, 500));
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Sorry, there was an error. Please try again later.']);
            exit();
        }
        $_SESSION['form_error'] = "Sorry, there was an error processing your request. Please try again later.";
        header("Location: index.php#contact");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
