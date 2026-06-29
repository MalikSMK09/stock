<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";

;encryption();session();connect();head();body();timing();
//pagination();
?>
<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout.php" />
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
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );
$halaman = "index"; // halaman
$dataapa = "Dashboard"; // data
$tabeldatabase = "index"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

//$search = $_POST['search'];
// hak tampil dashboard

$jabatan = $_SESSION['jabatan'];
$sqlnya="SELECT * FROM chmenu where userjabatan = '$jabatan'";
$hasilnya= mysqli_query($conn,$sqlnya);
  if(mysqli_num_rows($hasilnya)>0){
    $rownya=mysqli_fetch_assoc($hasilnya);
    $hak=$rownya['menu1']; //user

  }


?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->
<div class="col-lg-12">
<ol class="breadcrumb ">
<li><a href="#">Dashboard </a></li><span class="badge bg-light-blue pull-right"> <?php echo $today;?> </span>
</ol>
</div>

<!-- BREADCRUMB -->




                                <!-- /.box-body -->

                        <!-- ./col -->

                </div>

<?php if($_SESSION['jabatan'] !='admin'){}else{ ?>

 <div class="row">
<?php

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$alert = $_GET['alert'];

$sql1="SELECT url FROM backset";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $url=$row['url'];
if ($alert == 1 && $url =='http://idwares.esy.es'){
?>


<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
                Url Aplikasi belum disesuaikan dengan url anda sekarang. Klik Tombol pengaturan dibawah untuk menyesuaikan dengan url dimana anda menggunakan aplikasi. <br>
                <button type="button" class="btn btn-success btn btn-xs" data-toggle="modal" data-target="#modal-default">
                Pengaturan
              </button>
              </div>

   <?php } else {?>            
                   

                         <div class="col-lg-3 col-xs-6">
                           <!-- small box -->
                           <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php echo $datax1; ?></h3>
                                   <p>Karyawan</p>
                               </div>
                               <div class="icon">
                                   <i class="ion ion-person"></i>
                               </div>
                                 <a href="admin" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                           </div>
                       </div>

                       <div class="col-lg-3 col-xs-6">
                         <!-- small box -->
                         <div class="small-box bg-green">
                             <div class="inner">
                                 <h3><?php echo $datax2; ?></h3>
                                 <p>Supplier</p>
                             </div>
                             <div class="icon">
                                 <i class="ion ion-person"></i>
                             </div>
                               <a href="supplier" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                         </div>
                     </div>

                     <div class="col-lg-3 col-xs-6">
                       <!-- small box -->
                       <div class="small-box bg-yellow">
                           <div class="inner">
                               <h3><?php echo $datax3; ?></h3>
                               <p>Barang</p>
                           </div>
                           <div class="icon">
                               <i class="glyphicon glyphicon-blackboard"></i>
                           </div>
                             <a href="barang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                       </div>
                   </div>

                   <div class="col-lg-3 col-xs-6">
                     <!-- small box -->
                     <div class="small-box bg-red">
                         <div class="inner">
                             <h3><?php echo $datax4; ?></h3>

                             <?php
                             $sql= "SELECT batas from backset";
                              $hasilx2=mysqli_query($conn,$sql);
                              $row=mysqli_fetch_assoc($hasilx2);
                              $alert = $row['batas'];

                             ?>
                             <p>Barang dengan Stok dibawah minimal</p>
                         </div>
                         <div class="icon">
                             <i class="glyphicon glyphicon-folder-close"></i>
                         </div>
                           <a href="stok_menipis" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>



                     </div>

<?php } } ?>


<?php
if ($_SESSION['jabatan'] != 'admin') {
  

 $sql="select * from info";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){

          $nama = $fill["nama"];
                  $avatar = $fill["avatar"];
                  $tanggal = $fill["tanggal"];
                  $isi= $fill["isi"];


    }
?>

<div class="row">
 <!-- Left col -->
        <section class="col-lg-12 connectedSortable">

          <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Berita Informasi <span class="badge bg-green">oleh  #<?php echo $nama;?></span> pada tanggal <?php echo $tanggal;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<?php echo $isi; ?>
            </div>
          </div>
        </div>


        </section>

      </div>
    <?php } ?>


<!-- Awal tabel  -->

<div class="row">
 <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          
          <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang dengan Stok paling banyak <span class="badge bg-green">dari  #<?php echo $stok1;?> di gudang</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                 
               <thead>
