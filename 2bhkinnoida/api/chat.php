<?php
/**
 * Real Estate Chatbot API - Chat Endpoint
 * This file handles incoming chat messages and returns AI responses.
 */

// Include configuration and required files
require_once '../config/config.php';
require_once 'properties_api.php';

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

// Rate limiting: 20 requests per minute per IP
$clientIp = getClientIp();
if (!checkRateLimit('chat_' . $clientIp, 20, 60)) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many requests. Please wait a moment and try again.']);
    exit;
}

// Get JSON data from request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validate input
if (!$data || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request data']);
    exit;
}

// Extract data
$message = trim($data['message']);
$history = $data['history'] ?? [];
$websiteId = $data['websiteId'] ?? 'default';

// Input length validation
if (strlen($message) > 1000) {
    http_response_code(400);
    echo json_encode(['error' => 'Message is too long. Maximum 1000 characters allowed.']);
    exit;
}

// History size validation
if (count($history) > 20) {
    $history = array_slice($history, -20);
}
foreach ($history as $i => $msg) {
    if (isset($msg['content']) && strlen($msg['content']) > 2000) {
        $history[$i]['content'] = substr($msg['content'], 0, 2000);
    }
}

// Sanitize input
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Handle empty message
if (empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Message cannot be empty']);
    exit;
}

// Check if we're using file-based storage, otherwise try to initialize database
if (!defined('STORAGE_TYPE') || STORAGE_TYPE !== 'file') {
    initDatabase();
}

// Create necessary directories for file storage if needed
if (defined('STORAGE_TYPE') && STORAGE_TYPE === 'file') {
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }

    if (!is_dir(DATA_DIR . '/leads')) {
        mkdir(DATA_DIR . '/leads', 0755, true);
    }

    if (!file_exists(DATA_DIR . '/leads.csv')) {
        file_put_contents(DATA_DIR . '/leads.csv', "id,name,phone,email,requirements,status,created_at\n");
    }
}

// Generate or get session ID
$sessionId = $_COOKIE['re_chat_session'] ?? generateSessionId();
setcookie('re_chat_session', $sessionId, [
    'expires' => time() + 86400 * 30,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
]);

// Get database connection
$pdo = getDbConnection();

// Track chat session if database connection is available
if ($pdo) {
    trackChatSession($pdo, $sessionId, $websiteId);
}

