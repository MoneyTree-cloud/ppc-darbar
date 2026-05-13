<?php
function applySecurityHeaders() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

function applyCorsHeaders() {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
}

function checkRateLimit($key, $maxRequests, $windowSeconds, $dataDir = null) {
    $dataDir = $dataDir ?: (defined('DATA_DIR') ? DATA_DIR : __DIR__ . '/../data');
    $rateLimitDir = $dataDir . '/rate_limits';
    if (!is_dir($rateLimitDir)) {
        mkdir($rateLimitDir, 0755, true);
    }

    $file = $rateLimitDir . '/' . md5($key) . '.json';
    $now = time();
    $requests = [];

    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        if (is_array($data)) {
            $requests = array_filter($data, function($t) use ($now, $windowSeconds) {
                return ($now - $t) < $windowSeconds;
            });
        }
    }

    if (count($requests) >= $maxRequests) {
        return false;
    }

    $requests[] = $now;
    file_put_contents($file, json_encode(array_values($requests)));
    return true;
}

function getClientIp() {
    return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}
