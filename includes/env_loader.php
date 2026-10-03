<?php
/**
 * Simple .env loader for projects without Composer.
 * Loads environment variables from a .env file into getenv().
 * Does NOT override existing environment variables.
 */
function loadEnv($envPath = null)
{
    if ($envPath === null) {
        $envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
    }

    if (!file_exists($envPath) || !is_readable($envPath)) {
        return;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        $key = trim($parts[0]);
        $value = trim($parts[1]);

        if (strlen($value) >= 2 && $value[0] === '"' && $value[strlen($value) - 1] === '"') {
            $value = substr($value, 1, -1);
        } elseif (strlen($value) >= 2 && $value[0] === "'" && $value[strlen($value) - 1] === "'") {
            $value = substr($value, 1, -1);
        }

        if (!getenv($key)) {
            putenv($key . '=' . $value);
        }
    }
}
