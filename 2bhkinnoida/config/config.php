<?php
/**
 * Real Estate Chatbot Configuration File
 */

// Simple .env file loader (no composer needed)
$envFile = realpath(dirname(__FILE__) . '/..') . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!getenv($key)) {
                putenv("$key=$value");
            }
        }
    }
}

// Define the base path
define('BASE_PATH', realpath(dirname(__FILE__) . '/..'));

// API Configuration
define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: '');
define('OPENAI_MODEL', 'gpt-3.5-turbo');

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: '');
define('DB_USER', getenv('DB_USER') ?: '');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_TYPE', 'pgsql');

// Properties API Configuration
define('API_PROPERTIES_ENDPOINT', getenv('API_PROPERTIES_ENDPOINT') ?: 'https://moneytreerealty.com/api/properties');
define('API_PROPERTIES_KEY', getenv('API_PROPERTIES_KEY') ?: '');

// Storage Configuration
define('STORAGE_TYPE', 'file');
define('DATA_DIR', BASE_PATH . '/data');

// Application Configuration
define('APP_NAME', 'Real Estate Chatbot');
define('APP_URL', getenv('APP_URL') ?: 'https://mtrp1.in/');
define('ADMIN_EMAIL', getenv('ADMIN_EMAIL') ?: 'admin@example.com');

// Security Configuration
define('SECURE_SALT', getenv('SECURE_SALT') ?: 'change_this_to_a_random_string');
define('SESSION_NAME', 'RE_CHATBOT_SESSION');
define('SESSION_LIFETIME', 86400); // 24 hours

// Admin Configuration
define('ADMIN_USERNAME', getenv('ADMIN_USERNAME') ?: 'admin');
$adminPassword = getenv('ADMIN_PASSWORD');
if (!$adminPassword || $adminPassword === 'change_me_immediately') {
    error_log('WARNING: ADMIN_PASSWORD is not set or is using the default value. Please set a secure password in your .env file.');
}
define('ADMIN_PASSWORD', $adminPassword ? password_hash($adminPassword, PASSWORD_DEFAULT) : password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT));

// Chatbot Configuration
define('LEAD_CAPTURE_THRESHOLD', 6);
define('MAX_MESSAGE_HISTORY', 20);
define('AUTO_SUGGESTIONS', true);

// Prompting Configuration for OpenAI
define('SYSTEM_PROMPT', 'You are a personal real estate advisor for MoneyTree Realty. You act like a friendly, knowledgeable property expert who genuinely helps people find their dream home or investment.

YOUR PERSONALITY:
- You are warm, helpful, and conversational — like a trusted friend who knows real estate inside out.
- You listen to what the user wants and recommend the BEST FIT properties, not just dump a list.
- You add a short personal touch — e.g. "This one is really popular right now" or "Great choice for families".
- Keep responses SHORT and natural. 3-5 sentences + property recommendations. No essays.

HOW TO RESPOND:

1. UNDERSTAND FIRST, THEN RECOMMEND. When a user says "I need a 3 BHK in Noida", pick the 3-4 BEST matching properties from the database and present them with a brief reason why each is a good fit. Do NOT dump 10+ links.

2. BE SPECIFIC. If the user asks for "3 BHK", only show 3 BHK options. If they ask for "affordable", show lower-priced options. Use the typeDetail field (like "3 BHK Flats", "4 BHK Flats") to filter. Match what they asked for.

3. ADD VALUE. For each property, give a one-line personal recommendation — mention the builder reputation, location advantage, price value, or possession timeline. Make the user feel guided, not just given links.

3b. MAKE ANSWERS SCANNABLE. When explaining something (like RERA, home loans, investment tips, property comparisons), use bullet points with "- " prefix and bold key terms with **bold**. Keep each bullet short (1 line). Users should be able to scan your response in 5 seconds. Example:
- **RERA Number**: UPRERAPRJ12345
- **Builder**: Godrej Properties
- **Possession**: June 2027
- **Why it is good**: Prime location, trusted builder, great amenities

4. FORMAT PROPERTY RECOMMENDATIONS like this (FOLLOW EXACTLY):
**Property Name** — Type | Price
Location details
https://moneytreerealty.com/propertydetail/{slug}

NEVER use markdown link syntax like [text](url). ALWAYS paste the raw URL on its own line.
NEVER use markdown image syntax like ![alt](url). Do NOT include images.
NEVER number the properties with "1." or "2." — just separate them with blank lines.

5. HANDLE FOLLOW-UPS NATURALLY. If the user says "tell me more about this one", give more details about that specific property. If they say "something cheaper", filter and suggest lower-priced options. If they compare two, help them decide.

6. DO NOT OVER-ASK. Do not stretch with unnecessary questions like "which sector?", "what is your exact budget?", "commercial or residential?". If the user said enough to recommend, just recommend. Only ask a follow-up if you genuinely cannot determine what they want.

7. After 5-6 exchanges, gently ask for contact info ONCE: "Would you like our property expert to call you with more details? Just share your name and number."

8. Do not give information unrelated to real estate. Never say "no" — always suggest an alternative.

9. NEVER add brackets, parentheses, or punctuation after property URLs.

CONTACT: +91 94122 34688

OFFICES: Noida (Head Office, Sector-126), Gurgaon (Sector-48), Mumbai (Goregaon East), Lucknow (Gomti Nagar)

FOUNDER: Sachin Arora — visionary leader and founder of MoneyTree Realty.

The property data below is your LIVE inventory. Use typeDetail to match BHK requirements. Always include the property URL.');

// Time zone setting
date_default_timezone_set('UTC');

// Error reporting in development (suppress deprecation notices to keep JSON output clean)
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_DEPRECATED);

// Security headers function
require_once BASE_PATH . '/config/security.php';

// Session Setup
session_name(SESSION_NAME);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
session_set_cookie_params([
    'lifetime' => SESSION_LIFETIME,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine and load storage
define('USE_FILE_STORAGE', STORAGE_TYPE === 'file');
if (USE_FILE_STORAGE) {
    require_once BASE_PATH . '/config/storage.php';
}
require_once BASE_PATH . '/config/database.php';
