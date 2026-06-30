<?php

include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();
SecurityBootstrap::enforceRateLimit('api_search', 60, 60);

$jumlah = 0;
$bayar = 0;
$response = [];

if (isset($_POST['search'])) {
    $search = SecurityBootstrap::sanitizeString($_POST['search'], 100);
    $like = '%' . SecurityBootstrap::escapeLike($search) . '%';

    $rows = SecurityBootstrap::queryAll(
        $conn,
        "SELECT barcode, nama, hargajual, sisa, hargabeli, kode FROM barang WHERE barcode LIKE ? ESCAPE '\\\\' LIMIT 20",
        's',
        [$like]
    );

    foreach ($rows as $row) {
        $response[] = [
            "value" => $row['barcode'],
            "label" => $row['nama'],
            "hjual" => $row['hargajual'],
            "sisa" => $row['sisa'],
            "hbeli" => $row['hargabeli'],
            "kode" => $row['kode'],
            "jumlah" => $jumlah,
            "bayar" => $bayar,
        ];
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}

exit;
