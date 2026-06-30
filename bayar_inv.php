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
$halaman = "bayar_inv"; // halaman
$dataapa = "Penjualan"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu2; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM sale ORDER BY no";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%06s", $sort_num);
  return $new_code;
 }
$pp=mysqli_fetch_assoc(mysqli_query($conn,"select pajakppn from data"));
$defppn=$pp['pajakppn'];


 $nota=autoNumber();

?>


<!-- SETTING STOP -->
 <?php


   $decimal ="0";
        $a_decimal =",";
        $thousand =".";

    if($nota == null || $nota == ""){

            $datatotal = SecurityBootstrap::sumCartByNota($conn, 'invoicejual', $nota, 'harga*jumlah');
            $databelitotal = SecurityBootstrap::sumCartByNota($conn, 'invoicejual', $nota, 'hargabeli*jumlah');
    }else{

      $datatotal = SecurityBootstrap::sumCartByNota($conn, 'invoicejual', $nota, 'harga*jumlah');
      $databelitotal = SecurityBootstrap::sumCartByNota($conn, 'invoicejual', $nota, 'hargabeli*jumlah');


    }

    ?>

<!-- BREADCRUMB -->
<?php 
if(isset($_POST['persendis'])){
    $_SESSION['perdis'.$nota]=$_POST['persendis'];
}

if(!isset($_SESSION['perdis'.$nota])){
$_SESSION['perdis'.$nota]=0;

}

if(isset($_POST['nomdis'])){
    $_SESSION['nomdis'.$nota]=$_POST['nomdis'];
}

if(!isset($_SESSION['nomdis'.$nota])){
$_SESSION['nomdis'.$nota]=0;
}


if(isset($_POST['pajak'])){
    $_SESSION['pajak'.$nota]=$_POST['pajak'];
} else {
    $_SESSION['pajak'.$nota]=$defppn;
}


if(!isset($_SESSION['pajak'.$nota])){
$_SESSION['pajak'.$nota]=0;
}


if(isset($_POST['biaya'])){
    $_SESSION['biaya'.$nota]=$_POST['biaya'];
}

if(!isset($_SESSION['biaya'.$nota])){
$_SESSION['biaya'.$nota]=0;
}

if(isset($_POST['bnama'])){
    $_SESSION['bnama'.$nota]=$_POST['bnama'];
}

if(!isset($_SESSION['bnama'.$nota])){
$_SESSION['bnama'.$nota]=0;
}

//menyimpan ke tabel bayar

   

    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
           SecurityBootstrap::requireCsrf();

            $pelanggan = SecurityBootstrap::paramStr($_POST["pelanggan"] ?? '', 64);
            
            if($pelanggan == ''){ 
                 echo "<script type='text/javascript'>  alert('Gagal, Pelanggan belum dipilih! Pilih pelanggan atau tambah dari menu pelanggan'); </script>";
            } else { 

              $notaPost = SecurityBootstrap::secureNota($_POST["nota"] ?? '');
              $nomor = SecurityBootstrap::paramStr($_POST["nomor"] ?? '', 64);
              $duedate = SecurityBootstrap::optionalDate($_POST["duedate"] ?? '');
              $sub = SecurityBootstrap::paramFloat($_POST["subtotal"] ?? 0);
              $total = SecurityBootstrap::paramFloat($_POST["total"] ?? 0);
              $tglnota = SecurityBootstrap::optionalDate($_POST["tglnota"] ?? date('Y-m-d'));
              $databelitotal = SecurityBootstrap::paramFloat($_POST["beli"] ?? 0);
              $diskon = $_SESSION['nomdis'.$nota] ?? 0;
              $perdis = $_SESSION['perdis'.$nota] ?? 0;
              $ppn = $_SESSION['pajak'.$nota] ?? 0;
              $bnama = $_SESSION['bnama'.$nota] ?? 0;
              $biaya = $_SESSION['biaya'.$nota] ?? 0;
              $nomtax = SecurityBootstrap::paramFloat($_POST["nomtax"] ?? 0);
              $keterangan = SecurityBootstrap::paramStr($_POST["keterangan"] ?? '', 255);
              $kasir = $_SESSION["username"] ?? '';
              $status = "belum";

                  if(SecurityBootstrap::saleExists($conn, $notaPost)){
                    echo "<script type='text/javascript'>  alert('Data penjualan yang sudah ada tidak bisa diubah!');</script>";
              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){

               if(SecurityBootstrap::insertSaleInvoice($conn, [
                   'nota' => $notaPost, 'nomor' => $nomor, 'tglnota' => $tglnota, 'duedate' => $duedate,
                   'sub' => $sub, 'perdis' => $perdis, 'diskon' => $diskon, 'ppn' => $ppn,
                   'nomtax' => $nomtax, 'bnama' => $bnama, 'biaya' => $biaya, 'total' => $total,
                   'databelitotal' => $databelitotal, 'pelanggan' => $pelanggan, 'kasir' => $kasir,
                   'keterangan' => $keterangan, 'status' => $status,
               ])){

                SecurityBootstrap::recordSaleMutations($conn, $notaPost, $kasir);

                   unset($_SESSION['perdis'.$nota]);
                 unset($_SESSION['nomdis'.$nota]);
                  unset($_SESSION['pajak'.$nota]);
                  unset($_SESSION['bnama'.$nota]);
                  unset($_SESSION['biaya'.$nota]);

                  echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
               echo "<script type='text/javascript'>window.location = 'penjualan';</script>";

           } else {
            echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!Terjadi kesalahan, hubungi admin');</script>";
           }
             }else{
              echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan pembayaran benar');</script>";
             }
 }
      }

    }


