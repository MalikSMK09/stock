<?php

include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();

if (!empty($_POST['rowid'])) {
    $id = SecurityBootstrap::sanitizeString($_POST['rowid'], 64);

    $baris = SecurityBootstrap::queryOne(
        $conn,
        "SELECT * FROM barang WHERE kode = ? LIMIT 1",
        's',
        [$id]
    );

    if ($baris) {
        ?>

        <form action="stok_retur" method="post">
            <?php echo SecurityBootstrap::csrfField(); ?>

             <table class="table table-striped">
                <tr>
                  <th>Nama</th>
                  <th style="width: 30px">Stok Gudang</th>
                </tr>
                <tr>
                  <td><?php echo htmlspecialchars($baris['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($baris['sisa'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>

                <tr>
                  <th>Stok Retur</th>
                  <th>Jumlah Dipindah</th>
                </tr>

                <tr>
                  <td><?php echo htmlspecialchars($baris['retur'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><input type="text" value="<?php echo htmlspecialchars($baris['retur'], ENT_QUOTES, 'UTF-8'); ?>" name="pindah"></td>
                </tr>
            </table>

            <input type="hidden" value="<?php echo htmlspecialchars($baris['kode'], ENT_QUOTES, 'UTF-8'); ?>" name="kode">
            <input type="hidden" value="<?php echo htmlspecialchars($baris['sisa'], ENT_QUOTES, 'UTF-8'); ?>" name="sisa">
            <input type="hidden" value="<?php echo htmlspecialchars($baris['retur'], ENT_QUOTES, 'UTF-8'); ?>" name="retur">

            <input type="submit" class="btn btn-info btn-flat" value="Pindah Stok" name="simpan">
        </form>

<?php
    }
}
?>
