<?php
require_once __DIR__ . '/_init.php';

if (SecurityBootstrap::hasDeletePermission($chmod)) {
    $row = SecurityBootstrap::queryOne($conn, 'SELECT sisa, terbeli FROM barang WHERE kode = ? LIMIT 1', 's', [$kode]);
    if ($row) {
        $masuk = (int) $row['terbeli'] - $jml;
        $stok = (int) $row['sisa'] - $jml;
        SecurityBootstrap::updateBarangByKode($conn, $kode, ['sisa' => $stok, 'terbeli' => $masuk]);
    }

    $deleted = SecurityBootstrap::deleteWhere($conn, $forward, 'no', $no, 'i');
    if ($deleted !== false) {
        $remaining = SecurityBootstrap::queryOne(
            $conn,
            'SELECT COUNT(*) AS cnt FROM stok_masuk_daftar WHERE nota = ?',
            's',
            [$nota]
        );
        if ((int) ($remaining['cnt'] ?? 0) === 0) {
            SecurityBootstrap::execute($conn, 'DELETE FROM stok_masuk WHERE nota = ?', 's', [$nota]);
        }
        secureDeleteSuccessForm($forwardpage, []);
    } else {
        secureDeleteDeniedForm($forwardpage);
    }
} else {
    secureDeleteDeniedForm($forwardpage);
}
secureDeleteSpinner();
?>
<meta http-equiv="refresh" content="10;url=<?php echo htmlspecialchars(secureDeleteJumpUrl(['forward' => $forward, 'forwardpage' => $forwardpage, 'chmod' => $chmod]), ENT_QUOTES, 'UTF-8'); ?>">
