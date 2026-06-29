<!DOCTYPE html>
<html>

<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "invoice_beli"; // halaman
$dataapa = "Invoice Pembelian"; // data
$tabeldatabase = "invoicebeli"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$tabel = "buy";
$today = date('Y-m-d');
 
function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM buy_payment ORDER BY no";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%08s", $sort_num);
  return $new_code;
 }


?>

<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php
        $nota = $_GET["nota"];

        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $tglbayar = date("d-m-Y",strtotime($row['tglsale']));
        $bayar=$row['kasir'];
        $total=$row['total'];
        $cost=$row['biaya'];
         $nopo=$row['nopo'];
        $keterangan=$row['keterangan'];
        $supplier=$row['supplier'];
         $status=$row['status'];
          $terima=$row['diterima'];

          if($status=="dibayar"){
            $sss="";
          } else {
            $sss="BELUM";
          }

        $sql1="SELECT * FROM supplier where kode='$supplier' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];
        $kodesup = $row['kode'];


        $sql1="SELECT SUM(jumlah) as data FROM $tabeldatabase where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];

        $sql1="SELECT SUM(hargaakhir) as data FROM $tabeldatabase where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalprice=$row['data']+$cost;



         $sql1="SELECT * FROM buy_payment where nota='$nota' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $cara=$row['metode'];
        $banke=$row['bank'];
        $refe=$row['keterangan'];
        $ygbayar=$row['user'];
        $jml=$row['jumlah'];
        $payday=$row['tanggal'];
        
          

        ?>


<!-- SETTING STOP -->



<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="pembelian"><?php echo $dataapa ?></a></li>
<?php

if ($search != null || $search != "") {
?>
 <li> <a href="pembelian">Data <?php echo $dataapa ?></a></li>
  <li class="active"><?php
    echo $search;
?></li>
  <?php
} else {
?>
 <li class="active">Data <?php echo $dataapa ?></li>
  <?php
}
?>
</ol>

<!-- BREADCRUMB -->

<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>


       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Pembelian <?php echo $nopo;?> <b>[<?php echo $sss;?> LUNAS]</b></h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    
    ?>
  <div id="main">
   <div class="container-fluid">


    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row" >
        
       
    
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="box box-info">
        <div class="box-body">
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Supplier:
          <address>
            <strong> <?php echo $customer;?></strong><br>
            <?php echo $address;?><br>
            No.Telp: <?php echo $nohp;?><br>
     <!--       Email: info@almasaeedstudio.com                 -->
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Kepada:
          <address>
            <strong> <?php echo $nama;?></strong><br>
             <?php echo $alamat;?><br>
            
          
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>No.Pembelian #<?php echo $nopo;?></b><br>
          <br>
          <b>Jatuh Tempo:</b> <?php echo $tglbayar;?><br>
          
        </div>
        <!-- /.col -->
      </div>
  </div>
</div>
      <!-- /.row -->
<div class="box box-warning">
        <div class="box-body">
      <!-- Table row -->
      <div class="row">
        <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from $tabeldatabase where nota ='$nota' order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 15;
           $reload = "$halaman"."?nota=".$nota."&pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = mysqli_num_rows($result);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Product</th>
              <th>Price/item</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
            <tbody>
            <tr>
              <td><?php echo ++$no_urut;?></td>
              <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
             <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
              <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
               <td><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
            </tr>
            

            <?php
           $i++;
           $count++;
           }

           ?>
            </tbody>
          </table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</div>
</div>

<div class="box box-success">
        <div class="box-body">
      <div class="row">
       <!-- accepted payments column -->
      <?php if ($status=='belum'){?>
        <!-- accepted payments column -->
        <div class="col-xs-6">
         

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <?php echo $keterangan;?>
          </p>
        </div>
         <div class="col-xs-6">
          

        <?php } else if ($status=='hutang'){?>

             <div class="col-xs-6">
            <p class="lead"><h2>Hutang</h2></p>
          </div>

        <?php } else {?>

          <div class="col-xs-6">
        
        <img src="dist/img/lunas.png" alt="Visa">
        
      </div>
      <div class="col-xs-6">
        <?php if ($status=='dibayar'){?>
          <p class="lead">Telah Lunas Dibayar</p>
        <?php } else if($status=='hutang') {?>
   <!--         <p class="lead">Hutang</p>  -->
          <?php } } ?>
        <!-- /.col -->
        <div class="col-xs-6">
         

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Total Qty:</th>
                <td><?php echo $totalqty;?> Pcs</td>
              </tr>
              
              <?php if($cost>0){?>
              <tr>
                <th>Biaya lain:</th>
                <td>Rp. <?php echo number_format($cost, $decimal, $a_decimal, $thousand).',-';?></td>
              </tr>
                <?php } ?>
              
              <tr>
                <th>Total:</th>
                <td>Rp. <?php echo number_format($totalprice, $decimal, $a_decimal, $thousand).',-';?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</div>
