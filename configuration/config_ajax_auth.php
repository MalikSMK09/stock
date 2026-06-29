<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'gagal', 'message' => 'Sesi tidak valid, silakan login kembali'));
    exit;
}

include_once __DIR__ . '/config_connect.php';
include_once __DIR__ . '/config_time.php';

if (!login_check()) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'gagal', 'message' => 'Sesi habis, silakan login kembali'));
    exit;
}

?>