$perdis= $_SESSION['perdis'.$nota];
$nomdis= $_SESSION['nomdis'.$nota];
$ppn= $_SESSION['pajak'.$nota];
$bnama= $_SESSION['bnama'.$nota];
$biaya= $_SESSION['biaya'.$nota];


if($perdis >0 || $nomdis >0){} else {
$display1="style='display:none;'";
}

if($ppn >0){ } else { 
    $display2="style='display:none;'";
}

if($biaya >0){ } else { 
    $display3="style='display:none;'";
}

if($perdis >0 || $nomdis >0 || $ppn >0 || $biaya >0){} else {
$display4="style='display:none;'";
}



$afterdis=$datatotal-ROUND($nomdis);
$tax=ROUND($ppn/100*$afterdis);

$aftertax=$afterdis+$tax+$biaya;





?>

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
                         <div class="col-lg-12">
      <div class="main box">
   <div class="box-header with-border">
             <div class="margin">
         <a data-toggle="modal" data-target="#modaldiskon" class="btn bg-blue">Diskon</a>
          <a data-toggle="modal" data-target="#modalpajak" class="btn bg-maroon">PPN</a>  
           <a data-toggle="modal" data-target="#modalbiaya" class="btn bg-purple">Biaya</a>
            <a data-toggle="modal" data-target="#modalsales" class="btn bg-navy">Salesman</a>             
   
     </div>

          <div class="box-tools pull-right col-xs-5">
          <input class="form-control input-lg" value="<?php echo number_format($aftertax, $decimal, $a_decimal, $thousand);?>" style="background-color: yellow;font-size: 24px;font-weight:bold;" readonly>
          </div>
        </div>
        
       

<div class="row">


        <div class="box-body col-lg-7">
         

            <!--tabel-->

<div class="box-body no-padding">
     <?php
     
           error_reporting(E_ALL ^ E_DEPRECATED);

           $invoiceRows = SecurityBootstrap::queryAll($conn, 'SELECT * FROM invoicejual WHERE nota = ? ORDER BY no', 's', [$nota]);
           $rpp    = 15;
           $reload = "$halaman"."?pagination=true";
           $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);



           if ($page <= 0)
           $page = 1;
           $tcount  = count($invoiceRows);
           $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
           $count   = 0;
           $i       = ($page - 1) * $rpp;
           $no_urut = ($page - 1) * $rpp;
           ?>
              <table class="table table-condensed">
               <thead>
                      <tr>
                          <th>No</th>
                          <th style="width: 55%">Nama Barang</th>
                          
                          <th>Jumlah Jual</th>
                          <th>Total</th>
           
                      </tr>
                  </thead>

                  <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           $fill = $invoiceRows[$i];
           ?>
            <tbody>
           <tr>
           <td><?php echo ++$no_urut;?></td>
           
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
           
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x <?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
          </tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody>


              </table>
            </div>
            <!--end tabel-->


        </div>

         <div class="box-body">
            <div class="col-lg-4">
                                        <script>
                                   function sum1() {
                                         var txtFirstNumberValue =  document.getElementById('subtotal').value
                                         var txtSecondNumberValue = document.getElementById('diskon').value;
                                         var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('total').value = result;
                                            
                                         }
                                       if (!$(bayar).val()){
                                         document.getElementById('total').value = "0";
                                       }
                                       if (!$(total).val()){
                                         document.getElementById('total').value = "0";
                                       }
                                   }
                                   </script>

                                   
                <!-- /.box-header -->
            <div class="box-body no-padding">
