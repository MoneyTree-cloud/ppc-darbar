<?php
/**
 * Real Estate Chatbot API - Lead Capture Endpoint
 * This file handles lead capture from the chatbot interface.
 */

// Include configuration
require_once '../config/config.php';

// Apply security headers
applySecurityHeaders();

// Set content type to JSON
header('Content-Type: application/json');

// Handle CORS
applyCorsHeaders();

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Check if method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Rate limiting: 3 lead submissions per IP per hour
$clientIp = getClientIp();
if (!checkRateLimit('lead_' . $clientIp, 3, 3600)) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many submissions. Please try again later.']);
    exit;
}

// Get JSON data from request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validate input
if (!$data || !isset($data['name']) || !isset($data['phone'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data']);
    exit;
}

// Extract data
$name = trim($data['name']);
$phone = trim($data['phone']);
$requirements = isset($data['requirements']) ? trim($data['requirements']) : '';
$chatHistory = isset($data['chatHistory']) ? $data['chatHistory'] : [];
$websiteId = isset($data['websiteId']) ? $data['websiteId'] : 'default';

// Input length validation
if (strlen($name) > 255) {
    http_response_code(400);
    echo json_encode(['error' => 'Name is too long. Maximum 255 characters allowed.']);
    exit;
}

if (strlen($requirements) > 5000) {
    http_response_code(400);
    echo json_encode(['error' => 'Requirements text is too long. Maximum 5000 characters allowed.']);
    exit;
}

// Sanitize input
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$requirements = htmlspecialchars($requirements, ENT_QUOTES, 'UTF-8');

// Validate phone number format (must be exactly 10 digits)
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['error' => 'Phone number must be exactly 10 digits']);
    exit;
}

try {
    // Cookie to mark as submitted lead
    setcookie('lead_submitted', '1', time() + 86400 * 30, '/');

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Lead captured successfully'
    ]);

    // Send notification email to admin (optional)
    sendLeadNotification($name, $phone, $requirements);

} catch (Exception $e) {
    error_log("Lead capture error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to capture lead. Please try again later.']);
    exit;
}

/**
 * Send notification email about new lead
 *
 * @param string $name Lead name
 * @param string $phone Lead phone
 * @param string $requirements Lead requirements
 */
function sendLeadNotification($name, $phone, $requirements) {
    // Check if mail function is available
    if (!function_exists('mail')) {
        return;
    }

    $to = ADMIN_EMAIL;
    $subject = "New Real Estate Lead Captured";

    $message = "A new lead has been captured from the chatbot:\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Requirements: " . ($requirements ?: "Not specified") . "\n\n";
    $message .= "Please follow up with this lead as soon as possible.\n";
    $message .= "This is an automated message from " . APP_NAME . ".";

    $headers = "From: " . APP_NAME . " <noreply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ">\r\n";
    $headers .= "Reply-To: no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\n";

    // Send email (don't rely on the result as it may fail silently)
    @mail($to, $subject, $message, $headers);
}
