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
$halaman = "cetak_barcode"; // halaman
$dataapa = "Form Barcode"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn,$tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
//$search = $_POST['search'];
$kode=$_GET['kode'];
 $sql = "SELECT * from $tabeldatabase where kode = '$kode' ";
$query = mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($query);
$barcode = $data['barcode'];
$nama = $data['nama'];
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

<div class="col-lg-6">
  <!-- KONTEN BODY AWAL -->
                            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?></h3>
            </div>
      <div class="box-body">
             
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Modul Cetak Barcode</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="print_barcode.php" target="_blank">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Barang</label>

                  <div class="col-sm-10">
                  <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                      <option selected="selected"> Pilih Barang</option>
              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
         $sql=mysqli_query($conn,"select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
        while ($row=mysqli_fetch_assoc($sql)){
          if ($barcode==$row['barcode'])
          echo "<option value='".$row['kode']."' barcode='".$row['barcode']."' kode='".$row['kode']."'  selected='selected'>".$row['sku']." | ".$row['nama']."</option>";
          else
          echo "<option value='".$row['kode']."' barcode='".$row['barcode']."' kode='".$row['kode']."'  >".$row['sku']." | ".$row['nama']."</option>";
        }
      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Barcode</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Barcode" value="<?php echo $barcode;?>" required>
                  </div>
                </div>

            <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Jumlah Print</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="jumlah print, isikan antara 1- 15">
                  </div>
                </div>
                <input type="hidden" class="form-control" id="kode" name="kode" >
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info ">Print</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
       

                                <!-- /.box-body -->
                            </div>
                        </div></div>

</div>



<?php


$set=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang_setting_barcode"));

$atas=$set['label_atas'];
$bawah=$set['label_bawah'];
$kolom = $set['jml_kolom'];

if($atas==1){
  $ceklis1="checked";
} else if($atas==2){
  $ceklis2="checked";
} else {
  $ceklis3="checked";
}

if($bawah==1){
  $ceklis4="checked";
} else if($bawah==2){
  $ceklis5="checked";
} else {
  $ceklis6="checked";
}


if($kolom==1){
  $ceklis7="checked";
} else if($kolom==2){
  $ceklis8="checked";
} else if($kolom==3){
  $ceklis9="checked";
  } else if($kolom==4){
  $ceklis10="checked";
} else {
  $ceklis11="checked";
}




?>


<form method="post">
<div class="col-lg-6">
  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Pengaturan Barcode</h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">




                                  
              <div class="form-group">
                   <div class="col-xs-3">
                    <p>Label bagian atas</p>
                    </div>

                   <div class="col-xs-3">
                    <label>
                      <input type="radio" name="atas" id="atas1" value="1" <?php echo $ceklis1;?>>
                     Nama
                    </label>
                  </div>
               

              <div class="col-xs-3">
                    <label>
                      <input type="radio" name="atas" id="atas2" value="2" <?php echo $ceklis2;?>>
                     Kode
                    </label>
                  </div>

               <div class="col-xs-3">
                    <label>
                      <input type="radio" name="atas" id="atas3" value="3" <?php echo $ceklis3;?>>
                     Harga
                    </label>
                  </div>

              </div>
<br>
<div class="col-xs-12"></div>

  <div class="form-group">
                   <div class="col-xs-3">
                    <p>Label bagian bawah</p>
                    </div>

                   <div class="col-xs-3">
                    <label>
                      <input type="radio" name="bawah" id="bawah1" value="1" <?php echo $ceklis4;?>>
                     Nama
                    </label>
                  </div>
               

              <div class="col-xs-3">
                    <label>
                      <input type="radio" name="bawah" id="bawah2" value="2" <?php echo $ceklis5;?>>
                     Kode
                    </label>
                  </div>

               <div class="col-xs-3">
                    <label>
                      <input type="radio" name="bawah" id="bawah3" value="3" <?php echo $ceklis6;?>>
                     Harga
                    </label>
                  </div>

              </div>
<div class="col-xs-12"></div><br>

              <div class="col-xs-12"></div>

            <div class="form-group">
                   <div class="col-xs-3">
                    <p>Jumlah Kolom</p>
                    </div>


                       <div class="col-xs-9">

                   <div class="col-xs-3">
                    <label>
                      <input type="radio" name="kolom" id="kolom1" value="1" <?php echo $ceklis7;?>>
                     1 
                    </label>
                  </div>

                  <div class="col-xs-2">
                    <label>
                      <input type="radio" name="kolom" id="kolom2" value="2" <?php echo $ceklis8;?>>
                     2
                    </label>
                  </div>

                  <div class="col-xs-2">
                    <label>
                      <input type="radio" name="kolom" id="kolom3" value="3" <?php echo $ceklis9;?>>
                     3
                    </label>
                  </div>
               

              <div class="col-xs-2">
                    <label>
                      <input type="radio" name="kolom" id="kolom4" value="4" <?php echo $ceklis10;?>>
                     4
                    </label>
                  </div>

               <div class="col-xs-2">
                    <label>
                      <input type="radio" name="kolom" id="kolom5" value="5" <?php echo $ceklis11;?>>
                     5
                    </label>
                  </div>

                </div>





              </div>

  


                           
                        </div>


 <div class="box-footer">

        <button class="btn btn-success pull-left" type="submit" name="setting">Simpan</button>
       </div>




                      </div>
</div>

</form>


<?php

    if(isset($_POST["setting"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $atas = mysqli_real_escape_string($conn, $_POST["atas"]);
              $bawah = mysqli_real_escape_string($conn, $_POST["bawah"]);
              $kolom = mysqli_real_escape_string($conn, $_POST["kolom"]);


              $sql="UPDATE barang_setting_barcode SET label_atas='$atas', label_bawah='$bawah', jml_kolom='$kolom'";

              if(mysqli_query($conn,$sql)){
                  echo "<script type='text/javascript'>  alert('Berhasil, pengaturan barcode sudah diubah!');</script>";
                  echo "<script type='text/javascript'>window.location = 'cetak_barcode';</script>";

              } else {
                echo "<script type='text/javascript'>  alert('Gagal, terjadi kesalah query, silahkan hubungi admin!');</script>";
              }

            } } 


?>












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



<script>
$("#produk").on("change", function(){

  var nama = $("#produk option:selected").attr("nama");
   var bar = $("#produk option:selected").attr("barcode");
    var kode = $("#produk option:selected").attr("kode");
 
 

  $("#nama").val(nama);
   $("#kode").val(kode);
   $("#barcode").val(bar);
    $("#jumlah").val(1);
  
});
</script>

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
