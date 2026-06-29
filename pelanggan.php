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
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "pelanggan"; // halaman
$dataapa = "Pelanggan"; // data
$tabeldatabase = "pelanggan"; // tabel database
$chmod = $chmenu3; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];

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

<!-- BOX HAPUS BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>

                           <?php
if (isset($_GET['delete'])) {
?>
    <div id="myAlert"  class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Berhasil!</strong> <?php echo $dataapa;?> telah berhasil dihapus dari Data <?php echo $dataapa;?>.
</div>

<!-- BOX HAPUS BERHASIL -->
<?php } ?>
       <!-- BOX INFORMASI -->
    <?php
if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>

<?php
if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
?>

<?php

        $sqla="SELECT no, COUNT( * ) AS totaldata FROM $forward";
    $hasila=mysqli_query($conn,$sqla);
    $rowa=mysqli_fetch_assoc($hasila);
    $totaldata=$rowa['totaldata'];

?>
                           <div class="box">
            <div class="box-header">
            <h3 class="box-title">Data <?php echo $forward ?>  <span class="label label-default"><?php echo $totaldata; ?></span>
          </h3> <a href="add_pelanggan" class="btn bg-blue btn-sm">Tambah Pelanggan</a> <a href=""  data-toggle="modal" data-target="#modal-import" class="btn bg-green btn-sm">Import</a>

        <form method="post">
        <br/>
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>

          </form>


            </div>

                                <!-- /.box-header -->
                                  <!-- /.Paginasi -->
                                 <?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    $sql    = "select * from $forward order by no desc";
    $result = mysqli_query($conn, $sql);
    $rpp    = 15;
    $reload = "$halaman"."?pagination=true";
    $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

    if ($page <= 0)
        $page = 1;
    $tcount  = mysqli_num_rows($result);
    $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
    $count   = 0;
    $i       = ($page - 1) * $rpp;
    $no_urut = ($page - 1) * $rpp;
?>
                            <div class="box-body table-responsive">
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Pelanggan</th>
                                                <th>Nama</th>
                                                <th>Tanggal Daftar</th>
                                                <th>No Handphone</th>
                                                <th>Email</th>
                                                  <th>Status</th>
                                                <th>Alamat</th>
                                                
                        <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                                <th>Opsi</th>
                        <?php }else{} ?>
                                            </tr>
                                        </thead>
                                          <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    $search = $_POST['search'];

    if ($search != null || $search != "") {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

              if(isset($_POST['search'])){
        $query1="SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' order by no limit $rpp";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>
                     <tbody>
<tr>
            <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['idpelanggan']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['tgldaftar']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nohp']); ?></td>
             <td><?php  echo mysqli_real_escape_string($conn, $fill['email']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['alamat']); ?></td>
            

            <td>
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Edit</button>

          <button type="button" class="btn btn-warning btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Convert</button>
           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='deletion?k=<?php echo $fill['kode'].'&'; ?>f=<?php echo $forward.'&';?>page=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
              </td></tr><?php
          ;
        }

        ?>
                  </tbody></table>
 <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
     <?php
      }

    }

  } else {
    while(($count<$rpp) && ($i<$tcount)) {
      mysqli_data_seek($result,$i);
      $fill = mysqli_fetch_array($result);
      ?>
                      <tbody>
<tr>
            <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['idpelanggan']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['tgldaftar']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nohp']); ?></td>
             <td><?php  echo mysqli_real_escape_string($conn, $fill['email']); ?></td>
               <td><?php  if($fill['status']=='pelanggan'){
                echo '<span class="label label-success">Berlangganan</span>';
                       } else {
                echo '<span class="label label-info">Calon Pelanggan</span>';
                       }
               ?>
                 
               </td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['alamat']); ?></td>
            
            <td>
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Edit</button>

                <?php if($fill['status']!="pelanggan"){?>
          <button type="button" class="btn btn-warning btn-xs" onclick="window.location.href='component/setting/status_pelanggan.php?no=<?php  echo $fill['no']; ?>&tabel=pelanggan&status=pelanggan&forwardpage=<?php echo $forwardpage;?>&chmod=<?php echo $chmod;?>'">Convert</button><?php } ?>

           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
               <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='deletion?k=<?php echo $fill['kode'].'&'; ?>f=<?php echo $forward.'&';?>page=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
               <?php } else {}?>
           </td></tr>
      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody></table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
  <?php } ?>
<div class="col-xs-1" align="right">
         
        </div>
                               </div>
                                <!-- /.box-body -->
                            </div>

              <?php } else {} ?>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                    </div>
                    <!-- /.row (main row) -->







<div class="modal fade" id="modal-import">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Data Pelanggan</h4>
              </div>
              <div class="modal-body">

                <p>
                    1. Download dan isikan format Import Pelanggan dibawah<br>
                    2. Semua kolom diisi dengan benar lalu simpan<br>
                    3. Pilih file yang telah diisi dan klik tombol <b>"Upload"</b><br>
                    4. untuk data yang namanya sama akan di skip.
                </p>

                <form method="post" enctype="multipart/form-data" action="pelanggan_import.php">

                     <input type="file" name="file" class="pull-left">

                     <br>


                  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                 <a href="tmp/format_pelanggan.csv" class="btn btn-primary pull-left" download="format_pelanggan.csv"> <i class="fa fa-download"></i> Download Format</a>
                <button type="submit" name="import" class="btn btn-success"><i class='fa fa-upload'></i> Upload</button>
            </form>
              </div>
            </div>

          
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->










                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
           <?php footer();?>
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
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
        <script src="dist/js/pages/dashboard.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>

    </body>
</html>
