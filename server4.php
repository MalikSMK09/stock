<?php

include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();
SecurityBootstrap::enforceRateLimit('api_search', 60, 60);

$response = [];

if (isset($_POST['search'])) {
    $search = SecurityBootstrap::sanitizeString($_POST['search'], 100);
    $like = '%' . SecurityBootstrap::escapeLike($search) . '%';

    $rows = SecurityBootstrap::queryAll(
        $conn,
        "SELECT barcode, nama FROM barang WHERE nama LIKE ? ESCAPE '\\\\' LIMIT 20",
        's',
        [$like]
    );

    foreach ($rows as $row) {
        $response[] = [
            "value" => $row['barcode'],
            "label" => $row['nama'],
        ];
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}

exit;