</div>
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="print_beli2?nota=<?php echo $nota;?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <?php if ($status=='belum'){?>
           <button type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-success"><i class="fa fa-money"></i> Bayar Lunas
          </button>

           <button type="button" data-toggle="modal" data-target="#modal-hutang" class="btn btn-danger"><i class="fa fa-credit-card"></i> Kredit/Hutang
          </button><p>

           <?php } else if($status=='dibayar') {?>
            <button type="button" data-toggle="modal" data-target="#modal-info" class="btn btn-success"><i class="fa fa-credit-card"></i> Info Lunas
          </button>
          <?php } if(($status=='dibayar' || $status=='hutang')&&($terima=='' || $terima==null)){ ?>
           <button type="button" class="btn btn-primary" style="margin-right: 5px;" onclick="window.location.href='diterima?nota=<?php echo $nota;?>'">
            <i class="fa fa-download"></i> Diterima
          </button>
            <?php } ?>
        </div>
      </div>
    </section>

          
</div>


    <!-- KONTEN BODY AKHIR -->

                                </div>
                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>
                        <!-- ./col -->
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->
 <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembayaran Pembelian #<?php echo $nopo;?></h4>
              </div>
              <div class="modal-body">


                 <form method="post" >
                <input type="hidden" class="form-control" value="<?php echo $nota;?>" id="nota" name="nota" >
                 <input type="hidden" class="form-control" value="<?php echo autoNumber();?>" id="nota" name="kode" >
 <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Tanggal Bayar:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="datepicker2" name="tgl" placeholder="Tanggal bayar" >
                       <input type="hidden" class="form-control" name="sup" value="<?php echo $supplier;?>" >
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Metode:</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%;" name="metode">
                        
                        <option value=Cash>Cash</option>
                      <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from options where tipe='pay' ");
        while ($row=mysqli_fetch_assoc($sql)){
          echo "<option value='".$row['nama']."' >".$row['nama']."</option>";
        }
      ?>

                    </select>
                  </div>
                </div>
        </div>
<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Bank:</label>
                  <div class="col-sm-9">
                   
                     <select class="form-control select2" style="width: 100%;" name="bank">
                        
                        <option value="">Pilih Bank</option>
                      <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from options where tipe='bank' ");
        while ($row=mysqli_fetch_assoc($sql)){
          echo "<option value='".$row['nama']."' >".$row['nama']."</option>";
        }
      ?>

                    </select>
                  </div>
                </div>
        </div>

<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">kode referensi:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="ref" name="ref" placeholder="Masukan kode referensi" >
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Jumlah bayar:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="jml" name="jml" value="<?php echo $totalprice;?>" placeholder="Masukan Jumlah bayar" >
                     <input type="hidden" class="form-control" name="tagihan" value="<?php echo $totalprice;?>" >
                  </div>
                </div>
        </div>
<input type="hidden" class="form-control" id="jml1" name="jml1" value="<?php echo $totalprice;?>" readonly >
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" name="save1" class="btn btn-primary">Simpan</button>
              </div>
            </div>

          </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

<?php

    if(isset($_POST['save1'])){
   if($_SERVER["REQUEST_METHOD"] == "POST"){
            $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
          $sup = mysqli_real_escape_string($conn, $_POST["sup"]);
          $metode = mysqli_real_escape_string($conn, $_POST["metode"]);
           $bank = mysqli_real_escape_string($conn, $_POST["bank"]);
          $jml= mysqli_real_escape_string($conn, $_POST["jml"]);
          $ket = mysqli_real_escape_string($conn, $_POST["ref"]);
          $tgl = mysqli_real_escape_string($conn, $_POST["tgl"]);
          $tagihan=mysqli_real_escape_string($conn, $_POST["tagihan"]);
          

          $user=$_SESSION['nama'];

          $sudahbayar=$jml;

if($jml>=$tagihan){

mysqli_query($conn,"SET session sql_mode = ''");	$sql1="INSERT INTO buy_payment VALUES('$kode','$nota','$sup','$tgl','$jml','$metode','$bank','$ket','$user','')";

if(mysqli_query($conn,$sql1)){

$sql=mysqli_query($conn,"UPDATE buy SET status='dibayar',sudahbayar='$sudahbayar' WHERE nota='$nota'");

   echo "<script type='text/javascript'>  alert('Berhasil, Pembayaran disimpan!'); </script>";
                  echo "<script type='text/javascript'>window.location = 'invoice_beli?nota=$nota';</script>";

} else {
      echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Hubungi Admin'); </script>";
           echo "<script type='text/javascript'>window.location = 'invoice_beli?nota='$nota';</script>";
}

} else {
    echo "<script type='text/javascript'>  alert('Gagal, Pembayaran tidak boleh kurang dari tagihan karena anda memilih bayar lunas'); </script>";
           echo "<script type='text/javascript'>window.location = 'invoice_beli?nota='$nota';</script>";
}




}}?>



