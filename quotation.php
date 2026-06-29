<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
etc();encryption();session();connect();head();body();timing();
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
$halaman = "quotation"; // halaman
$dataapa = "Penawaran"; // data
$tabeldatabase = "quotation"; // tabel database
$chmod = $chmenu3; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

$now=date('Y-m-d');
 
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


<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <h3 style="font-size: 30px"><?php echo $qaktif;?></h3>

              <p>Penawaran Aktif</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size: 30px"><?php echo number_format($qsuc, $decimal, $a_decimal, $thousand);?></h3>

              <p>Penawaran Berhasil</p>  
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 30px"><?php echo number_format($qnon, $decimal, $a_decimal, $thousand);?></h3>
              <p>Penawaran Nonaktif</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 30px"><?php echo number_format($qexp, $decimal, $a_decimal, $thousand);?></h3>

              <p>Penawaran Kadaluarsa</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
    
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Barang</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <p>
                  <?php if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') { ?>
                <a href="add_quotation" class='btn btn-info btn-sm' ><i class='fa fa-pencil-square-o'></i> Tambah</a>
            <?php } ?>
              

          <a href="quotation?conv=true" class="btn btn-success btn-sm" id="stokLimit"><i class='fa fa-refresh'></i> Daftar Konversi</a>
                
                 <a href="quotation?off=true" class="btn btn-warning btn-sm" id="refresh">Daftar Nonaktif</a>
            </p>
            <table class="table table-bordered table-hover" id="example2" width="100%" cellspacing="0">

                 <?php
               error_reporting(E_ALL ^ E_DEPRECATED);
               $sql    = "select * from quotation WHERE status='aktif'";
               $result = mysqli_query($conn, $sql);
               $no_urut=0;
    ?>        

                <thead>
                    <tr>
                        <th style="width:70px">Opsi</th>
                        <th>Nomor</th>
                        <th>Batas Berlaku</th>
                        
                        <th style="width:200px">
                            Nama&nbsp;Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
                        <th>Total</th>
                        <th>Estimasi Laba</th>
                       
                       
                        
                        <th>Oleh</th>
                        <th>Dibuat</th>
                        <th>Status</th>
                           <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                   
                <?php 
                  if(isset($_GET['conv'])){
                 $sql=mysqli_query($conn,"SELECT * FROM quotation WHERE status='berhasil' ORDER BY no desc");

                  } else if( isset($_GET['off'])) {
                    $sql=mysqli_query($conn,"SELECT * FROM quotation WHERE status='nonaktif' ORDER BY no desc");
                  } else {

                $sql=mysqli_query($conn,"SELECT * FROM quotation WHERE status='aktif' ORDER BY no desc");

              }
                    while($fill=mysqli_fetch_assoc($sql)){

                         echo '<tr>';
                         echo '<td>';?>

                         
          <?php  

          if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { 
             if(isset($_GET['conv'])){} else {  ?>
          <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_quot?nota=<?php echo $fill['nota'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'"><i class='fa fa-trash'></i></button>
           <?php } }?>

           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <a target="_blank" class="btn btn-info btn-xs" href="print_redirect?tipe=quotation&nota=<?php echo $fill['nota']?>"><i class='fa fa-eye'></i></a>
           <?php } else {}?>
              

                   <?php    echo  '</td>';

                        echo '<td>'.$fill['nomor'].'</td>';
                        if($fill['due']<=$now){
                        echo '<td style="background-color:#E07171;">'.$fill['due'].'</td>';
                       } else {
                           echo '<td>'.$fill['due'].'</td>';
                        }

                        $pl=$fill['pelanggan'];
                        $custo=mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM pelanggan WHERE kode='$pl'"));
                         echo '<td>'.$custo['nama'].'</td>';
                        
                        echo '<td>'.number_format($fill['total']).'</td>';
                        echo '<td>'.number_format($fill['modal']).'</td>';
                                                       
                              echo '<td>'.$fill['oleh'].'</td>';
                              echo '<td>'.$fill['tgl'].'</td>';
                              echo '<td>'.$fill['status'].'</td>';

                              echo '<td>';
                              
                              if( ($fill['status']!='nonaktif')&&(!isset($_GET['conv'])) ){

                              echo '<a class="btn bg-maroon btn-xs" href="quotation_cek?q='.$fill['nota'].'">Konversi</a>


                               <a class="btn btn-default btn-xs" href="component/setting/status_pelanggan.php?no='.$fill['no'].'&tabel=quotation&status=nonaktif&forwardpage='.$forwardpage.'&chmod='.$chmod.'">Nonaktifkan</a>
                              </td>';

                            } ;
                            
                        echo '</tr>';


                    }?>

                </tbody>
            </table>

        </div>
    </div>
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
<!-- Script -->
    <script>
  $(function () {
    $("#DataTable").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
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
