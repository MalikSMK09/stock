<?php
require_once __DIR__ . '/config_security.php';
session_start();
SecurityBootstrap::requireAuth();
include __DIR__ . '/config_connect.php';
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$search = SecurityBootstrap::paramStr($_GET['search'] ?? '', 100);
$forward = SecurityBootstrap::whitelistExport($_GET['forward'] ?? '');
$bulan = SecurityBootstrap::paramStr($_GET['bulan'] ?? '', 2);
$tahun = SecurityBootstrap::paramStr($_GET['tahun'] ?? '', 4);
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $forward . ".xls");

?>
<?php if($forward == 'bayar'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Pembayaran</th>
                                              <th>Uang Bayar</th>
                                              <th>Uang Kembali</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  $like = '%' . SecurityBootstrap::escapeLike($search) . '%';
  $query1 = "SELECT * FROM bayar WHERE nota LIKE ? ESCAPE '\\\\' OR tglbayar LIKE ? ESCAPE '\\\\' OR kasir LIKE ? ESCAPE '\\\\' ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 'sss', [$like, $like, $like]);
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle = SecurityBootstrap::queryOne($conn, 'SELECT COUNT(nota) AS data FROM transaksimasuk WHERE nota = ?', 's', [$nota]);
$rowa = $sqle ?: ['data' => 0];
$jumlahbayar = $rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['bayar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kembali']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'barang'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Kode Barang</th>
                                              <th>Nama Barang</th>
                                              <th>Kategori</th>
                                               <th>Merk</th>
                                              <th>Stok Terjual</th>
                                              <th>Stok Terbeli</th>
                                              <th>Stok Tersedia</th>
                                              <th>Satuan</th>
                                               <th>Supplier</th>
                                               <th>Expired</th>
                                               <th>Lokasi</th>
                                              
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

  $like = '%' . SecurityBootstrap::escapeLike($search) . '%';
  $query1 = "SELECT * FROM barang WHERE kode LIKE ? ESCAPE '\\\\' OR nama LIKE ? ESCAPE '\\\\' OR kategori LIKE ? ESCAPE '\\\\' ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 'sss', [$like, $like, $like]);
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
    <td><?php  echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
    <td><?php  echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
    <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
      <td><?php  echo mysqli_real_escape_string($conn, $fill['expired']); ?></td>
        <td><?php  echo mysqli_real_escape_string($conn, $fill['lokasi']); ?></td>
  
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'buy'){ ?>
      <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Tagihan</th>
                                              <th>Supplier</th>
                                              <th>Status</th>
                                                <th>Diterima</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
  $query1="select *, supplier.nama as supplier from buy inner join supplier on supplier.kode = buy.supplier order by buy.no desc";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>
                     <tbody>
    <tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglsale']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle = SecurityBootstrap::queryOne($conn, 'SELECT COUNT(nota) AS data FROM invoicebeli WHERE nota = ?', 's', [$nota]);
$rowa = $sqle ?: ['data' => 0];
$jumlahbeli = $rowa['data'];

$jmlRow = SecurityBootstrap::queryOne($conn, 'SELECT SUM(jumlah) AS tot_beli FROM invoicebeli WHERE nota = ?', 's', [$nota]);
$jmlbeli = $jmlRow['tot_beli'] ?? 0;

   ?>
   
  <td><?php  echo mysqli_real_escape_string($conn, $jmlbeli); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['supplier']); ?></td>
   <td><?php  echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
    <td><?php  echo mysqli_real_escape_string($conn, $fill['diterima']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
 </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'revenue'){

  $forward = 'bayar';
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];

  ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Pembayaran</th>
                                              <th>Uang Bayar</th>
                                              <th>Uang Kembali</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1 = "SELECT * FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1);
}else{
  $dateLike = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-%';
  $query1 = "SELECT * FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE ? ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 's', [$dateLike]);
}
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn , $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn , $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle = SecurityBootstrap::queryOne($conn, 'SELECT COUNT(nota) AS data FROM transaksimasuk WHERE nota = ?', 's', [$nota]);
$rowa = $sqle ?: ['data' => 0];
$jumlahbayar = $rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['bayar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kembali']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'income'){

  $forward = 'bayar';
  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];

  ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>No Nota</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah Item</th>
                                              <th>Total Masuk</th>
                                              <th>Total Keluar</th>
                                              <th>Income</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1 = "SELECT * FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1);
}else{
  $dateLike = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-%';
  $query1 = "SELECT * FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE ? ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 's', [$dateLike]);
}
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglbayar']); ?></td>
  <?php
