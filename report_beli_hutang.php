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
$halaman = "report_beli_hutang"; // halaman
$dataapa = "Hutang Pembelian"; // data
$tabeldatabase = "buy_hutang"; // tabel database
$chmod = $chmenu9; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>


<!-- SETTING STOP -->
<style>
html, body {
    overflow-x: hidden;
}
</style>

<!-- BOX INSERT BERHASIL -->

      
       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
     
     <div class="col-lg-12">
    <div class="box">
        <div class="box-body">
            <div class="col-md-6">

                <table class="table">
                    <form method="get">
                    <tr>
                        <td>Tanggal Awal</td>
                        <td>
                            <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                id="datepicker" data-language="en" value="<?php echo date("Y-m-d");?>" name="start">
                        </td>
                        <td>
                            <select class="form-control select2" style="width: 100%" name="sup">
                                <option value="all">Semua Supplier</option>
                               <?php
                                    $sql=mysqli_query($conn,"select * from supplier");
                                    while ($row=mysqli_fetch_assoc($sql)){
                                      if ($supplier==$row['kode'])
                                      echo "<option value='".$row['kode']."' selected='selected'>".$row['kode']." | ".$row['nama']."</option>";
                                      else
                                      echo "<option value='".$row['kode']."'>".$row['kode']." | ".$row['nama']."</option>";
                                    }
                                  ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Akhir</td>

                        <td>
                            <input title="tanggal transaksi" class="form-control datepicker-here" type="text"
                                id="datepicker2" data-language="en" value="<?php echo date("d/m/Y");?>" name="end">
                        </td>

                        <td>
                            <button type="submit" name="filter" class="btn btn-success" style="width:100%" ><i
                                    class='fa fa-search'></i> Filter</button>
                        </td>
                    </tr>
                </form>
                </table>
            </div>



            <div class="col-md-6">


<?php

 if(isset($_GET['filter'])){

     $s=$_GET['sup'];
            $dr=$_GET['start'];
            $sam=$_GET['end'];

if($s !='all'){
                $sqla="SELECT SUM(hutang) as tbeli FROM buy_hutang WHERE kreditur='$s' AND tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
                 $sqlc="SELECT SUM(sudahbayar) as tsubayar FROM buy_hutang WHERE kreditur='$s' AND tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";

 $sqld="SELECT SUM(sudahbayar) as tembayar, SUM(hutang) as tembeli FROM buy_hutang WHERE kreditur='$s' AND status LIKE 'hutang' AND due BETWEEN '" . $dr . "' AND  '" . $sam . "' ";

            } else {
                 $sqla="SELECT SUM(hutang) as tbeli FROM buy_hutang WHERE tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
                 $sqlc="SELECT SUM(sudahbayar) as tsubayar FROM buy_hutang WHERE tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";

                 $sqld="SELECT SUM(sudahbayar) as tembayar, SUM(hutang) as tembeli FROM buy_hutang WHERE status LIKE 'hutang' AND due BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
            }

$b=mysqli_fetch_assoc(mysqli_query($conn,$sqla));


$c=mysqli_fetch_assoc(mysqli_query($conn,$sqlc));

$d=mysqli_fetch_assoc(mysqli_query($conn,$sqld));


echo '  <div >
        <table>
        <tr>
            <td><h3>TOTAL HUTANG</h3></td>
             <td style="width:50%"><h3>:</h3></td>
             
            <td><h3>'.number_format($b['tbeli']-$c['tsubayar']).'</h3></td>
        </tr>

         <tr>
        <td>TOTAL TAGIHAN</td>
             <td style="width:50%"><h3></h3></td>
             
            <td>'.number_format($b['tbeli']).'</td>
        </tr>

         <tr>
        <td>SUDAH TERBAYAR</td>
             <td style="width:50%"><h3></h3></td>
             
            <td><b>'.number_format($c['tsubayar']).'</b></td>
        </tr>
        </table>
        </div>';

}

$dari=date('d-m-Y', strtotime($dr));
$sampai=date('d-m-Y', strtotime($sam));

?>
              


            </div>
        </div>
    </div>
