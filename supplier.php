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
$halaman = "supplier"; // halaman
$dataapa = "Supplier"; // data
$tabeldatabase = "supplier"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];


function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM $forward ORDER BY kode";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 4);
  $sort_num++;
  $new_code = sprintf("%04s", $sort_num);
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
          </h3> <a href="" data-toggle="modal" data-target="#modal-tambah" class="btn btn-sm bg-blue">Tambah Supplier</a> <a href="" data-toggle="modal" data-target="#modal-import" class="btn btn-sm bg-green">Import Excel</a>
          <a href="supplier" class="btn btn-sm bg-orange">Refresh</a>

        <form method="get">
        <br/>
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="find" class="form-control pull-right" placeholder="Cari">

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
        if(isset($_GET['find']) && $_GET['find']!=''){
            $qw = $_GET['find'];
    $sql    = "select * from $forward where nama LIKE '%$qw%' or kode LIKE '%$qw%' order by no";
} else {
    $sql    = "select * from $forward order by no";
}

    $result = mysqli_query($conn, $sql);
    $rpp    = 50;
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
                                                <th>Kode Supplier</th>
                                                <th>Nama</th>
                                                <th>Tanggal Daftar</th>
                                                <th>No Handphone</th>
                                                <th>Alamat</th>
                                                
                        <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                                <th>Opsi</th>
                        <?php }else{} ?>
                                            </tr>
                                        </thead>
    <?php
      while(($count<$rpp) && ($i<$tcount)) {
      mysqli_data_seek($result,$i);
      $fill = mysqli_fetch_array($result);
      ?>
                      <tbody>
<tr>
            <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['tgldaftar']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nohp']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['alamat']); ?></td>
            
            <td>
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <a href=""  data-toggle="modal" data-target="#modaledit<?php echo $fill['no'];?>" class="btn btn-success btn-xs" >Edit</a>
           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
               <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='deletion?k=<?php echo $fill['kode'].'&'; ?>f=<?php echo $forward.'&';?>page=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
               <?php } else {}?>
           </td></tr>




<!--modal edit-->


<div class="modal fade" id="modaledit<?php echo $fill['no'];?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Data Supplier <?php echo $fill['kode'];?> </h4>
              </div>
              <div class="modal-body">

<form method="post">
<div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Supplier:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $fill['nama'];?>"  placeholder="Masukan Nama Supplier" maxlength="50" required>
                    <input type="hidden" class="form-control" id="kode" name="kode" value="<?php echo $fill['kode'];?>"  >
                      <input type="hidden" class="form-control"  name="tgldaftar" value="<?php echo $fill['tgldaftar'];?>"  >
                  </div>
                </div>
        </div>

       
        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nohp" class="col-sm-3 control-label">No Handphone:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nohp" name="nohp" value="<?php echo $fill['nohp'];?>" placeholder="Masukan Nomor Handphone" maxlength="50" required>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="alamat" class="col-sm-3 control-label">Alamat:</label>
                  <div class="col-sm-9">
                  <textarea class="form-control" rows="3" id="alamat" name="alamat" maxlength="255" placeholder="Masukan Alamat" required><?php echo $fill['nama'];?></textarea>
                   </div>
                </div>
        </div>


                  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" name="simpansupplier" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </div>
</form>
          
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
<!--modal edit end-->




      <?php
      $i++;
      $count++;
    }

    ?>
                  </tbody></table>
          <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
                               </div>
                                <!-- /.box-body -->
                            </div>

              <?php } else {} ?>
                        </div>
                        <!-- ./col -->
                    </div>



<div class="modal fade" id="modal-tambah">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Supplier</h4>
              </div>
              <div class="modal-body">



<form class="form-horizontal" method="post" id="Myform">
              <div class="box-body">

        <div class="row">
                <div class="form-group col-md-12 col-xs-12" >
                  <label for="kode" class="col-sm-3 control-label">Kode Supplier:</label>
                  <div class="col-sm-9">
                
                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                
          </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nama" class="col-sm-3 control-label">Nama Supplier:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama" name="nama"  placeholder="Masukan Nama Supplier" maxlength="50" required>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="tgldaftar" class="col-sm-3 control-label">Tanggal Daftar:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control pull-right" name="tgldaftar" value="<?php echo date('Y-m-d');?>" readonly>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="nohp" class="col-sm-3 control-label">No Handphone:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nohp" name="nohp" placeholder="Masukan Nomor Handphone" maxlength="50" required>
                  </div>
                </div>
        </div>

        <div class="row">
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="alamat" class="col-sm-3 control-label">Alamat:</label>
                  <div class="col-sm-9">
                  <textarea class="form-control" rows="3" id="alamat" name="alamat" maxlength="255" placeholder="Masukan Alamat" required></textarea>
                   </div>
                </div>
        </div>


  
              </div>

                  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" name="simpansupplier" class="btn btn-primary">Simpan</button>
              </div>
            </div>
</form>
          
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->







<div class="modal fade" id="modal-import">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Data Supplier</h4>
              </div>
              <div class="modal-body">

                <p>
                    1. Download dan isikan format Import Supplier dibawah<br>
                    2. Semua kolom diisi dengan benar lalu simpan<br>
                    3. Pilih file yang telah diisi dan klik tombol <b>"Upload"</b><br>
                    4. untuk data yang namanya sama akan di skip.
                </p>

                <form method="post" enctype="multipart/form-data" action="supplier_import.php">

                     <input type="file" name="file" class="pull-left">

                     <br>


                  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                 <a href="tmp/format_supplier.csv" class="btn btn-primary pull-left" download="format_supplier.csv"> <i class="fa fa-download"></i> Download Format</a>
                <button type="submit" name="import" class="btn btn-success"><i class='fa fa-upload'></i> Upload</button>
            </form>
              </div>
            </div>

          
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




<?php

      if(isset($_POST["simpansupplier"])){
   if($_SERVER["REQUEST_METHOD"] == "POST"){

          $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
          $tgldaftar = mysqli_real_escape_string($conn, $_POST["tgldaftar"]);
          $nohp = mysqli_real_escape_string($conn, $_POST["nohp"]);
          $alamat = mysqli_real_escape_string($conn, $_POST["alamat"]);
      


             $sql="select * from $tabeldatabase where kode='$kode'";
        $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){
          if($chmod >= 3 || $_SESSION['jabatan'] == 'admin'){
                  $sql1 = "update $tabeldatabase set nama='$nama',nohp='$nohp',alamat='$alamat' where kode='$kode'";
                  $updatean = mysqli_query($conn, $sql1);
                  echo "<script type='text/javascript'>  alert('Berhasil, Data telah diupdate!'); </script>";
                  echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
        }else{
          echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
          echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
          }
        }
      else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){
         mysqli_query($conn,"SET session sql_mode = ''");	  $sql2 = "insert into $tabeldatabase values( '$kode','$tgldaftar','$nama','$alamat','$nohp','')";
           if(mysqli_query($conn, $sql2)){
           echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
         }else{
           echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
           echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
         }
           }

  } }


         ?>









                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                    </div>
                    <!-- /.row (main row) -->
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