$nota = $fill['nota'];
$sqle = SecurityBootstrap::queryOne($conn, 'SELECT COUNT(nota) AS data FROM transaksimasuk WHERE nota = ?', 's', [$nota]);
$rowa = $sqle ?: ['data' => 0];
$jumlahbayar = $rowa['data'];
   ?>
  <td><?php  echo mysqli_real_escape_string($conn, $jumlahbayar); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['keluar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['total']-$fill['keluar']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
  <td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>


<?php if($forward == 'operasional'){ ?>

      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Kode</th>
                                              <th>Nama</th>
                                              <th>Tanggal</th>
                                              <th>Biaya</th>
                                              <th>Keterangan</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1 = "SELECT * FROM operasional ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1);
}else{
  $dateLike = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-%';
  $query1 = "SELECT * FROM operasional WHERE tanggal LIKE ? ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 's', [$dateLike]);
}
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tanggal']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['biaya'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>



<?php if($forward == 'sale'){ 

$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
  ?>



      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Nota</th>
                                              <th>Tanggal</th>
                                              <th>Total</th>
                                              <th>Diskon</th>
                                              <th>Pembeli</th>
                                              <th>Cc</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if($tahun == null || $tahun == ""){
  $query1 = "SELECT * FROM sale ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1);
}else{
  $query1 = "SELECT * FROM sale WHERE YEAR(tglsale) = ? AND MONTH(tglsale) = ? ORDER BY no";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1, 'ii', [(int) $tahun, (int) $bulan]);
}
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
  <td><?php echo ++$no_urut;?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['tglsale']); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['total'])); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['diskon'])); ?></td>
  <td><?php  $pgn = $fill['pelanggan'];
  $r = SecurityBootstrap::queryOne($conn, 'SELECT nama FROM pelanggan WHERE kode = ? LIMIT 1', 's', [$pgn]);
  echo mysqli_real_escape_string($conn, $r['nama'] ?? ''); ?></td>
  <td><?php  echo mysqli_real_escape_string($conn, $fill['kasir']); ?></td>
            </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>



<?php if($forward == 'mutasi'){ 


  ?>



      <table class="table">
                                        <thead>
                                            <tr>
                                              <th>No</th>
                                                <th>Nama User</th>
                                                <th>Tanggal</th>
                                                <th>Barang</th>
                                                <th>Kegiatan</th>
                                                <th>Jumlah</th>
                                                <th>Stok Akhir</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                      <?php
  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

  $query1 = "SELECT mutasi.namauser, mutasi.tgl, mutasi.kodebarang, mutasi.status, mutasi.jumlah, mutasi.sisa, mutasi.kegiatan, mutasi.keterangan, barang.nama FROM mutasi INNER JOIN barang ON mutasi.kodebarang = barang.kode ORDER BY mutasi.no DESC";
  $hasilRows = SecurityBootstrap::queryAll($conn, $query1);
        $no = 1;
        foreach ($hasilRows as $fill){
          ?>
                     <tbody>
<tr>
            <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
            <?php  $tgl = date("d-m-Y",strtotime($fill['tgl'])); ?>
            <td><?php  echo mysqli_real_escape_string($conn, $tgl); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['status']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
          </tr><?php
          ;
        }

        ?>
                  </tbody></table>
<?php } ?>