<?php
          $mySql  = "SELECT nama,sisa FROM barang ORDER BY sisa DESC LIMIT 5";
          $myQry  = mysqli_query($conn, $mySql)  or die ("Query  salah : ".mysqli_error());
          $nomor  = 0; 
          
            
          ?>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Barang</th>
                  <th>Stok</th>
                  <th style="width: 40px">Persentase</th>
                </tr>
                </thead>
         <?php       while ($kolomData = mysqli_fetch_array($myQry)) {
            $nomor++;  ?>
                <tbody>
                      <tr>
               <td><?php echo $nomor; ?></td>
              <td><?php echo $kolomData['nama']; ?></td>
              <td><?php echo $kolomData['sisa']; ?></td>
              <td><span class="badge bg-red"><?php echo round((($kolomData['sisa']/$stok1)*100),2); ?></span></td>
              
            </tr>
           </tbody>
           <?php } ?>
  

                 
              </table>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

         <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang Keluar Terbanyak <span class="badge bg-red">dari  #<?php echo $stok2;?> keluar</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                 
               <thead>
<?php
          $mySql  = "SELECT nama,terjual FROM barang ORDER BY terjual DESC LIMIT 5";
          $myQry  = mysqli_query($conn, $mySql)  or die ("Query  salah : ".mysqli_error());
          $nomor  = 0; 
          
            
          ?>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Barang</th>
                  <th>Terjual</th>
                  <th style="width: 40px">Persentase</th>
                </tr>
                </thead>
         <?php       while ($kolomData = mysqli_fetch_array($myQry)) {
            $nomor++;  ?>
                <tbody>
                      <tr>
               <td><?php echo $nomor; ?></td>
              <td><?php echo $kolomData['nama']; ?></td>
              <td><?php echo $kolomData['terjual']; ?></td>
              <td><span class="badge bg-light-blue"><?php echo round((($kolomData['terjual']/$stok2)*100),2); ?></span></td>
              
            </tr>
           </tbody>
           <?php } ?>
  

                 
              </table>

              

            </div>
            <!-- /.box-body -->
           
          <!-- /.box -->
          <!-- /.box -->

        </section>
        <!-- right col -->


     
</div>



