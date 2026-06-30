<?php
require_once __DIR__ . '/_init.php';

if (SecurityBootstrap::hasAdminDeletePermission($chmod)) {
    if ($get == '1') {
        $row = SecurityBootstrap::queryOne($conn, 'SELECT terjual, sisa FROM barang WHERE kode = ? LIMIT 1', 's', [$barang]);
        if ($row) {
            $terjualakhir = (int) $row['terjual'] - $jumlah;
            $sisaakhir = (int) $row['sisa'] + $jumlah;
            SecurityBootstrap::updateBarangByKode($conn, $barang, ['terjual' => $terjualakhir, 'sisa' => $sisaakhir]);
        }
    } else {
        $row = SecurityBootstrap::queryOne($conn, 'SELECT sisa, terbeli, terjual FROM barang WHERE kode = ? LIMIT 1', 's', [$barang]);
        if ($row) {
            $terbeliawal = (int) $row['terbeli'];
            if ($jumlah >= $terbeliawal) {
                $terbeliakhir = $jumlah - $terbeliawal;
            } else {
                $terbeliakhir = $terbeliawal - $jumlah;
            }
            $sisaakhir = $terbeliakhir - (int) $row['terjual'];
            SecurityBootstrap::updateBarangByKode($conn, $barang, ['terbeli' => $terbeliakhir, 'sisa' => $sisaakhir]);
        }
    }

    $deleted = SecurityBootstrap::deleteWhere($conn, $forward, 'no', $no, 'i');
    if ($deleted !== false) {
        secureDeleteSuccessForm($forwardpage, ['kode' => $kode]);
    } else {
        secureDeleteDeniedForm($forwardpage, ['kode' => $kode]);
    }
} else {
    secureDeleteDeniedForm($forwardpage, ['kode' => $kode]);
}
secureDeleteSpinner();
?>
<meta http-equiv="refresh" content="10;url=<?php echo htmlspecialchars(secureDeleteJumpUrl(['kode' => $kode, 'forward' => $forward, 'forwardpage' => $forwardpage, 'chmod' => $chmod]), ENT_QUOTES, 'UTF-8'); ?>">
