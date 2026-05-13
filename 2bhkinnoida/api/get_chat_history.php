<?php
/**
 * Real Estate Chatbot API - Get Chat History Endpoint
 * This file retrieves chat history for a specific lead.
 */

// Include configuration
require_once '../config/config.php';
require_once '../api/auth.php';

// Set content type to JSON
header('Content-Type: application/json');

// Only allow authenticated users to access this endpoint
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Get lead ID from query string
$leadId = isset($_GET['lead_id']) ? $_GET['lead_id'] : null;

if (!$leadId) {
    http_response_code(400);
    echo json_encode(['error' => 'Lead ID is required']);
    exit;
}

// Validate leadId is numeric only to prevent path traversal
if (!preg_match('/^\d+$/', $leadId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid Lead ID format']);
    exit;
}

// Try to get from database first
$pdo = getDbConnection();
$chatHistory = null;

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT chat_history FROM leads WHERE id = ?");
        $stmt->execute([$leadId]);
        $result = $stmt->fetch();

        if ($result && isset($result['chat_history'])) {
            $chatHistory = json_decode($result['chat_history'], true);
        }
    } catch (PDOException $e) {
        error_log("Error getting chat history from database: " . $e->getMessage());
        // Continue to file-based approach if database fails
    }
}

// If not found in database, try file-based approach
if ($chatHistory === null) {
    $leadsDir = DATA_DIR . '/leads';
    $leadFile = $leadsDir . '/' . $leadId . '.json';

    // Validate with realpath to prevent directory traversal
    $realLeadsDir = realpath($leadsDir);
    $realLeadFile = realpath($leadFile);

    if ($realLeadFile === false || $realLeadsDir === false || strpos($realLeadFile, $realLeadsDir) !== 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Lead not found']);
        exit;
    }

    if (file_exists($realLeadFile)) {
        $leadData = json_decode(file_get_contents($realLeadFile), true);

        if (isset($leadData['chat_history'])) {
            $chatHistory = $leadData['chat_history'];
        } else {
            $chatHistory = [];
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Lead not found']);
        exit;
    }
}

// Return chat history
echo json_encode([
    'success' => true,
    'lead_id' => $leadId,
    'chat_history' => $chatHistory
]);
