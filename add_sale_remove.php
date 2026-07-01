<?php
include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();

$id = SecurityBootstrap::paramInt($_POST["id"] ?? 0);
if ($id <= 0) {
    exit;
}

$cek = SecurityBootstrap::queryOne($conn, 'SELECT kode, jumlah FROM invoicejual WHERE no = ? LIMIT 1', 'i', [$id]);
if (!$cek) {
    exit;
}

$kode = $cek['kode'];
$qty = (int) $cek['jumlah'];

$brg = SecurityBootstrap::queryOne($conn, 'SELECT sisa, terjual FROM barang WHERE kode = ? LIMIT 1', 's', [$kode]);
if ($brg) {
    $stok = (int) $brg['sisa'] + $qty;
    $terjual = (int) $brg['terjual'] - $qty;
    SecurityBootstrap::updateBarangByKode($conn, $kode, ['sisa' => $stok, 'terjual' => $terjual]);
}

SecurityBootstrap::execute($conn, 'DELETE FROM invoicejual WHERE no = ?', 'i', [$id]);