<form  method="post" id="Myform" class="form-user">
<?php echo SecurityBootstrap::csrfField(); ?>

              <table class="table table-striped">
                <tr>


                  
                  <th>Sub total</th>
                  <input type="hidden" value="<?php echo $nota;?>" class="form-control" name="nota">
                  <input type="hidden" value="<?php echo $datatotal;?>" class="form-control" id="subtotal" name="subtotal">
                  <input type="hidden" value="<?php echo $databelitotal;?>" class="form-control" name="beli">
                  
                  
                  <th ><input type="text" value="<?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?>" class="form-control" readonly></th>
                </tr>
                <tr <?php echo $display1;?>>               
                 
                  <td>Diskon(<?php echo $perdis;?>%)</td>
                 
                  <td><input type="text" class="form-control" autocomplete="off" value="<?php echo number_format($nomdis, $decimal, $a_decimal, $thousand);?>" readonly></td>
                </tr>
                 

                       <tr <?php echo $display2;?>>               
                 
                  <td>PPN(<?php echo $ppn;?>%)</td>
                 
                  <td><input type="text" class="form-control" autocomplete="off" value="<?php echo number_format($tax, $decimal, $a_decimal, $thousand);?>" readonly>
                    <input type="hidden" class="form-control" autocomplete="off" value="<?php echo $tax;?>" name="nomtax" readonly></td>
                </tr>
                 


             <tr <?php echo $display3;?>>
                 
                  <td><?php echo $bnama;?></td>
                 
                   <td><input type="text" class="form-control" value="<?php echo number_format($biaya, $decimal, $a_decimal, $thousand);?>" autocomplete="off" readonly></td>
                </tr>


                <tr <?php echo $display4;?>>
                    
                                      
                  <td >Total</td>
                 
                  <td><input type="text" class="form-control" style="background-color: #FDFD96" value="<?php echo number_format($aftertax, $decimal, $a_decimal, $thousand); ?>" readonly>
                    <input type="hidden" class="form-control" name='total' value="<?php echo $aftertax; ?>" readonly>
                  
                  </td>
                </tr>
                <tr>
                  
                  <td>Tanggal Transaksi</td>
                  
                  <td><input type="text" class="form-control" id="datepicker2" name="tglnota"></td>

                </tr>

                 </tr>
                <tr>
                  
                  <td>Nomor Invoice</td>
                  
                  <td><input type="text" class="form-control" value="INV<?php echo $nota;?>" name="nomor"></td>

                </tr>
                <tr>
                  
                  <td>Jatuh Tempo</td>
                  
                  <td><input type="text" class="form-control" id="datepicker" name="duedate"></td>

                </tr>

               

                <tr>
                  
                  <td>Pelanggan</td>
                  
                  <td><select style="width:100%" name="pelanggan" class="select2">
                      <option ></option>
                      <?php
                                    $sql=mysqli_query($conn,"select * from pelanggan where status='pelanggan'");
                                    while ($row=mysqli_fetch_assoc($sql)){
                                      if ($pelanggan==$row['kode'])
                                      echo "<option value='".$row['kode']."' selected='selected'>".$row['kode']." | ".$row['nama']."</option>";
                                      else
                                      echo "<option value='".$row['kode']."'>".$row['kode']." | ".$row['nama']."</option>";
                                    }
                                  ?>
                    </select></td>
                </tr>
                <tr>

                 <tr>
                  
                  <td>Keterangan</td>
                  
                  <td><textarea name="keterangan" style="width:100%"></textarea> </td>

                </tr>

                



                 <tr>
                  
                  <td > <input type="button" class="btn btn-block pull-left btn-flat btn-danger"  onclick="window.open('add_sale','_self')" value="KEMBALI" /> </td>
                  <td ><button type="submit" class="btn btn-block pull-left btn-flat btn-success" name="simpan" onclick=" document.getElementById('Myform').submit();" >SIMPAN</button></td>
                  
                  

                </tr>
              </table>
          </form>
            </div>
            <!-- /.box-body -->
            </div>
         

           


        </div>

</div>
                                <!-- /.box-body -->
                            </div>
                       

                       </div>

 

           <!-- Modal diskon -->