</div>
<?php if(isset($_GET['filter'])){?>
<div class="col-lg-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> <?php echo $dataapa;?> (<?php echo ''.$dari.'-'.$sampai.'';?>)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <p>
                
                <a href="laporan_beli_hutang" class='btn btn-warning btn-sm' id='refresh'><i class='fa fa-refresh'></i> Refresh</a>
            </p>
            <div class="table-responsive">
               <table class="table table-bordered table-hover" id="example2" >
                    <thead>
                        <tr>
                            <th style="width:50px">ID</th>
                            <th>Tanggal</th>
                            <th>No.Pembelian</th>
                            <th>Supplier</th>
                            <th>Hutang</th>
                             <th>Jatuh Tempo</th>
                            
                             <th>Keterangan</th>
                           
                        </tr>
                    </thead>
                    

        <?php   if(isset($_GET['filter'])){

                      if($s !='all'){
                $sql="SELECT * FROM buy_hutang WHERE kreditur='$s' AND tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
            } else {
                 $sql="SELECT * FROM buy_hutang WHERE tgl BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
            }
            $qry=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($qry)){
                
        ?>

                <tr>
                    <td><?php echo $row['nota'];?></td>
                    <td><?php echo date('d-m-Y',strtotime($row['tgl']));?></td>
                      <td><?php echo $row['faktur'];?></td>
                       <td><?php $supe= $row['kreditur'];
                            $ca=mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM supplier WHERE kode='$supe'"));
                            echo $ca['nama'];
                        ?></td>
                       <td><?php echo number_format($row['hutang']-$row['sudahbayar']);?></td>
                         <td><?php echo date('d-m-Y',strtotime($row['due']));?></td>
                       
                         <td><?php echo $row['keterangan'];?></td>
                </tr>
                        
        <?php } 


        ?>
            
         <tfoot>
                         <tr>
                            <th style="width:50px"></th>
                            <th>Total</th>
                            <th></th>
                             <th></th>
                            <th><?php echo number_format($b['tbeli']-$c['tsubayar']);?></th>
                            <th></th>
                            <th style="width:30px"></th>
                        </tr>


        <?php } ?>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


<?php if( mysqli_num_rows(mysqli_query($conn,$sqld))> 0 ){?>





<div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Hutang Jatuh Tempo (<?php echo ''.$dari.'-'.$sampai.'';?>)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <p>
                
               
            </p>
            <div class="table-responsive">
               <table class="table table-bordered table-hover" id="example3" >
                    <thead>
                        <tr>
                            <th style="width:50px">ID</th>
                            <th>Tanggal</th>
                            <th>No.Pembelian</th>
                            <th>Supplier</th>
                            <th>Perlu Dibayar</th>
                             <th>Jatuh Tempo</th>
                            
                             <th>Keterangan</th>
                           
                        </tr>
                    </thead>
                    

        <?php   if(isset($_GET['filter'])){

                      if($s !='all'){
                $sql="SELECT * FROM buy_hutang WHERE kreditur='$s' AND due BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
            } else {
                 $sql="SELECT * FROM buy_hutang WHERE due BETWEEN '" . $dr . "' AND  '" . $sam . "' ";
            }
            $qry=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($qry)){
                
        ?>

                <tr>
                    <td><?php echo $row['nota'];?></td>
                    <td><?php echo date('d-m-Y',strtotime($row['tgl']));?></td>
                      <td><?php echo $row['faktur'];?></td>
                       <td><?php $supe= $row['kreditur'];
                            $ca=mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM supplier WHERE kode='$supe'"));
                            echo $ca['nama'];
                        ?></td>
                       <td><?php echo number_format($row['hutang']-$row['sudahbayar']);?></td>
                         <td><span class="label label-danger"><?php echo date('d-m-Y',strtotime($row['due']));?></span></td>
                       
                         <td><?php echo $row['keterangan'];?></td>
                </tr>
                        
        <?php } 


        ?>
            
         <tfoot>
                         <tr>
                            <th style="width:50px"></th>
                            <th>Total</th>
                            <th></th>
                             <th></th>
                            <th><?php echo number_format($d['tembeli']-$d['tembayar']);?></th>
                            <th></th>
                            <th style="width:30px"></th>
                        </tr>


        <?php } ?>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

<?php } ?>





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
    $('#example3').DataTable({
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
