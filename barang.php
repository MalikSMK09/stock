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
$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman


$cek=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang_setting"));
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


  <!-- KONTEN BODY AWAL -->
                         <!-- Default box -->
    
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-th"></i> Barang</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <p>     <?php if($chmod>=2 || $_SESSION['jabatan']=='admin'){ ?>
                <a href="add_barang" class='btn btn-success btn-sm' ><i class='fa fa-pencil-square-o'></i> Tambah</a>

                <a href="impor" class="btn btn-primary btn-sm" id="import"
                   ><i class='fa fa-upload'></i> Import Data</a>
               <?php } ?>

                <a href="" class="btn btn-default btn-sm" id="refresh"><i class='fa fa-refresh'></i> Refresh</a>

                <a href="barang?limit=true" class="btn btn-warning btn-sm" id="stokLimit"><i class='fa fa-refresh'></i> Stok Limit</a>
                <a href="barang?exp=true" class="btn btn-warning btn-sm" id="stokExpired"><i class='fa fa-refresh'></i> Expired</a>

                 <?php if($chmod>=4 || $_SESSION['jabatan']=='admin'){ ?>

                 <a class="btn btn-default" data-toggle="modal" data-target="#tambah"><i class="fa fa-gear"></i></a>
                    <?php } ?>
            </p>
             <div class="table-responsive" >
            <table class="table table-bordered table-hover" id="example2"  cellspacing="0">

                 <?php
               error_reporting(E_ALL ^ E_DEPRECATED);
               $sql    = "select * from barang";
               $result = mysqli_query($conn, $sql);
               $no_urut=0;
    ?>        

                <thead>
                    <tr>
                        <th style="width:70px">Action</th>
     <?php if($cek['view_sku']==1){?><th>SKU</th><?php } ?>
                        <th style="width:200px">
                            Nama&nbsp;Barang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
<?php if($cek['view_hbeli']!=0){?><th>Harga&nbsp;Beli&nbsp;</th><?php } ?>
 <?php if($cek['view_hjual']!=0){?><th>Harga&nbsp;Jual&nbsp;</th><?php } ?>
                       
 <?php if($cek['view_stok']!=0){?><th>Stok</th><?php } ?>
<?php if($cek['view_terjual']!=0){?><th>Terjual</th><?php } ?>
<?php if($cek['view_satuan']!=0){?> <th>satuan</th><?php } ?>
<?php if($cek['view_kategori']!=0){?><th>Kategori</th><?php } ?>
 <?php if($cek['view_lokasi']!=0){?> <th>Lokasi</th><?php } ?>
 <?php if($cek['view_warna']!=0){?>  <th>Warna</th><?php } ?>
 <?php if($cek['view_ukuran']!=0){?> <th>Ukuran</th><?php } ?>
 <?php if($cek['view_merek']!=0){?>  <th>Merek</th><?php } ?>
 <?php if($cek['view_expired']!=0){?><th>Expired</th><?php } ?>
<?php if($cek['view_sku']!=0){?><th>ID</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
                   
                <?php 
                  if(isset($_GET['exp'])){
                    $today=date('Y-m-d');
                    $sql=mysqli_query($conn,"SELECT * FROM barang WHERE expired !='0000-00-00' AND expired<='$today' ");

                  } else if( isset($_GET['limit'])) {
                    $sql=mysqli_query($conn,"SELECT * FROM barang WHERE sisa<=stokmin");
                  } else {

                $sql=mysqli_query($conn,"SELECT * FROM barang ORDER BY no");

              }
                    while($fill=mysqli_fetch_assoc($sql)){

                         echo '<tr>';
                         echo '<td>';?>

                         
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?q=<?php  echo $fill['no']; ?>'"><i class='fa fa-edit'></i></button>
           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'"><i class='fa fa-trash'></i></button>
           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='barang_detail?no=<?php echo $fill['no']?>'"><i class='fa fa-eye'></i></button>
           <?php } else {}?>
              

                   <?php    echo  '</td>';

if($cek['view_sku']!=0){  echo '<td>'.$fill['sku'].'</td>';}
if($cek['view_nama']!=0){  echo '<td>'.$fill['nama'].'</td>';}
if($cek['view_hbeli']!=0){ echo '<td>'.number_format($fill['hargabeli']).'</td>';}
if($cek['view_hjual']!=0){ echo '<td>'.number_format($fill['hargajual']).'</td>';}

                   
if($cek['view_stok']!=0){   echo '<td>'.number_format($fill['sisa']).'</td>';}
if($cek['view_terjual']!=0){   echo '<td>'.number_format($fill['terjual']).'</td>';}
 if($cek['view_satuan']!=0){   echo '<td>'.$fill['satuan'].'</td>';}                             
 if($cek['view_kategori']!=0){   echo '<td>'.$fill['kategori'].'</td>';}
 if($cek['view_lokasi']!=0){    echo '<td>'.$fill['lokasi'].'</td>';}
  if($cek['view_warna']!=0){   echo '<td>'.$fill['warna'].'</td>';}
  if($cek['view_ukuran']!=0){   echo '<td>'.$fill['ukuran'].'</td>';}
   if($cek['view_merek']!=0){  echo '<td>'.$fill['brand'].'</td>';}
    if($cek['view_expired']!=0){  echo '<td>'.$fill['expired'].'</td>';}
    if($cek['view_sku']!=0){  echo '<td>'.$fill['kode'].'</td>';}
                        echo '</tr>';


                    }?>

                </tbody>
            </table>

        </div>

        </div>
    </div>