<div id="modaldiskon" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Atur Diskon</h4>
      </div>
       <form method="post" >
      <div class="modal-body">

           <div class="row">
                <div class="col-lg-12">
                      <label>Total Sebelum Diskon</label>
                  <div class="input-group">
                       <span class="input-group-addon">Rp</span>
                    <input type="number" class="form-control" id="totalbeforedis" value="<?php echo $datatotal;?>" style="text-align: left;" readonly>

                  </div>
                  <!-- /input-group -->
                </div>
                      </div>
              <!-- /.row -->


                                                 <script>
                                               function persendisal() {
                                                     var total =  document.getElementById('totalbeforedis').value
                                                     var persen = document.getElementById('persendis').value;
                                                  
                                                     var result = parseFloat(total) * (parseFloat(persen)/100);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('nomdis').value = result;
                                                     }
                                                   if (!$(persen).val(0)){
                                                     document.getElementById('nomdis').value = "0";
                                                   }
                                               }
                                               </script>


                                                  <script>
                                               function nomdisal() {
                                                     var total =  document.getElementById('totalbeforedis').value
                                                     var nom = document.getElementById('nomdis').value;
                                                  
                                                     var calc = parseFloat(nom) / parseFloat(total);
                                                     var result = parseFloat(calc) * 100;
                                                     var result = result.toFixed(0);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('persendis').value = result;
                                                     }
                                                   if (!$(nom).val(0)){
                                                     document.getElementById('persendis').value = "0";
                                                   }
                                               }
                                               </script>

      
           <div class="row">
                <div class="col-lg-6">
                      <label>% Diskon</label>
                  <div class="input-group">
                       <span class="input-group-addon">%</span>
                    <input type="text" class="form-control" id="persendis" name="persendis" style="text-align: left;" onkeyup="persendisal();" maxlength="2" value="<?php echo $perdis;?>">
                     <input type="hidden" value="<?php echo $nota;?>" class="form-control" name="nota">

                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                      <label>Nominal Diskon</label>
                  <div class="input-group">
                       <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="nomdis" name="nomdis" style="text-align: left;" onkeyup="nomdisal();" value="<?php echo $nomdis;?>">
                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
              </div>
              <!-- /.row -->

      </div>

      <div class="modal-footer">
      
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>

         <button type="submit" name="aturdiskon" class="btn bg-blue">Terapkan</button>

      </div>
    </div>
 </form>
  </div>
</div>
<!-- end modal diskon-->





           <!-- Modal pajak-->
<div id="modalpajak" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Atur PPN</h4>
      </div>
       <form method="post" >
      <div class="modal-body">
      
              
                      
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">PPN</label>

                  <div class="col-sm-10">
                    <div class="input-group">
                       <span class="input-group-addon">%</span>
                    <input type="text" class="form-control" id="ppn" name="pajak" placeholder="% Pajak PPN" maxlength="2" value="<?php echo $ppn;?>" style="text-align: left;">
                </div>
                  </div>




                </div>
<br>


      </div>

      <div class="modal-footer">
      
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
         <button type="submit" name="aturdiskon" class="btn bg-blue">Terapkan</button>

      </div>
    </div>
 </form>
  </div>
</div>
<!-- end modal pajak-->




         <!-- Modal Biaya -->
           <form method="post" >
<div id="modalbiaya" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Biaya Tambahan</h4>
      </div>
     
      <div class="modal-body">
      

                                   <div class="row">
                <div class="col-lg-6">
                      <label>Nama Biaya</label>
                  <div class="input-group">
                       <span ></span>
                    <input type="text" class="form-control" name="bnama" value="Biaya Extra">

                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                      <label>Nominal Biaya</label>
                  <div class="input-group">
                       <span class="input-group-addon">Rp</span>
                    <input type="number" class="form-control" name="biaya" value="0">
                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
              </div>
              <!-- /.row -->

      </div>

      <div class="modal-footer">
      
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
         <button type="submit" name="aturdiskon" class="btn bg-blue">Terapkan</button>

      </div>
    </div>
 
  </div>
</div>
</form>
<!-- end modal biaya-->




   <!-- Modal Sales -->
           <form method="post" >
<div id="modalsales" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Komisi Sales</h4>
      </div>
     
      <div class="modal-body">
      

                                   <div class="row">
                <div class="col-lg-6">
                      <label>Sekian % dari Total</label>
                  <div class="input-group">
                       <span class="input-group-addon">%</span>
                    <input type="text" class="form-control" name="bnama" placeholder="masukan %" maxlength="2">

                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                      <label>Komisi Final</label>
                  <div class="input-group">
                       <span class="input-group-addon">Rp</span>
                    <input type="number" class="form-control" name="biaya" value="0">
                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
              </div>
              <!-- /.row -->

                   <div class="row">
                <div class="col-lg-12">
                    <p>Nilai Komisi bersifat final, silahkan input Diskon,PPN atau Biaya sebelum input komisi</p>
                </div>

      </div>

      <div class="modal-footer">
      
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
         <button type="submit" name="aturdiskon" class="btn bg-blue">Simpan</button>

      </div>
    </div>
 
  </div>
</div>
</form>
<!-- end modal biaya-->







        </div>

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
        <script src="1-11-4-jquery-ui.min.js"></script>

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
$('#datepicker').datepicker('update', new Date());
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
