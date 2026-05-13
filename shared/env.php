<?php
function loadEnv(string $path = null): void
{
    $sharedEnv = dirname(__DIR__) . "/shared/.env";
    if (file_exists($sharedEnv)) {
        _parseEnvFile($sharedEnv);
    }
    $localEnv = $path ?? dirname(debug_backtrace()[0]["file"]) . "/.env";
    if (file_exists($localEnv)) {
        _parseEnvFile($localEnv);
    }
}

function _parseEnvFile(string $path): void
{
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), "#")) continue;
        if (strpos($line, "=") === false) continue;
        [$key, $value] = explode("=", $line, 2);
        $key   = trim($key);
        $value = trim($value);
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

function env(string $key, string $default = ""): string
{
    return $_ENV[$key] ?? getenv($key) ?: $default;
}
