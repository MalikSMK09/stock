<?php

error_reporting(E_ALL ^ E_DEPRECATED);

require_once __DIR__ . '/config_security.php';

function loadEnvFile($path)
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
        $value = trim($parts[1], " \t\n\r\0\x0B\"'");
        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
        }
    }
}

loadEnvFile(__DIR__ . '/.env');

$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'setyajay_user';
$password = getenv('DB_PASS') ?: 'enter4j4ya#';
$dbname = getenv('DB_NAME') ?: 'setyajay_stock';

global $conn;

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    die('Koneksi database gagal. Hubungi administrator.');
}

mysqli_set_charset($conn, 'utf8mb4');
mysqli_query($conn, "SET session sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");

// Legacy alias for older scripts
$koneksi = $conn;
$db = $dbname;
