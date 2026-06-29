<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
etc();encryption();session();connect();head();body();timing();
//alltotal();
//pagination();
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
                <!-- Content Header (Page header) -->
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$halaman = "set_faktur"; // halaman
$dataapa = "Layout Faktur"; // data
$tabeldatabase = ""; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


 $sql="select tipenota from backset";
  $result=mysqli_query($conn,$sql);
  $qr=mysqli_fetch_assoc($result);
  $a=$qr['tipenota'];
?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->
<div class="col-lg-12">
<ol class="breadcrumb ">
<li><a href="#">Pilih Layout Faktur</a></li>
</ol>
</div>

<!-- BREADCRUMB -->




                                <!-- /.box-body -->

                        <!-- ./col -->

                </div>


                <div class="row">
                <?php if($_SESSION['jabatan'] !='admin'){}else{ ?>




<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="dist/img/inv5.png" alt="..." class="img-thumbnail">
      <div class="caption" align="right">
        <h4 align="center">Default</h4>
    <form method="post">
<?php if($a==5){?>
      <span class="btn btn-sm btn-success btn-flat" >Dipakai</span>
<?php } else {?>
    <button type="submit" class="btn btn-sm btn-default btn-flat" name="pilih5" ><span class="glyphicon glyphicon-check"></span> Pilih</button>
<?php } ?>

    </form>
    </div><p>Kertas A4/Letter, 1 halaman 27 item, bila lebih akan jadi halaman baru</p>
    </div>
  </div>



     <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="dist/img/inv4.png" alt="..." class="img-thumbnail">
      <div class="caption" align="right">
        <h4 align="center">1/2 ukuran A4 (A5)</h4>
    <form method="post">
<?php if($a==4){?>
      <span class="btn btn-sm btn-success btn-flat" >Dipakai</span>
<?php } else {?>
    <button type="submit" class="btn btn-sm btn-default btn-flat" name="pilih4" ><span class="glyphicon glyphicon-check"></span> Pilih</button>
<?php } ?>

    </form>
     </div><p>1 Kertas A4 bisa 2 halaman, 1 halaman 9 item, bila lebih akan jadi halaman baru.</p>
    </div>
  </div>



              <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="dist/img/inv1.png" alt="..." class="img-thumbnail">
      <div class="caption" align="right">
        <h4 align="center">Standard</h4>
    <form method="post">
<?php if($a==1){?>
      <span class="btn btn-sm btn-success btn-flat" >Dipakai</span>
<?php } else {?>
    <button type="submit" class="btn btn-sm btn-default btn-flat" name="pilih1" ><span class="glyphicon glyphicon-check"></span> Pilih</button>
<?php } ?>

    </form>
    </div>
    </div>
  </div>

                <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="dist/img/inv2.png" alt="..." class="img-thumbnail">
      <div class="caption" align="right">
        <h4 align="center">Berlogo</h4>
    <form method="post">
      <?php if($a==2){?>
      <span class="btn btn-sm btn-success btn-flat" >Dipakai</span>
<?php } else {?>
    <button type="submit" class="btn btn-sm btn-default btn-flat" name="pilih2"><span class="glyphicon glyphicon-check"></span> Pilih</button>
  <?php } ?>
    </form>
    </div>
    </div>
  </div>

                <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="dist/img/inv3.png" alt="..." class="img-thumbnail">
      <div class="caption" align="right">
        <h4 align="center">Simple</h4>
    <form method="post">
      <?php if($a==3){?>
      <span class="btn btn-sm btn-success btn-flat" >Dipakai</span>
<?php } else {?>
    <button type="submit" class="btn btn-sm btn-default btn-flat" name="pilih3"><span class="glyphicon glyphicon-check"></span> Pilih</button>
<?php } ?>

    </form>
    </div>
    </div>
  </div>

                    
            

              <?php } ?>
                </div>

    <?php  if($_SERVER["REQUEST_METHOD"] == "POST"){


        if(isset($_POST['pilih1'])){
          $pilih = '1';
           $sql="select * from backset";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update backset set tipenota='$pilih'";
             $result = mysqli_query($conn, $sql1);?>
             <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }else{
                mysqli_query($conn,"SET session sql_mode = ''");	$sql1 = "insert into backset (tipenota) values('$pilih')";
              $result = mysqli_query($conn, $sql1);?>
              <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }
          }

    if(isset($_POST['pilih2'])){
          $pilih = '2';
           $sql="select * from backset";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update backset set tipenota='$pilih'";
             $result = mysqli_query($conn, $sql1);?>
             <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php

        }else{
                mysqli_query($conn,"SET session sql_mode = ''");	$sql1 = "insert into backset (tipenota) values('$pilih')";
              $result = mysqli_query($conn, $sql1);?>
              <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }
          }

    if(isset($_POST['pilih3'])){
          $pilih = '3';
           $sql="select * from backset";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update backset set tipenota='$pilih'";
             $result = mysqli_query($conn, $sql1);?>
             <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php

        }else{
                mysqli_query($conn,"SET session sql_mode = ''");	$sql1 = "insert into backset (tipenota) values('$pilih')";
              $result = mysqli_query($conn, $sql1);?>
              <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }
          }


             if(isset($_POST['pilih4'])){
          $pilih = '4';
           $sql="select * from backset";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update backset set tipenota='$pilih'";
             $result = mysqli_query($conn, $sql1);?>
             <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php

        }else{
                mysqli_query($conn,"SET session sql_mode = ''");	$sql1 = "insert into backset (tipenota) values('$pilih')";
              $result = mysqli_query($conn, $sql1);?>
              <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }
          }


             if(isset($_POST['pilih5'])){
          $pilih = '5';
           $sql="select * from backset";
                  $result=mysqli_query($conn,$sql);

              if(mysqli_num_rows($result)>0){

           $sql1 = "update backset set tipenota='$pilih'";
             $result = mysqli_query($conn, $sql1);?>
             <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php

        }else{
                mysqli_query($conn,"SET session sql_mode = ''");	$sql1 = "insert into backset (tipenota) values('$pilih')";
              $result = mysqli_query($conn, $sql1);?>
              <?php echo "<script type='text/javascript'>window.location = '$forwardpage';</script>"; ?><?php
        }
          }

  
    }?>
                                <!-- /.box-body -->
                            </div>

            <!-- BATAS -->
                    </div>
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
