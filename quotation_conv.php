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
$halaman = "quotation_conv"; // halaman
$dataapa = "Konversi penawaran"; // data
$tabeldatabase = "quotation"; // tabel database
$chmod = $chmenu3; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$nota = SecurityBootstrap::secureNota($_GET['q'] ?? '');


function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM sale ORDER BY no";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%06s", $sort_num);
  return $new_code;
 }

?>


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $halaman;?>"><?php echo $dataapa ?></a></li>
<?php

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

  if(isset($_POST["conv"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

        $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
        $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
        $quo = mysqli_real_escape_string($conn, $_POST["quo"]);
        $harga = mysqli_real_escape_string($conn, $_POST["harga"]);
        $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
        $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
        $modal = mysqli_real_escape_string($conn, $_POST["modal"]);
         $nom = mysqli_real_escape_string($conn, $_POST["nom"]);

          $kasir = $_SESSION["username"];
              $kegiatan = "menjual barang hasil penawaran";
              $status = "pending";
              $today=date('Y-m-d');

          $sqle3="SELECT * FROM barang where kode='$kode'";
              $hasile3=mysqli_query($conn,$sqle3);
              $row=mysqli_fetch_assoc($hasile3);
              $sisaawal=$row['sisa'];
              $terbeliawal=$row['terbeli'];
              $terjualawal=$row['terjual'];

              $terjualakhir = $terjualawal + $jumlah;
              $sisaakhir = $sisaawal - $jumlah;
              $kurang = 0 - $jumlah;


        mysqli_query($conn,"SET session sql_mode = ''");	$sql1=mysqli_query($conn,"INSERT INTO invoicejual VALUES('$nota','$kode','$nama','$harga','','','$modal','$jumlah','','$harga','')");
        $sql2=mysqli_query($conn,"UPDATE quotation_list SET conv='1' WHERE no='$nom'");
         $sql3 = mysqli_query($conn,"UPDATE barang SET sisa='$sisaakhir',terjual='$terjualakhir' where kode='$kode'");
           mysqli_query($conn,"SET session sql_mode = ''");	$sql4 = mysqli_query($conn,"INSERT INTO mutasi values ( '$kasir','$today','$kode','$sisaakhir','$kurang','$kegiatan','$quo','','$status')");

        echo "<script type='text/javascript'>window.location = 'quotation_conv?q=$quo';</script>";


} }

  if(isset($_POST["unconv"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

        $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
        $quo = mysqli_real_escape_string($conn, $_POST["quo"]);
          $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
          $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
           $kegiatan = "menjual barang hasil penawaran";

           $sqle3="SELECT * FROM barang where kode='$kode'";
              $hasile3=mysqli_query($conn,$sqle3);
              $row=mysqli_fetch_assoc($hasile3);
              $sisaawal=$row['sisa'];
              $terjualawal=$row['terjual'];

              $terjualakhir = $terjualawal - $jumlah;
              $sisaakhir = $sisaawal + $jumlah;
              


        $sql1=mysqli_query($conn,"UPDATE quotation_list SET conv='0' WHERE nota='$quo' AND kode='$kode'");
         $sql2 = mysqli_query($conn,"UPDATE barang SET sisa='$sisaakhir',terjual='$terjualakhir' where kode='$kode'");
         $sql3=mysqli_query($conn,"DELETE FROM invoicejual WHERE no='$nom'");
          $sql4=mysqli_query($conn,"DELETE FROM mutasi WHERE kodebarang='$kode' AND kegiatan='$kegiatan' AND keterangan='$quo' ");

        echo "<script type='text/javascript'>window.location = 'quotation_conv?q=$quo';</script>";


} }

?>


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
                         <!-- Default box -->
                         <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Penawaran</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
       
          <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th style="width: 10%">Harga</th>
                  <th style="width: 10%">Jumlah</th>
                  <th style="width: 40px">Aksi</th>
                </tr>

              <?php $q1=mysqli_query($conn,"SELECT * FROM quotation_list WHERE nota='$nota'");
                    $no=1;
                    while($row=mysqli_fetch_assoc($q1)){?>

                <tr>
                  <td><?php echo $no++;?></td>
                  <td><?php echo $row['nama'];?></td>
                  <td><?php echo $row['harga'];?></td>
                  <td>
                   <?php echo $row['jumlah'];?>
                  </td>
                  <td>
                    <?php if($row['conv']<1){?>
                    <form method="post">
                      <input type="hidden" name="nota" value="<?php echo autoNumber();?>">
                      <input type="hidden" name="kode" value="<?php echo $row['kode'];?>">
                      <input type="hidden" name="nama" value="<?php echo $row['nama'];?>">
                      <input type="hidden" name="harga" value="<?php echo $row['harga'];?>">
                      <input type="hidden" name="jumlah" value="<?php echo $row['jumlah'];?>">
                      <input type="hidden" name="hargaakhir" value="<?php echo $row['hargaakhir'];?>">
                      <input type="hidden" name="modal" value="<?php echo $row['modal'];?>">
                       <input type="hidden" name="nom" value="<?php echo $row['no'];?>">
                      <input type="hidden" name="quo" value="<?php echo $nota;?>">
                    <button type="submit" name="conv" class="btn btn-xs btn-primary"><i class="fa fa-arrow-right"></i></button>
                  </form>
                <?php } ?>
                  </td>
                </tr>
              <?php } ?>
                              </table>


        </div>

                                <!-- /.box-body -->
                            </div>
                            <a href="quotation" class="btn btn-block btn-warning"><i class="fa fa-arrow-left"></i> KEMBALI</a>
                          </div>




<div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Penjualan <?php echo autoNumber();?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          
          <table class="table table-bordered">
                <tr>
                  <th style="width: 40px">Aksi</th>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  
                </tr>
          <?php $q2=mysqli_query($conn,"SELECT * FROM invoicejual WHERE nota =".autoNumber()." ORDER BY no");
                  $no_urut=1;
                  while($fill=mysqli_fetch_assoc($q2)){?>
                <tr>
                  <td><form method="post">
                     <input type="hidden" name="quo" value="<?php echo $nota;?>">
                     <input type="hidden" name="kode" value="<?php echo $fill['kode'];?>">
                     <input type="hidden" name="jumlah" value="<?php echo $fill['jumlah'];?>">
                     <input type="hidden" name="nom" value="<?php echo $fill['no'];?>">
                    <button type="submit" name="unconv" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i></button>
                  </form></td>
                  <td><?php echo $no_urut++;?></td>
                   <td><?php echo $fill['nama'];?></td>
                  <td><?php echo $fill['harga'];?></td>
                  <td>
                   <?php echo $fill['jumlah'];?>
                  </td>
                </tr>
                <?php } ?>
              </table>


        </div>

                                <!-- /.box-body -->
                            </div>
                            <a class="btn btn-block btn-success" href="quotation_conv_final?q=<?php echo $nota;?>&nota=<?php echo autoNumber();?>">Buat Invoice <i class="fa fa-arrow-right"></i></a>
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