<!-- Modal Hutang -->

 <div class="modal fade" id="modal-hutang">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hutang Pembelian #<?php echo $nota;?></h4>
              </div>
              <div class="modal-body">


                 <form method="post" >
                <input type="hidden" class="form-control" value="<?php echo $nota;?>" id="nota" name="nota" >
                 <input type="hidden" class="form-control" value="<?php echo $nopo;?>" id="nopo" name="nopo" >
                <input type="hidden" class="form-control" value="<?php echo $today;?>"  name="tgl" >
                <input type="hidden" class="form-control" value="<?php echo $kodesup;?>"  name="kreditur" >
 <div class="row">

        


           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Kreditur:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $customer;?>" readonly  >
                  </div>
                </div>
        </div>

      

<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Jatuh Tempo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" autocomplete="off" name="duedate" value="<?php echo date('Y-m-d');?>">
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Jumlah:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="hutang" name="hutang1" value="<?php echo $totalprice;?>"  >
                     <input type="hidden" class="form-control" name="hutang2" value="<?php echo $totalprice;?>"  readonly >
                  </div>
                </div>
        </div>


        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Keterangan:</label>
                  <div class="col-sm-9">
                   <textarea style="width:100%" name="keterangan"></textarea>
                  </div>
                </div>
        </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" name="hutang" class="btn btn-primary">Simpan</button>
              </div>
            </div>

          </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Modal INFo-->
<?php


if(isset($_POST['hutang'])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

         $nota = mysqli_real_escape_string($conn, $_POST['nota']);
         $tgl = mysqli_real_escape_string($conn, $_POST['tgl']);
         $due = mysqli_real_escape_string($conn, $_POST['duedate']);
         $kreditur = mysqli_real_escape_string($conn, $_POST['kreditur']);
         $jml = mysqli_real_escape_string($conn, $_POST['hutang1']);
         $hutang = mysqli_real_escape_string($conn, $_POST['hutang2']);
          $nopo = mysqli_real_escape_string($conn, $_POST['nopo']);
         $ket = mysqli_real_escape_string($conn, $_POST['keterangan']);
          
        
         $status ="hutang";

         if ($jml >= $hutang){

         mysqli_query($conn,"SET session sql_mode = ''");	$sqlu = "INSERT INTO buy_hutang VALUES('$nota','$nopo','$kreditur','$tgl','$due','$jml','','$ket','$status','') ";
         $query = mysqli_query($conn, $sqlu);

          $sqly = "UPDATE buy SET status='$status',tglsale='$due' where nota='$nota' ";
         $query1 = mysqli_query($conn, $sqly);


         if($query1){
           echo "<script type='text/javascript'>  alert('Berhasil, Hutang pembelian disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = 'invoice_beli?nota=$nota';</script>";
             
         } else {
          echo "<script type='text/javascript'>  alert('Terjadi kesalahan, Pastikan semua data sudah diinput dengan benar!'); </script>";
         }

       } else {

        echo "<script type='text/javascript'>  alert('GAGAL, jumlah hutang tidak boleh lebih kecil dari tagihan awal!'); </script>";

        } } }

        ?>




 <div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info Pembayaran Nota Pembelian #<?php echo $nopo;?></h4>
              </div>
              <div class="modal-body">
                
<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Tanggal:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $payday;?>" readonly>
                  </div>
                </div>
        </div>

<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Metode:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $cara;?>" readonly>
                  </div>
                </div>
        </div>

<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Bank:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $banke;?>" readonly>
                  </div>
                </div>
        </div>
<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">REF:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $refe;?>" readonly>
                  </div>
                </div>
        </div>
        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">User:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $ygbayar;?>" readonly>
                  </div>
                </div>
        </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="1-11-4-jquery-ui.min.js"></script>

        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->
<!-- Script -->
    <script type='text/javascript' >
    $( function() {
  
        $( "#barcode" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#nama').val(ui.item.label);
                $('#barcode').val(ui.item.value); // display the selected text
                $('#hargajual').val(ui.item.hjual);
                $('#stok').val(ui.item.sisa); // display the selected text
                $('#hargabeli').val(ui.item.hbeli);
                $('#jumlah').val(ui.item.jumlah);
                $('#kode').val(ui.item.kode); // save selected id to input
                return false;
                
            }
        });

        // Multiple select
        $( "#multi_autocomplete" ).autocomplete({
            source: function( request, response ) {
                
                var searchText = extractLast(request.term);
                $.ajax({
                    url: "server.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: searchText
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function( event, ui ) {
                var terms = split( $('#multi_autocomplete').val() );
                
                terms.pop();
                
                terms.push( ui.item.label );
                
                terms.push( "" );
                $('#multi_autocomplete').val(terms.join( ", " ));

                // Id
                var terms = split( $('#selectuser_ids').val() );
                
                terms.pop();
                
                terms.push( ui.item.value );
                
                terms.push( "" );
                $('#selectuser_ids').val(terms.join( ", " ));

                return false;
            }
           
        });
    });

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    </script>

<!--AUTO Complete-->

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
