<?php
include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();

$no = SecurityBootstrap::paramInt($_POST["no"] ?? 0);
$per = SecurityBootstrap::paramFloat($_POST["perdis"] ?? 0);
$dis = SecurityBootstrap::paramFloat($_POST["diskon"] ?? 0);

SecurityBootstrap::execute(
    $conn,
    'UPDATE invoicejual SET harga = ?, diskon_persen = ?, diskon_harga = ? WHERE no = ?',
    'dddi',
    [$dis, $per, $dis, $no]
);

$output = ['status' => 'berhasil', 'message' => 'berhasil'];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($output);
