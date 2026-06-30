<?php

include "configuration/config_connect.php";
require_once "libs/SecurityBootstrap.php";

SecurityBootstrap::requireAuth();

if (!empty($_POST['rowid'])) {
    $id = SecurityBootstrap::sanitizeString($_POST['rowid'], 64);

    $row = SecurityBootstrap::queryOne(
        $conn,
        "SELECT * FROM retur WHERE nota = ? LIMIT 1",
        's',
        [$id]
    );
    $status = $row['status'] ?? '';

    $bayarRows = SecurityBootstrap::queryAll(
        $conn,
        "SELECT * FROM bayar WHERE nota = ?",
        's',
        [$id]
    );

    foreach ($bayarRows as $baris) {
        ?>

        <form action="update.php" method="post">
            <?php echo SecurityBootstrap::csrfField(); ?>

             <table class="table table-striped">
                <tr>
                  <th style="width: 30px">Nota</th>
                  <th style="width: 30px">Subtotal</th>
                  <th style="width: 30px">Diskon</th>
                  <th style="width: 40px">Total</th>
                </tr>
                <tr>
                  <td><?php echo htmlspecialchars($baris['nota'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php $subtotal = $baris['diskon'] + $baris['total']; echo htmlspecialchars($subtotal, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($baris['diskon'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($baris['total'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>

                <tr>
                  <th style="width: 10px">Bayar</th>
                  <th>Kembalian</th>
                  <th>Kasir</th>
                  <th style="width: 40px">Tanggal</th>
                </tr>

                <tr>
                  <td><?php echo htmlspecialchars($baris['bayar'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($baris['kembali'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($baris['kasir'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <?php $tglbayar = date("d-m-Y", strtotime($baris['tglbayar'])); ?>
                  <td><?php echo htmlspecialchars($tglbayar, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>

                <?php if ($status == "Retur") { ?>
                 <tr style="background-color: #3498DB ">
                  <th style="width: 10px">Status</th>
                  <th>Kembalian</th>
                  <th>Kasir</th>
                  <th style="width: 40px">Tanggal</th>
                </tr>

                <tr>
                  <td><?php echo htmlspecialchars($row['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <?php $tanggal = date("d-m-Y", strtotime($row['tanggal'] ?? 'now')); ?>
                  <td><?php echo htmlspecialchars($tanggal, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['dana'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['petugas'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php } ?>
            </table>

             <?php
           $halaman = "retur_fetch";
           $not = $baris['nota'];

           $returItems = SecurityBootstrap::queryAll(
               $conn,
               "SELECT * FROM dataretur WHERE nota = ? ORDER BY no",
               's',
               [$not]
           );
           $rpp = 30;
           $reload = "$halaman" . "?pagination=true";
           $page = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

           if ($page <= 0) {
               $page = 1;
           }
           $tcount = count($returItems);
           $tpages = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count = 0;
           $i = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>

             <div class="box-body no-padding">
              <span class="badge bg-red">Barang Diretur</span>
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Qty Diretur</th>
                  <th style="width: 40px">Dikembalikan</th>
                </tr>
                 <?php
           while (($count < $rpp) && ($i < $tcount)) {
           $fill = $returItems[$i];
           ?>
                <tbody>

                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo htmlspecialchars($fill['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($fill['jumlah'], ENT_QUOTES, 'UTF-8'); ?> x <?php echo htmlspecialchars($fill['harga'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($fill['hargaakhir'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
             <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if ($tcount >= $rpp) {
               echo paginate_one($reload, $page, $tpages);
           } ?></div>

              </table>
            </div>

             <?php
           $halaman = "retur_fetch";
           $not = $baris['nota'];

           $trxItems = SecurityBootstrap::queryAll(
               $conn,
               "SELECT * FROM transaksimasuk WHERE nota = ? AND retur != 'YES' ORDER BY no",
               's',
               [$not]
           );

           if (count($trxItems) > 0) {
           $rpp = 30;
           $reload = "$halaman" . "?pagination=true";
           $page = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

           if ($page <= 0) {
               $page = 1;
           }
           $tcount = count($trxItems);
           $tpages = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count = 0;
           $i = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>

             <div class="box-body no-padding">
              <span class="badge bg-blue">Daftar Transaksi Barang</span>
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Qty Terjual</th>
                  <th style="width: 40px">Jumlah</th>
                </tr>
                 <?php
           while (($count < $rpp) && ($i < $tcount)) {
           $fill = $trxItems[$i];
           ?>
                <tbody>

                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo htmlspecialchars($fill['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($fill['jumlah'], ENT_QUOTES, 'UTF-8'); ?> x <?php echo htmlspecialchars($fill['harga'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($fill['hargaakhir'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
             <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>

           <div align="right"><?php if ($tcount >= $rpp) {
               echo paginate_one($reload, $page, $tpages);
           } } ?></div>

              </table>
            </div>

        </form>

<?php
    }
}
?>