// Delete the old message count cookies if they exist to start fresh
if (isset($_COOKIE['message_count'])) {
    setcookie('message_count', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_message_count'])) {
    setcookie('user_message_count', '', time() - 3600, '/');
}

try {
    // Get real estate data context
    $realEstateContext = getRealEstateContext();

    // Prepare message history for OpenAI API
    $messages = [
        [
            'role' => 'system',
            'content' => SYSTEM_PROMPT . "\n\nHere's some information about our real estate properties:\n" . $realEstateContext
        ]
    ];

    // Add conversation history (limited to prevent context length issues)
    $historyLimit = min(count($history), MAX_MESSAGE_HISTORY);
    for ($i = 0; $i < $historyLimit; $i++) {
        $messages[] = [
            'role' => $history[$i]['role'],
            'content' => $history[$i]['content']
        ];
    }

    // Add user's message
    $messages[] = [
        'role' => 'user',
        'content' => $message
    ];

    // Call OpenAI API
    $response = callOpenAI($messages);

    // Count the number of user messages in the history (not including the initial bot greeting)
    $userMessageCount = 0;
    foreach ($history as $msg) {
        if ($msg['role'] === 'user') {
            $userMessageCount++;
        }
    }

    // Add the current message
    $userMessageCount++;

    // If we have a database connection, increment message count and track chat history
    if ($pdo) {
        // Increment message count in database
        incrementMessageCount($pdo, $sessionId);

        // Store chat history in database
        try {
            // Store the user message
            $stmt = $pdo->prepare("
                INSERT INTO `chat_history` (`session_id`, `role`, `content`, `created_at`)
                VALUES (?, 'user', ?, NOW())
            ");
            $stmt->execute([$sessionId, $message]);

            // Store the assistant response
            $stmt = $pdo->prepare("
                INSERT INTO `chat_history` (`session_id`, `role`, `content`, `created_at`)
                VALUES (?, 'assistant', ?, NOW())
            ");
            $stmt->execute([$sessionId, $response]);
        } catch (PDOException $e) {
            // Log error but continue
            error_log("Error storing chat history: " . $e->getMessage());
        }
    }

    // Store the count in a cookie
    setcookie('user_message_count', $userMessageCount, time() + 86400 * 30, '/');

    // Only show lead form after reaching the threshold
    $showLeadForm = $userMessageCount >= LEAD_CAPTURE_THRESHOLD;

    // Generate suggestions if enabled
    $suggestions = AUTO_SUGGESTIONS ? generateSuggestions($response, $message) : [];

    // Return response
    echo json_encode([
        'message' => $response,
        'showLeadForm' => $showLeadForm,
        'suggestions' => $suggestions
    ]);

} catch (Exception $e) {
    error_log("Chat error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to generate response. Please try again later.']);
    exit;
}

/**
 * Call OpenAI API to get a response
 *
 * @param array $messages The conversation history
 * @return string The AI response
 */
function callOpenAI($messages) {
    $apiKey = OPENAI_API_KEY;

    // Check if we have a valid API key
    if ($apiKey === 'your_openai_api_key_here' || empty($apiKey)) {
        // Return a default response if no API key is available
        error_log("Warning: OpenAI API key not configured, using fallback responses");
        return getDefaultResponse($messages);
    }

    $data = [
        'model' => OPENAI_MODEL,
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 500,
        'top_p' => 1,
        'frequency_penalty' => 0,
        'presence_penalty' => 0
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('cURL error: ' . curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['error'])) {
        throw new Exception($responseData['error']['message']);
    }

    if (!isset($responseData['choices'][0]['message']['content'])) {
        throw new Exception('Invalid response from OpenAI API');
    }

    return trim($responseData['choices'][0]['message']['content']);
}

/**
 * Get a default response when OpenAI API key is not available
 *
 * @param array $messages The conversation history
 * @return string A default response
 */
function getDefaultResponse($messages) {
    // Get the last user message
    $lastMessage = end($messages);
    $userMessage = $lastMessage['content'] ?? '';

    // Count the number of user messages in the history
    $userMessageCount = 0;
    foreach ($messages as $msg) {
        if ($msg['role'] === 'user') {
            $userMessageCount++;
        }
    }

    // Fetch properties for location-based fallback responses
    $properties = fetchPropertiesFromAPI();
    if (!is_array($properties)) {
        $properties = getFallbackProperties();
    }

    // Check if user is asking about a specific location
    $locations = ['noida', 'gurgaon', 'gurugram', 'mumbai', 'lucknow', 'greater noida', 'ghaziabad', 'pune', 'meerut', 'indore', 'ayodhya'];
    $matchedLocation = null;
    foreach ($locations as $loc) {
        if (stripos($userMessage, $loc) !== false) {
            $matchedLocation = $loc;
            break;
        }
    }

    if ($matchedLocation || stripos($userMessage, 'property') !== false || stripos($userMessage, 'properties') !== false) {
        // Build property list
        $matching = [];
        foreach ($properties as $p) {
            $locStr = is_array($p['location'] ?? null) ? implode(' ', $p['location']) : ($p['location'] ?? '');
            if (!$matchedLocation || stripos($locStr, $matchedLocation) !== false) {
                $name = $p['name'] ?? 'Property';
                $price = $p['price'] ?? 'Price on request';
                $type = is_array($p['type'] ?? null) ? implode(', ', $p['type']) : ($p['type'] ?? '');
                $typeDetail = is_array($p['typeDetail'] ?? null) ? ' (' . implode(', ', $p['typeDetail']) . ')' : '';
                $loc = is_array($p['location'] ?? null) ? implode(', ', array_slice($p['location'], 0, 2)) : ($p['location'] ?? '');
                $url = isset($p['link']) ? 'https://moneytreerealty.com/propertydetail/' . $p['link'] : '';

                $matching[] = "**{$name}** — {$type}{$typeDetail} | {$price}\n{$loc}\n{$url}";
            }
            if (count($matching) >= 8) break; // Limit to 8 properties
        }

        if (!empty($matching)) {
            $header = $matchedLocation ? "Here are our properties in " . ucfirst($matchedLocation) . ":" : "Here are some of our featured properties:";
            return $header . "\n\n" . implode("\n\n", $matching);
        }
        return "We don't have properties in that specific area right now, but we have great options across Noida, Greater Noida, Gurgaon, Mumbai, Lucknow, and more. Want me to show you what's available?";
    } elseif (stripos($userMessage, 'contact') !== false || stripos($userMessage, 'office') !== false) {
        return "Reach us at **+91 94122 34688**\n\nOffices:\n- Noida: Tower B, Tapasya Corp Heights, Sector-126\n- Gurgaon: JMD Megapolis, Sector-48\n- Mumbai: Corporate Avenue, Goregaon East\n- Lucknow: Cyber Heights, Gomti Nagar";
    } elseif (stripos($userMessage, 'hello') !== false || stripos($userMessage, 'hi') !== false || strlen(trim($userMessage)) < 5) {
        return "Hello! Welcome to MoneyTree Realty. I can help you find properties across Noida, Gurgaon, Mumbai, Lucknow and more. Which location are you interested in?";
    } elseif (stripos($userMessage, 'thank') !== false) {
        return "You're welcome! Feel free to ask about any property or location anytime.";
    } elseif ($userMessageCount > 6 && !isset($_COOKIE['lead_submitted'])) {
        return "Want personalized help? Share your name and number — our property expert will call you with the best options.";
    } else {
        return "I can help you find the perfect property! We have 80+ options across Noida, Greater Noida, Gurgaon, Mumbai, Lucknow and more. Which location interests you?";
    }
}

/**
 * Generate a unique session ID
 *
 * @return string A unique session ID
 */
function generateSessionId() {
    return bin2hex(random_bytes(16));
}

/**
 * Track chat session in database
 *
 * @param PDO $pdo Database connection
 * @param string $sessionId Session ID
 * @param string $websiteId Website ID
 */
function trackChatSession($pdo, $sessionId, $websiteId) {
    try {
        // Check if session exists
        $stmt = $pdo->prepare("SELECT id FROM chat_sessions WHERE session_id = ?");
        $stmt->execute([$sessionId]);

        if ($stmt->rowCount() === 0) {
            // Create new session
            $stmt = $pdo->prepare("
                INSERT INTO chat_sessions
                (session_id, website_id, user_ip, user_agent, started_at, last_message_at)
                VALUES (?, ?, ?, ?, NOW(), NOW())
            ");

            $stmt->execute([
                $sessionId,
                $websiteId,
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        } else {
            // Update existing session
            $stmt = $pdo->prepare("
                UPDATE chat_sessions
                SET last_message_at = NOW()
                WHERE session_id = ?
            ");

            $stmt->execute([$sessionId]);
        }
    } catch (PDOException $e) {
        // Log error but continue
        error_log("Error tracking chat session: " . $e->getMessage());
    }
}

/**
 * Increment message count for a session
 *
 * @param PDO $pdo Database connection
 * @param string $sessionId Session ID
 * @return int New message count
 */
function incrementMessageCount($pdo, $sessionId) {
    try {
        $stmt = $pdo->prepare("
            UPDATE chat_sessions
            SET message_count = message_count + 1,
                last_message_at = NOW()
            WHERE session_id = ?
        ");

        $stmt->execute([$sessionId]);

        $stmt = $pdo->prepare("
            SELECT message_count
            FROM chat_sessions
            WHERE session_id = ?
        ");

        $stmt->execute([$sessionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['message_count'] : 0;
    } catch (PDOException $e) {
        error_log("Error incrementing message count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Check if user has already submitted lead information
 *
 * @param PDO $pdo Database connection
 * @param string $sessionId Session ID
 * @return bool Whether user has submitted lead info
 */
function hasSubmittedLead($pdo, $sessionId) {
    try {
        $stmt = $pdo->prepare("
            SELECT lead_id
            FROM chat_sessions
            WHERE session_id = ? AND lead_id IS NOT NULL
        ");

        $stmt->execute([$sessionId]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Error checking lead submission: " . $e->getMessage());
        return false;
    }
}

/**
 * Get real estate context from the properties API
 * Formats property data concisely for the AI to use in responses.
 *
 * @return string Real estate context for the AI
 */
function getRealEstateContext() {
    $properties = fetchPropertiesFromAPI();
    if (!is_array($properties)) {
        $properties = getFallbackProperties();
    }

    $propertyData = "LIVE PROPERTY DATABASE (" . count($properties) . " properties):\n\n";

    foreach ($properties as $property) {
        $name = $property['name'] ?? 'Unnamed';
        $price = $property['price'] ?? 'Price on request';
        $builder = $property['builder'] ?? '';
        $possession = $property['possession'] ?? '';

        // Location
        $location = 'Unknown';
        if (isset($property['location']) && is_array($property['location'])) {
            $location = implode(', ', array_slice($property['location'], 0, 2));
        } elseif (is_string($property['location'] ?? '')) {
            $location = $property['location'];
        }

        // Type
        $type = 'Not specified';
        if (isset($property['type']) && is_array($property['type'])) {
            $type = implode(', ', $property['type']);
        } elseif (is_string($property['type'] ?? '')) {
            $type = $property['type'];
        }

        // Type detail (BHK info)
        $typeDetail = '';
        if (isset($property['typeDetail']) && is_array($property['typeDetail'])) {
            $typeDetail = ' (' . implode(', ', $property['typeDetail']) . ')';
        }

        // URL
        $url = '';
        if (isset($property['details_url'])) {
            $url = rtrim($property['details_url'], '.,)');
        } elseif (isset($property['link'])) {
            $url = 'https://moneytreerealty.com/propertydetail/' . $property['link'];
        }

        // Thumbnail
        $thumb = '';
        if (isset($property['thumbnails']) && is_array($property['thumbnails']) && !empty($property['thumbnails'])) {
            $thumb = $property['thumbnails'][0];
        }

        $propertyData .= "- **{$name}** | {$type}{$typeDetail} | {$price} | {$location}";
        if ($builder) $propertyData .= " | Builder: {$builder}";
        if ($possession) $propertyData .= " | Possession: {$possession}";
        if ($thumb) $propertyData .= "\n  Image: {$thumb}";
        if ($url) $propertyData .= "\n  URL: {$url}";
        $propertyData .= "\n\n";
    }

    return $propertyData;

}


/**
 * Generate follow-up suggestions based on the AI response and user message
 *
 * @param string $aiResponse The AI's response
 * @param string $userMessage The user's message
 * @return array List of suggested follow-up questions/prompts
 */
function generateSuggestions($aiResponse, $userMessage) {
    // As per request, we're not providing any predefined questions
    return [];
}
