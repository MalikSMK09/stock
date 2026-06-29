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
$halaman = "retur"; // halaman
$dataapa = "Retur Barang"; // data
$tabeldatabase = "dataretur"; // tabel database
$chmod = $chmenu2; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

$nota = $_GET['nota'];
 
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
if(isset($_POST["retur"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

            $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $harga = mysqli_real_escape_string($conn, $_POST["harga"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
               $retur = mysqli_real_escape_string($conn, $_POST["return"]);
                $no = mysqli_real_escape_string($conn, $_POST["no"]);
                $terjual = mysqli_real_escape_string($conn, $_POST["sold"]);
                $awal = mysqli_real_escape_string($conn, $_POST["brg"]);

                $sisa = $jumlah - $retur;
                $hargaakhir = $sisa * $harga;
                $hargabeliakhir = $sisa * $hargabeli;
                $hasile = $awal + $retur;
                $sold=$terjual-$retur;

                $dana = $retur * $harga;

                $today=date('Y-m-d');


                $kasir = $_SESSION["username"];
              $kegiatan = "retur penjualan";
              $status = "pending";
              $jam=date('h:i');

                 $sql="select * from $tabeldatabase where nota='$nota' and kode='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Barang sudah diretur, setiap barang hanya bisa diretur sekali!');</script>";
              } else if($retur <= $jumlah) {

                          
             
            
            

            if($hasile >= '0'){
               mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabeldatabase values( '$nota','$kode','$nama','$retur',$harga,'$dana','')";
               $insertan = mysqli_query($conn, $sql2);

              

               $sql5 = "UPDATE transaksimasuk SET jumlah='$sisa',hargaakhir='$hargaakhir',hargabeliakhir='$hargabeliakhir',retur='YES' where no='$no' ";
               $updatetrx = mysqli_query($conn, $sql5);

                mysqli_query($conn,"SET session sql_mode = ''");	$sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$jam','$kode','$sisa','$retur','$kegiatan','$nota','','$status')";
               $mutasi = mysqli_query($conn, $sql4);

               $sql5 = "UPDATE barang SET terjual='$sold', retur='$hasile' where kode='$kode' ";
               $updatertr = mysqli_query($conn, $sql5);
                if($updatertr){

               echo "<script type='text/javascript'>  alert('Berhasil, Produk telah berhasil ditambahkan ke daftar retur!');</script>";
               echo "<script type='text/javascript'>window.location = 'retur_jual?nota=$nota';</script>";
             } else {
              echo "<script type='text/javascript'>  alert('GAGAL, tidak berhasil update stok!');</script>";
               echo "<script type='text/javascript'>window.location = 'retur_jual?nota=$nota';</script>";
             }


             }else{
                echo "<script type='text/javascript'>  alert('Gagal, Hasil retur kurang dari 0 !');</script>";
              }








              } else { echo "<script type='text/javascript'>  alert('Jumlah Barang diretur tidak boleh lebih dari jumlah dijual!$retur');</script>"; }


       } }

?>



<?php 
if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
 $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
 $data = mysqli_real_escape_string($conn, $_POST["datatotal"]);
  $today=date('Y-m-d');
  $kasir = $_SESSION["username"];
  $status ="Retur";
  $berhasil = "berhasil";

    $sql="select * from retur where nota='$nota'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Nota dengan nomor yang sama sudah pernah diretur!');</script>";
              } else if ($data>0){

                mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into retur values( '$nota','$today','$data','$status','$kasir','')";
               $insertan = mysqli_query($conn, $sql2);

               $cektrx=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM bayar WHERE nota='$nota'"));
               $oldgrand=$cektrx['total'];

               $newgrand=$cektrx['total']- $data ;

               $newkembali=$cektrx['bayar']-$newgrand;

               $sql2a =mysqli_query($conn,"UPDATE bayar SET total='$newgrand',kembali='$newkembali', keterangan='Retur' WHERE nota='$nota'");

               //update mutasi
               $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$nota' AND kegiatan LIKE 'retur penjualan' ";
               $updatemutasi = mysqli_query($conn, $sql3);

               if(($insertan)&&($updatemutasi)){
                echo "<script type='text/javascript'>  alert('Data Retur telah disimpan, Barang yang diretur telah dimasukan ke gudang retur!');</script>";
                echo "<script type='text/javascript'>window.location = 'retur_jual?nota=$nota';</script>";
               }

              } else{
                 echo "<script type='text/javascript'>  alert('Belum ada barang yang diretur untuk nota ini!');</script>";
              }

       }}

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
      <?php

        $sql1="SELECT * FROM bayar where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
          $tglbayar = date("d-m-Y",strtotime($row['tglbayar'])); 
        
        $bayar=$row['bayar'];
        $total=$row['total'];
        $kembali=$row['kembali'];
        $kasir=$row['kasir'];
        $diskon=$row['diskon'];
        $subtotal= $total + $diskon;
        $tipe =$row['tipebayar'];


        $sql1="SELECT * FROM retur where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $tgl=$row['tanggal'];
        $stts=$row['status'];
        $petu=$row['petugas'];
      ?>


 <div class="row">

                  <div class="col-md-9">
                    <div class="box box-info">
                      <div class="box-body">

                         <!-- Default box -->
                          <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th >Nota</th>
                  <th>Subtotal</th>
                  <th>Diskon</th>
                  <th >Total</th>
                  <th >Bayar</th>
                  <th >Kembali</th>
                </tr>
                <tr>
                  <td><?php echo $nota;?></td>
                  <td>Rp <?php echo number_format($subtotal, $decimal, $a_decimal, $thousand).',-'; ?></td>
                  <td>
                   Rp <?php echo number_format($diskon, $decimal, $a_decimal, $thousand).',-'; ?>
                  </td>
                  <td>Rp <?php echo number_format($total, $decimal, $a_decimal, $thousand).',-'; ?></td>
                   <td>Rp 
                    <?php echo number_format($bayar, $decimal, $a_decimal, $thousand).',-'; ?>
                  </td>
                   <td>Rp 
                   <?php echo number_format($kembali, $decimal, $a_decimal, $thousand).',-'; ?>
                  </td>
                </tr>


                <tr>
                  <th >Tgl Trx</th>
                  <th>Total Qty</th>
                  <th>Tipe Bayar</th>
                  <th >Kasir</th>
                  <th >Status Retur</th>
                  <th >Penerima retur</th>
                </tr>
                
                <tr>
                  <td>  <?php echo $tglbayar;?></td>
                  <td><?php $sql1="SELECT SUM(jumlah) as data FROM transaksimasuk where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];
        echo $totalqty;?></td>
                  <td>
                     <?php echo $tipe;?>
                  </td>
                  <td>  <?php echo $kasir;?></td>
                  <td>  <?php echo $stts;?>/<?php echo $tgl;?></td>
                  <td>  <?php echo $petu;?></td>
                </tr>

                 <tr>
                  
                  
                </tr>
              </table>
              <span class="badge bg-red"><strong >Setiap Jenis Barang hanya dapat diretur satu kali, pastikan jumlah retur sudah benar sebelum klik tombol retur</strong></span>
            </div>
      
        </div>
    </div>

                                <!-- /.box-body -->
                            </div>
                      








                  <div class="col-md-3">
                    <div class="box box-danger">
                      <div class="box-body">

                        <?php 
                         $sqle="SELECT SUM(hargaakhir) as data FROM dataretur WHERE nota='$nota'";
                         $hasile=mysqli_query($conn,$sqle);
                          $row=mysqli_fetch_assoc($hasile);
                          $datatotal=$row['data'];

                          if($datatotal>$total){
                            $datatotal=$total;}
                        ?>

                         <!-- Default box -->
                         
                         <h1 align="center">Rp   <?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?></h1>
                        
      
        </div>
        <p align="center">Total Uang diretur</p>
    </div>

                                <!-- /.box-body -->
                            </div>
                        </div>




                        <div class="row">

                  <div class="col-md-12">
                    <div class="box box-warning">
                      <div class="box-body">

                         <!-- Default box -->

                         <?php
           error_reporting(E_ALL ^ E_DEPRECATED);
           $halaman = "retur_fetch"; // halaman
           

           $sql    = "select * from transaksimasuk where nota ='$nota' order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 30;
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

                          <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama Barang</th>
                  <th>Qty</th>
                  <th >Harga Satuan</th>
                  <th >Dana Retur</th>
                  <th >Jumlah Retur</th>
                  <th >Stok retur di gudang</th>
                  <th >Opsi</th>
                </tr>


             <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>

                <tr>
                   <td><?php echo ++$no_urut;?></td>
                  <td><?php echo $fill['nama'];?></td>
                  <td>
                   <?php echo $fill['jumlah'];?>
                  </td>
                  <td><?php echo $fill['harga'];?></td>
                  <td><?php echo $fill['harga'];?></td>

                    <form action="retur_jual" method="post">

                  <td>  <?php  $kode=$fill['kode'];
                  $sqly    = "select * from dataretur where nota ='$nota' and kode='$kode' order by no";
                  $query = mysqli_query($conn, $sqly);
                  $assoc = mysqli_fetch_assoc($query);
                  $qtyrtr = $assoc['jumlah'];

                  if($fill['retur']=="YES"){ echo $qtyrtr?>
                  <?php } else { ?>


                    <input type="text" value="<?php echo $fill['jumlah'];?>" name="return">
                  <?php } ?>


                    <input type="hidden" value="<?php echo $nota;?>" name="nota">
                    <input type="hidden" value="<?php echo $fill['kode'];?>" name="kode">
                    <input type="hidden" value="<?php echo $fill['jumlah'];?>" name="jumlah">
                  
                    <input type="hidden" value="<?php echo $fill['harga'];?>" name="harga">
                    <input type="hidden" value="<?php echo $fill['hargabeli'];?>" name="hargabeli">
                    <input type="hidden" value="<?php echo $fill['nama'];?>" name="nama">
                    <input type="hidden" value="<?php echo $fill['no'];?>" name="no">
                  </td>

                  <td style="width:10%">
                     <?php  
                    $sqle3="SELECT * FROM barang where kode='$kode'";
            $hasile3=mysqli_query($conn,$sqle3);
            $row=mysqli_fetch_assoc($hasile3);
            $awal=$row['retur'];
            ?>
                      <input type="hidden" value="<?php echo $awal;?>" name="brg">
                         <input type="hidden" value="<?php echo $row['terjual'];?>" name="sold">
                      <?php echo $awal;?>

                  </td>
                   


                

                   <td><?php if($fill['retur']=="YES"){?><p>Telah diretur</p><?php } else {?>


                    <input type="submit" value="Terima Retur" name="retur" class="btn btn-danger btn-small"> <?php } ?></td>
                    </form>


                </tr>
               
<?php
           $i++;
           $count++;
           }

           ?>


              </table>
               <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>
            </div>

<?php 
if ($stts !="Retur"){

?>


            <form action="retur_jual" method="post">
            <tr>
              <input type="hidden" value="<?php echo $datatotal;?>" name="datatotal" >
              <input type="hidden" value="<?php echo $nota;?>" name="nota" >
            <button type="submit" class="btn btn-success btn-flat" name="simpan">Simpan</button>
           </tr>
         </form>
<?php } else{} ?>



      
        </div>
    </div>

<?php if ($stts !="Retur"){} else {?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h5>Perhatian!</h5>
Stok yang diretur tidak langsung dikembalikan ke stok barang, tapi ditampung dulu pada stok retur. Gunakan menu Stok->Stok Barang Retur untuk mengembalikan ke stok barang
</div>

<?php } ?>

                                <!-- /.box-body -->
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