<!-- akhir tabel -->
<?php
if ($_SESSION['jabatan'] == 'admin' || $hak >='1') {?>
<!-- Awal Chart  -->

<div class="row">
 <!-- Left col -->
         <section class="col-lg-6 connectedSortable">
          
          <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Hutang dan Piutang (Rp) </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table no-border">
                 
               <thead>

                <tr>
                  <th ></th>
                  <th>Hutang</th>
                  <th></th>
                  <th >Piutang</th>
                </tr>
                </thead>
        
                <tbody>
                      <tr>
               <td>Sudah Jatuh Tempo</td>
              <td><h4><?php echo number_format($buynow);?></h4></td>
              <td>Segera Jatuh Tempo</td>
              <td><h4><?php echo number_format($salenow);?></h4></td>
            </tr>

              <tr>
               <td>Jatuh Tempo <30 hari</td>
              <td><h4><?php echo number_format($buy30);?></h4></td>
              <td>Jatuh Tempo <30 hari</td>
              <td><h4><?php echo number_format($sale30);?></h4></td>              
            </tr>

            <tr>
               <td>Jatuh Tempo 30-60 hari</td>
              <td><h4><?php echo number_format($buy3060);?></h4></td>
              <td>Jatuh Tempo 30-60 hari</td>
              <td><h4><?php echo number_format($sale3060);?></h4></td>              
            </tr>

             <tr>
               <td>Jatuh Tempo 60-90 hari</td>
              <td><h4><?php echo number_format($buy6090);?></h4></td>
              <td>Jatuh Tempo 60-90 hari</td>
              <td><h4><?php echo number_format($sale6090);?></h4></td>              
            </tr>

             <tr>
               <td>Jatuh Tempo >90 hari</td>
              <td><h4><?php echo number_format($buy90);?></h4></td>
              <td>Jatuh Tempo >90 hari</td>
              <td><h4><?php echo number_format($sale90);?></h4></td>              
            </tr>



           </tbody>
         
  

                 
              </table>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        
        <!-- right col -->
<section class="col-lg-6 connectedSortable">
          
          <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Ringkasan (Rp) </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table no-border">
                 
               <thead>

                <tr>
                  <th ></th>
                  <th>Bulan ini</th>
                  <th>Bulan lalu</th>
                  <th >Tahun ini</th>
                </tr>
                </thead>
        
                <tbody>
                      <tr>
               <td>Pendapatan Retail</td>
              <td><h4><?php echo number_format($rebulan);?></h4></td>
              <td><h4><?php echo number_format($rebulanlalu);?></h4></td>
              <td><h4><?php echo number_format($retahun);?></h4></td>
            </tr>

              <tr>
               <td>Pendapatan Non Retail</td>
              <td><h4><?php echo number_format($salemonth);?></td>
              <td><h4><?php echo number_format($salelastmonth);?></td>
              <td><h4><?php echo number_format($saleyear);?></h4></td>              
            </tr>

            
             <tr>
               <td>Biaya Operasional</td>
              <td><h4><?php echo number_format($opmonth);?></td>
              <td><h4><?php echo number_format($oplastm);?></td>
              <td><h4><?php echo number_format($opyear);?></td>              
            </tr>


             <tr>
               <td>Net Income</td>
              <td><h4><?php echo number_format($sum1);?></td>
              <td><h4><?php echo number_format($sum2);?></td>
              <td><h4><?php echo number_format($sum3);?></td>              
            </tr>

             



           </tbody>
         
  

                 
              </table>
            </div>
            <!-- /.box-body -->
            
          </div>
          <!-- /.box -->
          <!-- /.box -->

        </section>
     
</div>


<div class="row">
 <!-- Left col -->
        <section class="col-lg-6 connectedSortable">

<div class="box box-solid box-success">



       
 <?php          $rtm       = mysqli_query($conn, "SELECT SUM(total) as retail FROM bayar"); 
                $r = mysqli_fetch_assoc($rtm) ?>

 <?php          $inv       = mysqli_query($conn, "SELECT SUM(total) as total FROM sale where status LIKE '%dibayar' "); 
                $i = mysqli_fetch_assoc($inv) ?>
 <?php          $blm       = mysqli_query($conn, "SELECT SUM(total) as receive FROM sale where status LIKE '%belum' "); 
                $b = mysqli_fetch_assoc($blm)
                 ?>
         
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
        <style type="text/css">
            
        </style>
        <script src="/libs/chart.bundle.js"></script>
        <style type="text/css">
            
        </style>
    
          
        <div class="chart-container">
            <canvas  class="my-4 chartjs-render-monitor" id="myChart1" width="443" height="229" style="display: block; width: 443px; height: 229px;"></canvas>
            <center><h2>Pendapatan Retail Vs Invoice</h2></center>
        </div>
        <script>
            var ctx = document.getElementById("myChart1");
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['penjualan retail','Invoice','Belum dibayar'],
                    datasets: [{
                            label: '# dalam rupiah',
                            data: [<?php echo $r['retail'];?>,<?php echo $i['total'];?>,<?php echo $b['receive'];?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>


</div>
          </section>



           <section class="col-lg-6 connectedSortable">

<div class="box box-solid box-success">





       
 <?php          $akun       = mysqli_query($conn, "SELECT tipe,SUM(biaya) as cosi FROM operasional GROUP BY tipe ORDER BY cosi asc");  ?>

 <?php          $biaya       = mysqli_query($conn, "SELECT tipe,SUM(biaya) as cost FROM operasional GROUP BY tipe ORDER BY cost asc");  ?>
         
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
        <style type="text/css">
            
        </style>
        <script src="/libs/chart.bundle.js"></script>
        <style type="text/css">
            
        </style>
    
          
        <div class="chart-container">
            <canvas  class="my-4 chartjs-render-monitor" id="myChart2" width="443" height="229" style="display: block; width: 443px; height: 229px;"></canvas>
            <center><h2>Pengeluaran</h2></center>
        </div>
        <script>
            var ctx = document.getElementById("myChart2");
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [<?php while ($b = mysqli_fetch_array($akun)) { echo '"' . $b['tipe'] . '",';}?>],
                    datasets: [{
                            label: '# dalam rupiah',
                            data: [<?php while ($b = mysqli_fetch_array($biaya)) { echo '"' . $b['cost'] . '",';}?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>



</div>
          </section>

        </div>

<!-- akhir chart -->

<?php } ?>

<!-- awal tabel -->
<div class="row">
 <!-- Left col -->
        <section class="col-lg-12 connectedSortable">


          </section>


        </div>


        <!-- akhir tabel -->
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








             <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Url Aplikasi</h4>
              </div>

                <form method="post" >
              <div class="modal-body">
                <p> Url Aplikasi adalah alamat domain website/subdomain atau bisa berupa folder di localhost yang anda ketika pada address bar browser anda untuk mengakses aplikasi. Saat ini Url aplikasi seperti digambar, anda perlu menggantinya dengan milik anda sendiri.  <img src="dist/img/url.png"></p>
                <p>Anda wajib ganti URL Aplikasi agar bisa berjalan dengan baik</p>

                

                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Url Aplikasi Baru</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" name="url" placeholder="idwares.esy.es">
                  </div>
                </div>

              </div>


              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="save" class="btn btn-primary">Save changes</button>
              </div>
            </div>

          </form>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
 <?php


if(isset($_POST['save'])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

         $url = mysqli_real_escape_string($conn, $_POST['url']);

         $sqlu = "UPDATE backset SET url='$url' ";
         $query = mysqli_query($conn, $sqlu);


         if($query){
           echo "<script type='text/javascript'>  alert('Berhasil, Url Aplikasi telah diubah!'); </script>";
             echo "<script type='text/javascript'>window.location = 'index';</script>";
         }

       } }

        ?>


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
