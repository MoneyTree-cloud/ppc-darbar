<?php
/**
 * Shared env loader for all PPC sites.
 * Loads the root .env (API_URL, API_TOKEN) automatically.
 * Sites call env('KEY', 'default') to read values.
 */

function loadEnv(string $path): void
{
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (strpos($line, '=') === false) continue;

        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);

        if (!isset($_ENV[$key])) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

function env(string $key, string $default = ''): string
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

function sendPpcLead(string $name, string $email, string $phone, string $websiteUrl, string $location, string $source): void
{
    $url = env('PPC_LEAD_API_URL', 'https://backend.moneytreerealty.com/lead/ppc-lead/create') . '?' . http_build_query([
        'name'         => $name,
        'email'        => $email,
        'mobileNumber' => $phone,
        'websiteUrl'   => $websiteUrl,
        'location'     => $location,
        'source'       => $source,
    ]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => '',
        CURLOPT_HTTPHEADER     => ['Accept: */*'],
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => env('SSL_VERIFY', 'true') === 'true',
        CURLOPT_SSL_VERIFYHOST => env('SSL_VERIFY', 'true') === 'true' ? 2 : 0,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = $response === false ? curl_error($ch) : null;

    if ($error !== null) {
        error_log("$websiteUrl [ppc-lead API] curl error | URL: $url | $error");
    } elseif ($httpCode >= 200 && $httpCode < 300) {
        error_log("$websiteUrl [ppc-lead API] success | HTTP $httpCode | Response: " . substr($response, 0, 500));
    } else {
        error_log("$websiteUrl [ppc-lead API] error | HTTP $httpCode | Response: " . substr($response, 0, 500));
    }
}

// Auto-load root .env
loadEnv(__DIR__ . '/.env');
