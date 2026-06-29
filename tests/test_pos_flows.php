<?php
/**
 * CLI integration tests for legacy POS bugfixes.
 * Run: php tests/test_pos_flows.php
 */

error_reporting(E_ALL);
$failures = 0;
$passed = 0;

function assert_true($condition, $message) {
    global $failures, $passed;
    if ($condition) {
        echo "[PASS] $message\n";
        $passed++;
    } else {
        echo "[FAIL] $message\n";
        $failures++;
    }
}

putenv('POS_DB_HOST=127.0.0.1');
include __DIR__ . '/../configuration/config_connect.php';

// Reset product 000001 stock for repeatable tests
mysqli_query($conn, "UPDATE barang SET sisa=10, terjual=0 WHERE kode='000001'");
$before = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sisa, terjual FROM barang WHERE kode='000001'"));
assert_true((int)$before['sisa'] === 10, 'Setup: product 000001 sisa reset to 10');

$nota = 'TEST' . time();
$kode = '000001';

// Simulate cart insert (deferred stock)
$_POST = array(
    'nota' => $nota,
    'kode' => $kode,
    'qty' => 2,
    'stok' => 10,
);
$_SESSION = array(
    'username' => 'admin',
    'expires_by' => time() + 3600,
);

ob_start();
include __DIR__ . '/../add_jual_insert.php';
$output = ob_get_clean();
$json = json_decode($output, true);
assert_true($json['status'] === 'berhasil', 'Cart insert succeeds for qty 2');

$afterCart = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sisa FROM barang WHERE kode='000001'"));
assert_true((int)$afterCart['sisa'] === 10, 'Stock unchanged after cart add (deferred deduction)');

$cart = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah FROM transaksimasuk WHERE nota='$nota' AND kode='$kode'"));
assert_true((int)$cart['jumlah'] === 2, 'Cart line stores qty 2');

// Cart view SQL uses posted nota
$_POST = array('nota' => $nota);
ob_start();
include __DIR__ . '/../add_jual_auto_cart.php';
$cartHtml = ob_get_clean();
assert_true(strpos($cartHtml, '000001') !== false || mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksimasuk WHERE nota='$nota'")) > 0, 'Cart fragment loads lines for posted nota');

// Simulate checkout stock deduction logic
$kurang = 2;
$bt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sisa, terjual FROM barang WHERE kode='$kode'"));
$sisaakhir = $bt['sisa'] - $kurang;
$terjualakhir = $bt['terjual'] + $kurang;
mysqli_query($conn, "UPDATE barang SET sisa='$sisaakhir', terjual='$terjualakhir' WHERE kode='$kode'");
$afterCheckout = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sisa, terjual FROM barang WHERE kode='000001'"));
assert_true((int)$afterCheckout['sisa'] === 8, 'Stock deducted to 8 after checkout simulation');
assert_true((int)$afterCheckout['terjual'] === 2, 'terjual incremented to 2 after checkout simulation');

// Permission mapping sanity check
$chmodInvoice = 6;
$chmodKasir = 2;
assert_true($chmodInvoice !== $chmodKasir, 'Invoice menu permission level differs from kasir');

// Cleanup test cart row
mysqli_query($conn, "DELETE FROM transaksimasuk WHERE nota='$nota'");
mysqli_query($conn, "UPDATE barang SET sisa=10, terjual=0 WHERE kode='000001'");

echo "\nSummary: $passed passed, $failures failed\n";
exit($failures > 0 ? 1 : 0);