</div>
 <a href="export_csv" class="btn bg-olive btn-sm"
                   ><i class='fa fa-download'></i> Excel</a>
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



          <div id="tambah" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Setelan Tabel barang </h4>
        </div>
        <div class="modal-body">
         
         <form method="post" action="">

       
          

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">SKU:</label>
                  <div class="col-sm-6"><div class="form-group">
                  <label><?php if($cek['view_sku']!=0){?>
                    <input type="checkbox" class="flat-red" name="sku" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="sku" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

                 <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Harga Beli:</label>
                  <div class="col-sm-6"><div class="form-group">
                  <label><?php if($cek['view_hbeli']!=0){?>
                    <input type="checkbox" class="flat-red" name="hbeli" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="hbeli" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Harga Jual:</label>
                  <div class="col-sm-6"><div class="form-group">
                  <label><?php if($cek['view_hjual']!=0){?>
                    <input type="checkbox" class="flat-red" name="hjual" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="hjual" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Stok:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_stok']!=0){?>
                    <input type="checkbox" class="flat-red" name="stok" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="stok" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Terjual:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_terjual']!=0){?>
                    <input type="checkbox" class="flat-red" name="terjual" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="terjual" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

                 <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Satuan:</label>
                  <div class="col-sm-6"><div class="form-group">
                  <label><?php if($cek['view_satuan']!=0){?>
                    <input type="checkbox" class="flat-red" name="satuan" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="satuan" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Kategori:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_kategori']!=0){?>
                    <input type="checkbox" class="flat-red" name="kategori" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="kategori" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Lokasi:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_lokasi']!=0){?>
                    <input type="checkbox" class="flat-red" name="lokasi" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="lokasi" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Warna:</label>
                  <div class="col-sm-6"><div class="form-group">
                  <label><?php if($cek['view_warna']!=0){?>
                    <input type="checkbox" class="flat-red" name="warna" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="warna" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Ukuran:</label>
                  <div class="col-sm-6"><div class="form-group">
                <label><?php if($cek['view_ukuran']!=0){?>
                    <input type="checkbox" class="flat-red" name="ukuran" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="ukuran" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Merek:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_merek']!=0){?>
                    <input type="checkbox" class="flat-red" name="merek" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="merek" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>

               <div class="row"><div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-6 control-label">Expired:</label>
                  <div class="col-sm-6"><div class="form-group">
                 <label><?php if($cek['view_expired']!=0){?>
                    <input type="checkbox" class="flat-red" name="exp" value="0" checked>
                      <?php    } else {?>
                    <input type="checkbox" class="flat-red" name="exp" value="1">
                     <?php } ?>
                </label>
                 Tampilkan
              </div>  </div>  </div>   </div>


        </div>

                  

        
        <div class="modal-footer">
        <p class="pull-left">*centang atribut yang ingin ditampilkan di tabel barang</p>
          <button type="submit" name="set" class="btn btn-primary btn-circle"><i class="fa fa-save"></i> Simpan</button> 
       <button class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Batal</button>
     </form>
        </div>
        </div>
    </div>
</div>






<?php
   if($_SERVER["REQUEST_METHOD"] == "POST"){
     if(isset($_POST['set'])){

    if(isset($_POST['sku'])){$sku = 1;}else{$sku=0;}
     if(isset($_POST['hbeli'])){$hbeli = 1;}else{$hbeli=0;}
      if(isset($_POST['hjual'])){$hjual = 1;}else{$hjual=0;}
       if(isset($_POST['stok'])){$stok = 1;}else{$stok=0;}
        if(isset($_POST['terjual'])){$terjual = 1;}else{$terjual=0;}
         if(isset($_POST['satuan'])){$satuan = 1;}else{$satuan=0;}
          if(isset($_POST['kategori'])){$kategori = 1;}else{$kategori=0;}
           if(isset($_POST['lokasi'])){$lokasi = 1;}else{$lokasi=0;}
            if(isset($_POST['warna'])){$warna = 1;}else{$warna=0;}
             if(isset($_POST['ukuran'])){$ukuran = 1;}else{$ukuran=0;}
              if(isset($_POST['merek'])){$merek = 1;}else{$merek=0;}
               if(isset($_POST['exp'])){$exp = 1;}else{$exp=0;}

          
    $sqla="UPDATE barang_setting SET view_sku='$sku',view_hbeli='$hbeli',view_hjual='$hjual',view_stok='$stok',view_terjual='$terjual',view_satuan='$satuan',view_kategori='$kategori',view_lokasi='$lokasi',view_warna='$warna',view_ukuran='$ukuran',view_merek='$merek',view_expired='$exp'";

    if(mysqli_query($conn,$sqla)){
         echo "<script type='text/javascript'>window.location = 'barang?set=sukses';</script>";
    } else {
         echo "<script type='text/javascript'>window.location = 'barang?set=gagal';</script>";
    }

          } }

?>


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
      "stateSave": true,
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
