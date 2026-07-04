<?php
/**
 * Shared lead-form handler for all PPC sites.
 * Validate -> honeypot -> rate-limit -> sanitize -> POST to CRM + PPC Lead API.
 * Each site's process-form.php stays as its own file and just calls
 * handleLeadForm() with its own project config.
 */

require_once __DIR__ . '/../env.php';

function clean_text(mixed $value): string
{
    $value = trim((string)($value ?? ''));
    $value = stripslashes($value);
    $value = strip_tags($value);
    $collapsed = preg_replace('/\s+/u', ' ', $value);
    return (string)($collapsed ?? $value);
}

function clean_email(mixed $value): string
{
    $filtered = filter_var(trim((string)($value ?? '')), FILTER_SANITIZE_EMAIL);
    return $filtered === false ? '' : $filtered;
}

function clean_phone(mixed $value): string
{
    $value   = trim((string)($value ?? ''));
    $hasPlus = str_starts_with($value, '+');
    $digits  = preg_replace('/\D+/', '', $value) ?? '';
    return ($hasPlus ? '+' : '') . $digits;
}

function lead_form_is_ajax(): bool
{
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

// $message may be a single string or an array of separate error strings
// (kept distinct so non-AJAX session-flash pages can render one <li> each).
function lead_form_finish(bool $success, string|array $message, string $redirect, int $httpCode = 200): never
{
    $text = is_array($message) ? implode('. ', $message) : $message;

    if (lead_form_is_ajax()) {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success, 'message' => $text], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $_SESSION[$success ? 'form_success' : 'form_errors'] = $success ? $text : (is_array($message) ? $message : [$message]);
    header("Location: $redirect");
    exit;
}

// Per IP+project sliding-window limit, backed by a small JSON file per key.
function lead_form_rate_limited(string $key, int $maxRequests, int $windowSeconds): bool
{
    $dir = __DIR__ . '/../data/rate_limits';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $file = $dir . '/' . md5($key) . '.json';
    $now  = time();
    $hits = [];

    if (file_exists($file)) {
        $data = json_decode((string)file_get_contents($file), true);
        if (is_array($data)) {
            $hits = array_values(array_filter($data, fn($t) => ($now - $t) < $windowSeconds));
        }
    }

    if (count($hits) >= $maxRequests) {
        return true;
    }

    $hits[] = $now;
    file_put_contents($file, json_encode($hits));
    return false;
}

/**
 * Required $config keys: project, city, website, redirect.
 * Optional: message, errorRedirect (defaults to redirect; use when a site
 * sends successes and errors to different anchors/pages), phonePattern
 * (regex tested against digits-only phone, defaults to a generic 10-15
 * digit check), phoneError, requiredFields (map of extra POST field name =>
 * error message shown when that field is empty, e.g. ['interested_in' =>
 * 'Please select what you are interested in']), honeypotField (defaults to
 * "website"), nameMaxLength (default 80), requireEmail (default true; set
 * false to make email optional while still validating its format if
 * provided), rateLimitMax (default 5),
 * rateLimitWindowSeconds (default 345600 = 96h), apiUrl (defaults to
 * env('API_URL')), phoneField (the outgoing payload key for the phone
 * number, default "phone_number"), extraPayload (array merged into the
 * outgoing CRM JSON payload, applied after the base name/email/phoneField/
 * source keys so it can override them), sourceOverride (defaults to the
 * existing env('API_SOURCE', "{project} | {website}") behavior).
 */
function handleLeadForm(array $config): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $project         = $config['project'];
    $city            = $config['city'];
    $website         = $config['website'];
    $redirect        = $config['redirect'];
    $errorRedirect   = $config['errorRedirect'] ?? $redirect;
    $message         = $config['message'] ?? "Thank you for your interest in {$project}! Our team will contact you shortly.";
    $honeypotField   = $config['honeypotField'] ?? 'website';
    $nameMaxLength   = $config['nameMaxLength'] ?? 80;
    $requireEmail    = $config['requireEmail'] ?? true;
    $rateLimitMax    = $config['rateLimitMax'] ?? 5;
    $rateLimitWindow = $config['rateLimitWindowSeconds'] ?? 345600;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        if (lead_form_is_ajax()) {
            http_response_code(405);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }
        header("Location: $redirect");
        exit;
    }

    // Honeypot: hidden field real users never fill in; bots that fill every field do.
    // Pretend success so bots don't learn to skip it.
    if (!empty($_POST[$honeypotField])) {
        lead_form_finish(true, $message, $redirect);
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (lead_form_rate_limited("$ip:$project", $rateLimitMax, $rateLimitWindow)) {
        lead_form_finish(false, 'Too many submissions. Please try again later.', $errorRedirect, 429);
    }

    $name  = clean_text($_POST['name'] ?? '');
    $email = clean_email($_POST['email'] ?? '');
    $phone = clean_phone($_POST['mobile'] ?? $_POST['phone'] ?? '');

    $errors = [];

    if ($name === '') {
        $errors[] = 'Name is required';
    } elseif (mb_strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters';
    } elseif (mb_strlen($name) > $nameMaxLength) {
        $errors[] = 'Name is too long';
    } elseif (!preg_match("/^[\p{L}\s.'\\-]+$/u", $name)) {
        $errors[] = 'Name contains invalid characters';
    }

    if ($email === '' && $requireEmail) {
        $errors[] = 'Email is required';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    } elseif (mb_strlen($email) > 120) {
        $errors[] = 'Email is too long';
    }

    $phoneDigits = preg_replace('/\D+/', '', $phone) ?? '';
    if ($phoneDigits === '') {
        $errors[] = 'Phone number is required';
    } elseif (isset($config['phonePattern'])) {
        if (!preg_match($config['phonePattern'], $phoneDigits)) {
            $errors[] = $config['phoneError'] ?? 'Please enter a valid phone number';
        }
    } elseif (strlen($phoneDigits) < 10 || strlen($phoneDigits) > 15) {
        $errors[] = 'Phone number must be 10 to 15 digits';
    }

    foreach ($config['requiredFields'] ?? [] as $field => $errorMsg) {
        if (empty($_POST[$field] ?? '')) {
            $errors[] = $errorMsg;
        }
    }

    if (!empty($errors)) {
        lead_form_finish(false, $errors, $errorRedirect, 422);
    }

    // --- Send to CRM API ---
    $apiUrl    = $config['apiUrl'] ?? env('API_URL');
    $apiToken  = env('API_TOKEN');
    $source    = $config['sourceOverride'] ?? env('API_SOURCE', "{$project} | {$website}");
    $sslVerify = env('SSL_VERIFY', 'true') === 'true';

    $phoneField = $config['phoneField'] ?? 'phone_number';

    $payload = array_merge([
        'name'        => $name,
        'email'       => $email,
        $phoneField   => $phone,
        'source'       => $source,
    ], $config['extraPayload'] ?? []);

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $apiToken,
        ],
        CURLOPT_SSL_VERIFYPEER => $sslVerify,
        CURLOPT_SSL_VERIFYHOST => $sslVerify ? 2 : 0,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);

    $response = curl_exec($ch);
    if ($response === false && strpos(curl_error($ch), 'SSL certificate') !== false) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_exec($ch);
    }
    curl_close($ch);

    // --- PPC Lead API ---
    sendPpcLead($name, $email, $phoneDigits, $website, $city, $project);

    lead_form_finish(true, $message, $redirect);
}
