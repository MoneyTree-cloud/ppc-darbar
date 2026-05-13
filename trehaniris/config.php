<?php
require_once __DIR__ . '/../env.php';

/**
 * Trehan Iris Broadway — PPC Landing Page Configuration
 * ======================================================
 */

// Environment
define('ENVIRONMENT', 'production'); // 'development' or 'production'

// Error reporting
if (ENVIRONMENT === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// Output buffering with gzip
if (!ob_get_level()) {
    ob_start('ob_gzhandler');
}

// Rate-limit lock directory
define('RATE_LIMIT_DIR', __DIR__ . '/.rate');

// Site configuration
define('SITE_NAME', 'Trehan Iris Broadway');
define('SITE_URL', 'https://trehaniris.info');
define('SITE_PHONE', '+919412234688');
define('SITE_PHONE_DISPLAY', '9412-234-688');
define('SITE_EMAIL', 'info@trehaniris.info');
define('SITE_WHATSAPP', '919412234688');

// Property details
define('PROPERTY_NAME', 'Trehan Iris Broadway');
define('PROPERTY_LOCATION', 'Sector 85, Gurgaon');
define('PROPERTY_TYPE', 'Premium Commercial Spaces');
define('PROPERTY_DEVELOPER', 'Trehan Group');
define('PROPERTY_RERA', '168 Of 2017');
define('PROPERTY_PRICE_START', '₹45 Lac');
define('PROPERTY_TAGLINE', 'Premium Commercial Destination in Sector 85, Gurgaon');

// Company details (for schema)
define('COMPANY_NAME', 'Trehan Group');
define('COMPANY_ADDRESS', 'Sector 85, Gurugram, Haryana');
define('COMPANY_CITY', 'Gurugram');
define('COMPANY_STATE', 'Haryana');
define('COMPANY_ZIP', '122004');
define('COMPANY_COUNTRY', 'IN');

// Tracking IDs — replace with real values
define('GTM_ID', 'GTM-XXXXXXX');
define('GA4_ID', 'G-XXXXXXXXXX');
define('GADS_CONVERSION_ID', 'AW-XXXXXXXXX');
define('GADS_CONVERSION_LABEL', 'XXXXXXXXXXXXXXXXXX');
define('FB_PIXEL_ID', '');
define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

// MoneyTree Realty Lead API
define('MT_API_URL', env('API_URL', 'https://moneytreerealty.com/api/ppc-organic'));
define('MT_API_TOKEN', env('API_TOKEN'));
define('MT_LEAD_SOURCE', PROPERTY_NAME . ' | ' . SITE_URL);

// Rate limiting
define('MAX_SUBMISSIONS_PER_HOUR', 3);

// Cache settings
define('CACHE_ENABLED', false);
define('CACHE_DIR', __DIR__ . '/cache/');
define('CACHE_TTL', 3600);


// -------------------------------------------------------------------
// Helper functions
// -------------------------------------------------------------------

/** Sanitize user input */
function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/** Generate CSRF token */
function generateCSRFToken(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Validate CSRF token */
function validateCSRFToken(string $token): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/** Simple A/B testing */
function getVariant(string $test_name, array $variants = ['A', 'B']): string {
    $cookie_name = 'ab_' . md5($test_name);
    if (isset($_COOKIE[$cookie_name])) {
        return $_COOKIE[$cookie_name];
    }
    $variant = $variants[array_rand($variants)];
    setcookie($cookie_name, $variant, time() + (86400 * 30), '/');
    return $variant;
}

/** Get UTM parameters from URL */
function getUTMParams(): array {
    $params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid'];
    $values = [];
    foreach ($params as $p) {
        $values[$p] = sanitize($_GET[$p] ?? '');
    }
    return $values;
}

/** Rate limiting check by IP (file-based) */
function isRateLimited(string $ip): bool {
    $dir = RATE_LIMIT_DIR;
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
        @file_put_contents($dir . '/.htaccess', "Require all denied\n");
    }
    $file = $dir . '/' . md5($ip) . '.json';
    $now  = time();
    $window = 3600; // 1 hour

    $timestamps = [];
    if (is_file($file)) {
        $timestamps = json_decode(file_get_contents($file), true) ?: [];
        $timestamps = array_filter($timestamps, fn($t) => ($now - $t) < $window);
    }

    if (count($timestamps) >= MAX_SUBMISSIONS_PER_HOUR) {
        return true;
    }

    $timestamps[] = $now;
    @file_put_contents($file, json_encode(array_values($timestamps)), LOCK_EX);
    return false;
}

/** Send lead to MoneyTree Realty API (primary CRM) */
function sendToMoneyTreeAPI(array $lead): bool {
    if (empty(MT_API_URL)) return false;

    $payload = json_encode([
        'name'         => $lead['name'],
        'email'        => $lead['email'] ?: '',
        'phone_number' => $lead['phone'],
        'source'       => MT_LEAD_SOURCE,
    ]);

    $ch = curl_init(MT_API_URL);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . MT_API_TOKEN,
        ],
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Retry without SSL if cert fails (dev environments like WAMP)
    if ($response === false && strpos(curl_error($ch), 'SSL certificate') !== false) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);

    $success = $httpCode >= 200 && $httpCode < 300;

    return $success;
}

/** Page caching (optional) */
function serveCache(): void {
    if (!CACHE_ENABLED) return;
    $cache_file = CACHE_DIR . md5($_SERVER['REQUEST_URI']) . '.html';
    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < CACHE_TTL) {
        readfile($cache_file);
        exit;
    }
}

function saveCache(string $content): void {
    if (!CACHE_ENABLED) return;
    $cache_file = CACHE_DIR . md5($_SERVER['REQUEST_URI']) . '.html';
    if (!is_dir(CACHE_DIR)) {
        mkdir(CACHE_DIR, 0755, true);
    }
    file_put_contents($cache_file, $content);
}
