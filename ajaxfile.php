<?php

include 'configuration/config_connect.php';
require_once 'libs/SecurityBootstrap.php';

SecurityBootstrap::requireAuth();
SecurityBootstrap::enforceRateLimit('ajax_username', 30, 60);

if (isset($_POST['username'])) {
    $username = SecurityBootstrap::sanitizeString($_POST['username'], 64);

    $row = SecurityBootstrap::queryOne(
        $conn,
        "SELECT COUNT(*) AS cntUser FROM user WHERE userna_me = ?",
        's',
        [$username]
    );

    $count = (int) ($row['cntUser'] ?? 0);
    $response = $count > 0
        ? "<span style='color: red;'>Sudah dipakai.</span>"
        : "<span style='color: green;'>Tersedia.</span>";

    echo $response;
    die;
}
