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
$halaman = "bayar_hutang_beli"; // halaman
$dataapa = "Pembayaran Hutang"; // data
$tabeldatabase = "buy_payment"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

 
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


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if ($search != null || $search != "") {
?>
 <li> <a href="<?php echo $halaman;?>">Data <?php echo $dataapa ?></a></li>
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
                           <?php
if (isset($_GET['msg'])) {
?>
    <div id="myAlert"  class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>GAGAL HAPUS!</strong> Terjadi kesalahan dalam proses hapus data, hubungi Admin untuk bantuan.
</div>

<!-- BOX HAPUS BERHASIL -->
<?php } ?>
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

$q = SecurityBootstrap::secureNota($_GET['q'] ?? '');

$a = SecurityBootstrap::queryOne($conn, 'SELECT * FROM buy_hutang WHERE nota = ? LIMIT 1', 's', [$q]) ?: [];
$sisa = ($a['hutang'] ?? 0) - ($a['sudahbayar'] ?? 0);

$c = SecurityBootstrap::queryOne($conn, 'SELECT * FROM buy WHERE nota = ? LIMIT 1', 's', [$q]) ?: [];

$aa = $a['kreditur'] ?? '';
$b = SecurityBootstrap::queryOne($conn, 'SELECT * FROM supplier WHERE kode = ? LIMIT 1', 's', [$aa]) ?: [];
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
 <?php if($a['status']=='hutang'){?>

 <div class="col-lg-6">


      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Pembayaran Hutang</h3>

          <div class="box-tools pull-right">

            <?php if($a['duedate']!='0000-00-00'){?>
            Jatuh Tempo: <?php echo date('d-m-Y',strtotime($a['due']));?> 

        <?php } ?>
          </div>
        </div>
        <div class="box-body">
         

<form method="post">

 <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">No. Pembelian:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $c['nopo']; ?>" readonly>
                     <input type="hidden" class="form-control" value="<?php echo autoNumber(); ?>" name="kode" readonly>
                     <input type="hidden" class="form-control" value="<?php echo $c['nota']; ?>" name="nota" readonly>
                  </div>
                </div>
        </div>

 <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Supplier:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $b['nama']; ?>" readonly>
                      <input type="hidden" class="form-control" value="<?php echo $a['kreditur']; ?>" name="sup" readonly>
                  </div>
                </div>
        </div>

 <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Total Hutang:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo number_format($a['hutang']); ?>" readonly>
                      <input type="hidden" class="form-control" value="<?php echo $a['hutang']; ?>" readonly>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Sisa Hutang:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo number_format($sisa); ?>" readonly>
                        <input type="hidden" class="form-control" value="<?php echo $sisa; ?>" name="sisa" readonly>
                          <input type="hidden" class="form-control" value="<?php echo $a['sudahbayar']; ?>" name="sudah" readonly>
                  </div>
                </div>
        </div>

         <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Keterangan:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?php echo $a['keterangan'];?>" readonly>
                  </div>
                </div>
        </div>

         <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Tanggal:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="datepicker2" name="tgl">
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Jumlah Bayar:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="bayaran" value="0" autocomplete="off">
                      
                  </div>
                </div>
        </div>

 <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Cara Pembayaran:</label>
                  <div class="col-sm-9">
                   <select class="form-control select2" name="metode">
                     <option value="transfer">Transfer Bank</option>
                    <option value="cash">Cash</option>
                   
                </select>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="biaya" class="col-sm-3 control-label">Bank(Jika Transfer):</label>
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
                  <label for="keterangan" class="col-sm-3 control-label">Nama Pembayaran:</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="keterangan" value="" placeholder="Contoh: DP/Cicilan ke /Pelunasan" required>
                   </div>
                </div>
        </div>


  <div class="box-footer" >

                     <a href="hutang_beli" class="btn btn-warning btn-flat" >KEMBALI</a>


                <button type="submit" class="btn btn-info pull-right btn-flat" name="bayar" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
              </div>



</form>
        </div>

                                <!-- /.box-body -->
                            </div>




</div>

<?php } ?>



<div class="col-lg-6">


      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Riwayat Pembayaran</h3>

          <div class="box-tools pull-right">
            
          </div>
        </div>
        <div class="box-body">




<table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Pembayaran</th>
                  <th>Tanggal</th>
                   <th>Jumlah</th>
                  <th style="width: 10%">Diterima</th>
                   <?php if($a['status']=='hutang'){?>
                   <th style="width: 10px">Hapus</th>
               <?php } ?>
                </tr>

<?php 

$sql=mysqli_query($conn,"SELECT * FROM buy_payment WHERE nota='$q' order by no");
$no=1;
while($row=mysqli_fetch_assoc($sql)){

?>


                <tr>
                  <td><?php echo $no++;?>.</td>
                  <td><?php echo $row['keterangan'];?></td>
                  <td><?php echo date('d-m-Y',strtotime($row['tanggal']));?></td>
                    <td><?php echo number_format($row['jumlah']);?></td>


                    <?php if($row['metode']=='cash'){
                        $label='info';
                    } else {
                        $label='success';
                    }?>

                    <td><span class="label label-<?php echo $label;?>" ><?php echo $row['user'];?></span></td>
 <?php if($a['status']=='hutang'){?>

                    <td>
                        <a href="bayar_hutang_beli?hapus=yes&no=<?php echo $row['no'];?>&q=<?php echo $q;?>&j=<?php echo $row['jumlah'];?>&s=<?php echo $a['sudahbayar'];?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
<?php } ?>

                </tr>


<?php 


} ?>


                <tr>
                  <td></td>
                  <td colspan="2"> Total Sudah diBayar:</td>
                  
                    <td><b><?php echo number_format($a['sudahbayar']);?></b></td>
                  <td>
                    <?php if($a['status']=='belum'){?>
                    <h5><span class="label label-danger">BELUM LUNAS</span></h5>

                <?php } else {?>
                       <h5><span class="label label-primary">LUNAS</span></h5>

                <?php } ?>

                </td>
                </tr>
               
              </table>



        </div>
        <p>Keterangan:</p>
<span class="label label-info">Dibayar Cash</span>
<span class="label label-success">Dibayar Transfer</span>
    </div>



 <?php if($a['status']=='dibayar'){?>

<a href="hutang_beli" class="btn btn-warning">Kembali</a>

 <?php } ?>



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



<?php

    if(isset($_POST['bayar'])){
   if($_SERVER["REQUEST_METHOD"] == "POST"){
            $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
          $metode = mysqli_real_escape_string($conn, $_POST["metode"]);
          $jml= mysqli_real_escape_string($conn, $_POST["bayaran"]);
          $ket = mysqli_real_escape_string($conn, $_POST["keterangan"]);
          $tgl = mysqli_real_escape_string($conn, $_POST["tgl"]);
          $sisa = mysqli_real_escape_string($conn, $_POST["sisa"]);
            $sup = mysqli_real_escape_string($conn, $_POST["sup"]);
            $sudah = mysqli_real_escape_string($conn, $_POST["sudah"]);
          $user=$_SESSION['nama'];

          $sudahbayar=$sudah+$jml;

if($jml>0){

mysqli_query($conn,"SET session sql_mode = ''");	sql1="INSERT INTO buy_payment VALUES('$kode','$nota','$sup','$tgl','$jml','bank','$metode','$ket','$user','')";

if(mysqli_query($conn,$sql1)){



if($jml>=$sisa){
$sql=mysqli_query($conn,"UPDATE buy SET status='dibayar', sudahbayar='$sudahbayar' WHERE nota='$nota'");
$sql2=mysqli_query($conn,"UPDATE buy_hutang SET status='dibayar', sudahbayar='$sudahbayar' WHERE nota='$nota'");

} else {
$sql=mysqli_query($conn,"UPDATE buy SET sudahbayar='$sudahbayar' WHERE nota='$nota'");
$sql2=mysqli_query($conn,"UPDATE buy_hutang SET sudahbayar='$sudahbayar' WHERE nota='$nota'");
}



echo "<script type='text/javascript'>  alert('Berhasil, Pembayaran telah disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = 'bayar_hutang_beli?q=$nota';</script>";

} else {
      echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Hubungi Admin'); </script>";
           echo "<script type='text/javascript'>window.location = 'bayar_hutang_beli?q=$nota';</script>";
}

} else {
    echo "<script type='text/javascript'>  alert('Gagal, Pembayaran tidak boleh 0 atau dibawahnya'); </script>";
           echo "<script type='text/javascript'>window.location = 'bayar_hutang_beli?q=$nota';</script>";
}




}}?>









<?php

    if(isset($_GET['hapus'])){
   if($_SERVER["REQUEST_METHOD"] == "GET"){
            $no = mysqli_real_escape_string($conn, $_GET["no"]);
          $nota = mysqli_real_escape_string($conn, $_GET["q"]);
          $sudahbayar = mysqli_real_escape_string($conn, $_GET["s"]);
          $jml= mysqli_real_escape_string($conn, $_GET["j"]);


          $sudah2=$sudahbayar-$jml;

    $sql="UPDATE buy SET sudahbayar='$sudah2' WHERE nota='$nota'";

    if(mysqli_query($conn,$sql)){

$del=mysqli_query($conn,"DELETE FROM buy_payment WHERE no='$no'");

$del=mysqli_query($conn,"UPDATE buy_hutang SET sudahbayar='$sudah2' WHERE nota='$nota'");


echo "<script type='text/javascript'>window.location = 'bayar_hutang_beli?q=$nota';</script>";

    } else {
 echo "<script type='text/javascript'>  alert('Gagal, terjadi kesalahan query silahkan hubungi admin'); </script>";
echo "<script type='text/javascript'>window.location = 'bayar_hutang_beli?q=$nota';</script>";
    }




      } } ?>







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

<!-- Script -->
    <script src='jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

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
