<?php
/**
 * Health Check Endpoint
 * Returns system status for monitoring and load balancers.
 */

require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

$status = [
    'status' => 'healthy',
    'timestamp' => gmdate('c'),
    'checks' => []
];

// Check PHP version
$status['checks']['php'] = [
    'status' => 'ok',
    'version' => PHP_VERSION
];

// Check data directory writable
$dataWritable = is_dir(DATA_DIR) && is_writable(DATA_DIR);
$status['checks']['storage'] = [
    'status' => $dataWritable ? 'ok' : 'error',
    'type' => STORAGE_TYPE
];

// Check OpenAI key configured
$status['checks']['openai'] = [
    'status' => !empty(OPENAI_API_KEY) && OPENAI_API_KEY !== 'your_openai_api_key_here' ? 'ok' : 'unconfigured'
];

// Check database (if not using file storage)
if (STORAGE_TYPE !== 'file') {
    $pdo = getDbConnection();
    $status['checks']['database'] = [
        'status' => $pdo ? 'ok' : 'error'
    ];
}

// Overall status
$allOk = true;
foreach ($status['checks'] as $check) {
    if ($check['status'] === 'error') {
        $allOk = false;
        break;
    }
}
$status['status'] = $allOk ? 'healthy' : 'degraded';

http_response_code($allOk ? 200 : 503);
echo json_encode($status, JSON_PRETTY_PRINT);
