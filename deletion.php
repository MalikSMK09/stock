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
$halaman = "deletion"; // halaman
$dataapa = "Penghapusan"; // data

$chmod = 5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$kode = $_GET['k'];
$tabel = $_GET['f'];
$next = $_GET['page'];


 
?>


<!-- SETTING STOP -->


<!-- BREADCRUMB -->

<ol class="breadcrumb ">
<li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
<li><a href="<?php echo $next;?>"><?php echo $tabel ?></a></li>
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


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->

                         <?php if($tabel=='barang'){?>
                         <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


           <li>Penghapusan akan berakibat:
                  <ol>
                    <li>Data Barang ini Terhapus</li>
                   
                    <li>Data Retur dan Pembelian terkait barang ini terhapus</li>
                     <li>Data Transaksi Retail & Invoice yang terkait barang ini terhapus (termasuk barang lain dalam transaksi tersebut)</li>
                    <li>Stok dari transaksi yang terhapus tidak bisa dikembalikan ke gudang</li>
                    
                  </ol>
            </li>

            <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">


                 <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="produk" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                <?php } else if($tabel=='supplier'){?>
                     <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


           <li>Penghapusan akan berakibat:
                  <ol>
                    <li>Data Supplier ini Terhapus</li>
                   <li>Data Transaksi Pembelian terkait supplier ini terhapus</li>
                   <li>Penghapusan Transaksi Pembelian tidak bisa mengembalikan stok seperti semula</li>
                  </ol>
            </li>

            <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">


                 <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="vendor" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                <?php } else if($tabel=='pelanggan'){ ?>

                     <div class="col-lg-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Konfirmasi Penghapusan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <b>Apakah anda yakin untuk menghapus data <?php echo $tabel;?> ini?</b>


           <li>Penghapusan akan berakibat:
                  <ol>
                    <li>Data Pelanggan ini Terhapus</li>
                    <li>Data Transaksi Penjualan yang terkait barang ini terhapus</li>
                    <li>Stok barang yang terjual kepada pelanggan ini tidak bisa dikembalikan</li>
                    
                  </ol>
            </li>

             <div class="box-footer">
                <form method="post">

                <input type="hidden" name="tabel" value="<?php echo $tabel;?>">
                 <input type="hidden" name="next" value="<?php echo $next;?>">
                  <input type="hidden" name="kode" value="<?php echo $kode;?>">
                  
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo $next;?>'">Kembali</button>
                <button type="submit" name="customer" class="btn btn-danger pull-right">YA, HAPUS</button>

            </form>
            </div>

        </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

                <?php } ?>





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



<!--PHP -->


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){


$kode = mysqli_real_escape_string($conn, $_POST["kode"]);
$next = mysqli_real_escape_string($conn, $_POST["next"]);
$tabel = mysqli_real_escape_string($conn, $_POST["tabel"]);

//hapus barang
if(isset($_POST['produk'])){

$cek1=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM invoicebeli WHERE kode='$kode'"));
$cek2=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM invoicejual WHERE kode='$kode'"));
$cek3=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM transaksimasuk WHERE kode='$kode'"));
$cek=$cek1+$cek2+$cek3;

if($cek>0){
     echo "<script type='text/javascript'>  alert('Gagal, barang tidak bisa dihapus ketika masih ada transaksi penjualan/pembelian terkait barang ini. Silahkan hapus dulu transaksi tersebut'); </script>";
} else {

$a=mysqli_query($conn,"DELETE FROM stok_keluar_daftar WHERE kode_barang='$kode'");
$b=mysqli_query($conn,"DELETE FROM stok_masuk_daftar WHERE kode_barang='$kode'");
$c=mysqli_query($conn,"DELETE FROM stok_sesuai_daftar WHERE kode_barang='$kode'");

$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";

}

}


//hapus supplier
if(isset($_POST['vendor'])){

$a=mysqli_query($conn,"DELETE buy,invoicebeli FROM buy INNER JOIN invoicebeli ON invoicebeli.nota=buy.nota WHERE buy.supplier='$kode'");
$b=mysqli_query($conn,"DELETE FROM buy_hutang WHERE kreditur='$kode'");
$c=mysqli_query($conn,"DELETE FROM buy_payment WHERE kreditur='$kode'");
$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";

}


//hapus barang
if(isset($_POST['customer'])){

$a=mysqli_query($conn,"DELETE FROM sale WHERE pelanggan='$kode'");
$b=mysqli_query($conn,"DELETE FROM sale_payment WHERE pelanggan='$kode'");

$c=mysqli_query($conn,"DELETE FROM surat WHERE kode_pelanggan='$kode'");

$e=mysqli_query($conn,"DELETE FROM $tabel WHERE kode='$kode'");

 echo "<script type='text/javascript'>window.location = '$next?delete=1';</script>";

}



}
?>













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
