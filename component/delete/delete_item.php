<?php
require_once __DIR__ . '/_init.php';

if (SecurityBootstrap::hasAdminDeletePermission($chmod)) {
    if ($jenis == '1') {
        $row = SecurityBootstrap::queryOne($conn, 'SELECT sisa, terbeli FROM barang WHERE kode = ? LIMIT 1', 's', [$kode]);
        if ($row) {
            $terbeliakhir = (int) $row['terbeli'] - $jumlah;
            $sisaakhir = (int) $row['sisa'] - $jumlah;
            SecurityBootstrap::updateBarangByKode($conn, $kode, ['terbeli' => $terbeliakhir, 'sisa' => $sisaakhir]);
        }

        $buyRow = SecurityBootstrap::queryOne($conn, 'SELECT total FROM buy WHERE nota = ? LIMIT 1', 's', [$nota]);
        if ($buyRow) {
            $newtot = $sub + (float) $buyRow['total'];
            SecurityBootstrap::execute($conn, 'UPDATE buy SET total = ? WHERE nota = ?', 'ds', [$newtot, $nota]);
        }

        $invoiceCount = SecurityBootstrap::queryOne(
            $conn,
            'SELECT COUNT(*) AS cnt FROM invoicebeli WHERE nota = ?',
            's',
            [$nota]
        );
        if ((int) ($invoiceCount['cnt'] ?? 0) <= 1) {
            SecurityBootstrap::execute($conn, 'DELETE FROM buy WHERE nota = ?', 's', [$nota]);
            SecurityBootstrap::execute($conn, 'DELETE FROM hutang WHERE nota = ?', 's', [$nota]);
            SecurityBootstrap::execute($conn, "DELETE FROM payment WHERE tipe = '1' AND nota = ?", 's', [$nota]);
            $cek = 1;
        }
    } else {
        $row = SecurityBootstrap::queryOne($conn, 'SELECT terjual, sisa FROM barang WHERE kode = ? LIMIT 1', 's', [$kode]);
        if ($row) {
            $terjualakhir = (int) $row['terjual'] - $jumlah;
            $sisaakhir = (int) $row['sisa'] + $jumlah;
            SecurityBootstrap::updateBarangByKode($conn, $kode, ['terjual' => $terjualakhir, 'sisa' => $sisaakhir]);
        }

        $saleRow = SecurityBootstrap::queryOne(
            $conn,
            'SELECT total, potongan, biaya, diskon FROM sale WHERE nota = ? LIMIT 1',
            's',
            [$nota]
        );
        if ($saleRow) {
            $oldsub = (float) $saleRow['total'] + (float) $saleRow['potongan'] - (float) $saleRow['biaya'];
            $newsub = $oldsub - $sub;
            $newsub2 = $newsub - (($newsub * (float) $saleRow['diskon']) / 100);
            $newtot = $newsub2 + (float) $saleRow['biaya'];
            SecurityBootstrap::execute($conn, 'UPDATE sale SET total = ? WHERE nota = ?', 'ds', [$newtot, $nota]);
        }

        $invoiceCount = SecurityBootstrap::queryOne(
            $conn,
            'SELECT COUNT(*) AS cnt FROM invoicejual WHERE nota = ?',
            's',
            [$nota]
        );
        if ((int) ($invoiceCount['cnt'] ?? 0) <= 1) {
            SecurityBootstrap::execute($conn, 'DELETE FROM sale WHERE nota = ?', 's', [$nota]);
            SecurityBootstrap::execute($conn, "DELETE FROM payment WHERE tipe = '2' AND nota = ?", 's', [$nota]);
            $cek = 1;
        }
    }

    $deleted = SecurityBootstrap::deleteWhere($conn, $forward, 'no', $no, 'i');
    if ($deleted !== false) {
        if ($cek == 1) {
            if ($jenis == '1') {
                echo "<script type='text/javascript'>window.location = '" . htmlspecialchars($baseurl . '/pembelian', ENT_QUOTES, 'UTF-8') . "';</script>";
            } else {
                echo "<script type='text/javascript'>window.location = '" . htmlspecialchars($baseurl . '/penjualan', ENT_QUOTES, 'UTF-8') . "';</script>";
            }
        } else {
            echo "<script type='text/javascript'>window.location = '" . htmlspecialchars($baseurl . '/' . $forwardpage . '?q=' . urlencode($nota), ENT_QUOTES, 'UTF-8') . "';</script>";
        }
    } else {
        secureDeleteDeniedForm($forwardpage, ['kode' => $kode]);
        secureDeleteSpinner();
    }
} else {
    secureDeleteDeniedForm($forwardpage, ['kode' => $kode]);
    secureDeleteSpinner();
}
?>
<meta http-equiv="refresh" content="10;url=<?php echo htmlspecialchars(secureDeleteJumpUrl(['kode' => $kode, 'forward' => $forward, 'forwardpage' => $forwardpage, 'chmod' => $chmod]), ENT_QUOTES, 'UTF-8'); ?>">
