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
$halaman = "bayar"; // halaman
$dataapa = "Pembayaran"; // data
$tabeldatabase = "bayar"; // tabel database
$chmod = $chmenu2; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(no) as max_id FROM bayar ORDER BY no";
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
 $db="transaksimasuk";
?>
 <?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>

<!-- SETTING STOP -->
 <?php

    if($nota == null || $nota == ""){

            $datatotal = SecurityBootstrap::sumCartByNota($conn, 'transaksimasuk', $nota, 'harga*jumlah');
            $databelitotal = SecurityBootstrap::sumCartByNota($conn, 'transaksimasuk', $nota, 'hargabeli*jumlah');
    }else{

      $datatotal = SecurityBootstrap::sumCartByNota($conn, 'transaksimasuk', $nota, 'harga*jumlah');
      $databelitotal = SecurityBootstrap::sumCartByNota($conn, 'transaksimasuk', $nota, 'hargabeli*jumlah');


    }

    ?>

<!-- BREADCRUMB -->
<?php 

//diskon


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




//menyimpan ke tabel bayar

    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
         $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
      
         $perdis= $_SESSION['perdis'.$nota];
          $diskon= $_SESSION['nomdis'.$nota];
          

 $pajak = mysqli_real_escape_string($conn, $_POST["nomtax"]);

         $total = mysqli_real_escape_string($conn, $_POST["total"]);
         $bayar = mysqli_real_escape_string($conn, $_POST["bayar"]);
          $perpajak = mysqli_real_escape_string($conn, $_POST["pertax"]);
         $kembali = mysqli_real_escape_string($conn, $_POST["kembali"]);
         $tipe = mysqli_real_escape_string($conn, $_POST["tipe"]);
         $ket = mysqli_real_escape_string($conn, $_POST["keterangan"]);
         $databelitotal = mysqli_real_escape_string($conn, $_POST["beli"]);
         $today=date('Y-m-d');
          $jam=date('h:i');

          $kasir = $_SESSION["username"];
        
              $berhasil = "berhasil";

               $sql="select * from bayar where nota='$nota'";
            $result=mysqli_query($conn,$sql);


                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Terjadi kesalahan: Nomor Nota yang sama sudah ada!');</script>";
              } else if ($bayar>0 && $bayar>=$total) {


                 mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into bayar values( '$nota','$tglnota','$jam','$bayar','$total','$kembali','$databelitotal','$kasir','$perdis','$diskon','$perpajak','$pajak','','','$tipe','$ket')";
               if(mysqli_query($conn, $sql2)){

            
                $mt=mysqli_query($conn,"select * from transaksimasuk where nota='$nota'");
                while($rw=mysqli_fetch_assoc($mt)){
                    $kode=$rw['kode'];
                    $kurang=$rw['jumlah'];
                    $kegiatan="Penjualan kasir";
                    $status="berhasil";
                    $bt=mysqli_fetch_assoc(mysqli_query($conn,"select sisa from barang where kode='$kode'"));
                    $sisaakhir=$bt['sisa'];

             mysqli_query($conn,"SET session sql_mode = ''");	$sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$jam','$kode','$sisaakhir','$kurang','$kegiatan','$nota','','$status')";
               $mutasi = mysqli_query($conn, $sql4);
                }

                unset($_SESSION['perdis'.$nota]);
                 unset($_SESSION['nomdis'.$nota]);
                  unset($_SESSION['pajak'.$nota]);


                echo "<script type='text/javascript'>window.location = 'bayar_print?q=$nota';</script>";


                } else {
                    echo "<script type='text/javascript'>  alert('Gagal,Terjadi kesalah query. Hubungi Admin');</script>";
                echo "<script type='text/javascript'>window.location = 'bayar.php';</script>";
                    }



              } else {
                echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan Data pembayaran benar');</script>";
                echo "<script type='text/javascript'>window.location = 'bayar.php';</script>";
              }


       



   }

   }


?>

<!-- BREADCRUMB -->

<?php 

$perdis= $_SESSION['perdis'.$nota];
$nomdis= $_SESSION['nomdis'.$nota];
$ppn= $_SESSION['pajak'.$nota];

if($perdis >0 || $nomdis >0){} else {
$display1="style='display:none;'";
}

if($ppn >0){ } else { 
    $display2="style='display:none;'";
}

if($perdis >0 || $nomdis >0 || $ppn >0){} else {
$display3="style='display:none;'";
}


$afterdis=$datatotal-ROUND($nomdis);
$tax=$ppn/100*$afterdis;

$aftertax=$afterdis+ROUND($tax);



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
                         <!-- Default box -->
                         <div class="col-lg-9">
      <div class="main box">

        <div class="box-header with-border">
             <div class="margin">
         <a data-toggle="modal" data-target="#modaldiskon" class="btn bg-blue">Diskon</a>
          <a data-toggle="modal" data-target="#modalpajak" class="btn bg-maroon">PPN</a>             
   
     </div>

          <div class="box-tools pull-right col-xs-6">
          <input class="form-control input-lg" value="<?php echo number_format($aftertax, $decimal, $a_decimal, $thousand);?>" style="background-color: yellow;font-size: 24px;font-weight:bold;" readonly>
          </div>
        </div>
        












<div class="row">


        <div class="box-body col-lg-8 col-sm-8">
         

            <!--tabel-->

<div class="box-body no-padding">
     <?php
     
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from $db where nota ='$nota' order by no";
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
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
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
            <div class="col-lg-3 col-sm-3">
                                      
                                   
                <!-- /.box-header -->
            <div class="box-body no-padding">
<form method="post" id="Myform" class="form-user">

              <table class="table table-striped">
                <tr>


                  
                  <th>Sub total</th>
                  <input type="hidden" value="<?php echo $nota;?>" class="form-control" name="nota">
                  <input type="hidden" value="<?php echo $datatotal;?>" class="form-control" id="subtotal">
                  <input type="hidden" value="<?php echo $databelitotal;?>" class="form-control" name="beli">
                  
                  <th ><input type="text" value="<?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?>" class="form-control" readonly></th>
                </tr>

       <tr <?php echo $display1;?>>
                 
                  <td>Diskon(<?php echo $perdis;?>%)</td>
                 
                  <td><input type="text" class="form-control" id="diskon" value="<?php echo ROUND($nomdis);?>" readonly>
                   
                </td>

                </tr>

                 <tr <?php echo $display2;?>>
                 
                  <td>PPN(<?php echo $ppn;?>%)</td>
                 
                  <td><input type="text" class="form-control" id="diskon" value="<?php echo ROUND($tax);?>" readonly>
                    <input type="hidden" class='form-control' value="<?php echo ROUND($tax);?>" name="nomtax">
                     <input type="hidden" class='form-control' value="<?php echo $ppn;?>" name="pertax" value="pertax">
                  </td>

                </tr>

                <tr <?php echo $display2;?>>
                  
                  <td>Total Bayar</td>
                 
                  <td><input type="text" class="form-control" value="<?php echo $aftertax;?>" id="total" name="total" readonly></td>
                </tr>
                
                 <script>
                                   function sum2() {
                                         var txtFirstNumberValue =  document.getElementById('jumlah').value
                                         var txtSecondNumberValue = document.getElementById('total').value;
                                         var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('kembalian').value = result;
                                            document.getElementById('change').value = result;
                                            document.getElementById('pay').value = txtFirstNumberValue;
                                         }
                                       if (!$(jumlah).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                       if (!$(total).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                   }
                                   </script>
                  
                  <td>Jumlah Bayar</td>
                  
                  <td><input type="text" class="form-control" id="jumlah" name="bayar" autocomplete="off" onkeyup="sum2();"></td>
                </tr>

                <tr>
                  
                  <td>Uang Kembali</td>
                  
                  <td><input type="text" class="form-control" name="kembali" id="kembalian" readonly></td>

                </tr>

                <tr>
                  
                  <td>Tipe Bayar</td>
                  
                  <td><select style="width:100%" name="tipe" class="select2">
                      <option value=Cash>Cash</option>
                      <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from options where tipe='pay' ");
        while ($row=mysqli_fetch_assoc($sql)){
          echo "<option value='".$row['nama']."' >".$row['nama']."</option>";
        }
      ?>
                    </select></td>
                </tr>
                <tr>

                 <tr>
                  
                  <td>Keterangan</td>
                  
                  <td><textarea name="keterangan" style="width: 100%;"></textarea> </td>

                </tr>

                <tr>
                  
                  <td>Tanggal Transaksi</td>
                  
                  <td><input type="text" class="form-control" id="datepicker2" name="tglnota"></td>

                </tr>



                 <tr>
                  
                  <td > <input type="button" class="btn btn-block pull-left btn-flat btn-danger"  onclick="window.open('add_jual','_self')" value="KEMBALI" /> </td>
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
                    <input type="text" class="form-control" id="ppn" name="pajak" placeholder="% Pajak PPN" maxlength="2" value="<?php echo $ppn;?>" style="text-align: left;">
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
                       <span class="input-group-addon"></span>
                    <input type="text" class="form-control" name="biayaname" value="Biaya Extra">

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








                       <!--
<script>
function myFunction() {
    document.getElementById("Myform").submit();
}

         var helpWindow;

function Struk(url) {
    helpWindow = window.open(url, 'helpWindow');


}
      </script>

  -->

  <!---STRUK-->
<?php 
        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];

        $sql1="SELECT * FROM bayar where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $tglbayar=$row['tglbayar'];
        $bayar=$row['bayar'];
        $total=$row['total'];
        $kembali=$row['kembali'];
        $kasir=$row['kasir'];

        $sql1="SELECT SUM(jumlah) as data FROM $db where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $totalqty=$row['data'];

        $sql1="SELECT * FROM $db where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $kode=$row['kode'];
        $berhasil="berhasil";

        $sql1="SELECT * FROM mutasi where keterangan='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $status=$row['status'];

        if($status=="pending" || $status=="berhasil" ){
        //update mutasi
               $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$nota'";
               $updatemutasi = mysqli_query($conn, $sql3);
             }

        ?>
  <!--END STRUK-->

<link rel="stylesheet" href="dist/plugins/print/one.css">
<style>
input {
      border-top-style: hidden;
      border-right-style: hidden;
      border-left-style: hidden;
      border-bottom-style: hidden;
      background-color: #fefefe;
      text-align:right;
      }
    </style>
                        <div class="col-lg-3">
      <div class="box">

        <div class="box-header with-border">

          <h3 class="box-title">Tampilan Struk</h3>

          <div class="box-tools pull-right">
            
           
          </div>
        </div>
        <div class="box-body">
          


 <table  class="table-header">

        <!-- <tr><td><img src=\dist\img\avatar.png></td></tr>  -->
<!--        <tr><td colspan="4" class="nama" style="font-size:16px; align=left; font-weight:bold; width:240px"><?php echo $nama;?></td></tr>
             <tr><td colspan="4" style="font-style:italic; width:240px;  "><?php echo $tagline;?></td></tr>
        <tr><td colspan="4" style="width:240px;"><?php echo $alamat;?></td></tr>
        <tr><td colspan="4" style="border-bottom:double 4px #000; padding-bottom:5px;width:240px;"><?php echo $notelp;?></td></tr>
-->

</table>
        </table>

        <table class="table-print">
        <tr class="spa">
        <td width="20%" style="width:48px;">&nbsp;</td>
        <td width="15%" style="width:28.8px;">&nbsp;</td>
        <td width="20%"  style="width:43.2px;">&nbsp;</td>
        <td width="18%"  style="width:48px;">&nbsp;</td>
        <td width="18%"  style="width:60px;">&nbsp;</td>
        <td width="8%"  style="width:12px;">&nbsp;</td>
        </tr>
        <tr>
        </tr>

        <tr >
           <td style="width:192px;" colspan="6" align="left">No.Nota - <?php echo $nota;?></td>
        </tr>
        
           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

          <?php

          $query1="SELECT * FROM  $db where nota ='$nota' order by no";
          $hasil = mysqli_query($conn,$query1);
          while ($fill = mysqli_fetch_assoc($hasil)){
            ?>

            <tr>
              <td colspan="5" style="width:240px;"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
              </tr>

              <tr>

              <td colspan="2" style="width:76.8px;">Qty : </td>
              <td ><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?> x</td>
              <td style="width:40px;" align="center"><?php  echo number_format(($fill['harga']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              <td style="width:72px;" colspan="2" align="right"><?php  echo number_format(($fill['harga_asli']*$fill['jumlah']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              </tr>

<?php if($fill['diskon_persen']>0){?>
                 <td colspan="2" style="width:76.8px;">Diskon </td>
              <td colspan="2"><?php  echo mysqli_real_escape_string($conn, $fill['diskon_persen']); ?> %</td>
              
              <td style="width:72px;" colspan="2" align="right">- <?php  echo number_format(($fill['harga_asli']-$fill['harga']), $decimal, $a_decimal, $thousand).',-'; ?></td>
              </tr>
          <?php } ?>


            <tr class="siv">
              <td colspan="5" style="width:228px;">
            <div class="dotted-border"></div> </td>
            <td style="width:12px;">(+) </td>
            </tr>

            <?php
            ;
          }

           ?>

        <tr>
          <td colspan="2" style="width:76.8px;">Total Qty</td>
          <td style="width:43.2px;"><?php echo $totalqty; ?></td>
          <td style="width:48px;"><b>Sub Total</b></td>
          <td style="width:72px;" colspan="2" align="right"><b><?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-';?></b></td>
         </tr>

<?php if($perdis>0){?>
          <tr>
          <td colspan="2" style="width:76.8px;">Diskon</td>
          <td style="width:43.2px;"></td>
          <td style="width:48px;"><?php echo $perdis;?>%</td>
          <td style="width:72px;" colspan="2" align="right"><b><?php echo number_format($nomdis, $decimal, $a_decimal, $thousand).',-';?></b></td>
         </tr>


     <?php } ?>
     <?php if($ppn>0){?>

          <tr>
          <td colspan="2" style="width:76.8px;">PPN</td>
          <td style="width:43.2px;"></td>
          <td style="width:48px;"><?php echo $ppn;?>%</td>
          <td style="width:72px;" colspan="2" align="right"><b><?php echo number_format($tax, $decimal, $a_decimal, $thousand).',-';?></b></td>
         </tr>
<?php } ?>


<?php if($perdis>0 || $ppn>0){?>

  <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

 <tr>
          <td colspan="2" style="width:76.8px;"><b>Total</b></td>
          <td style="width:43.2px;"></td>
          <td style="width:48px;"></td>
          <td style="width:72px;" colspan="2" align="right"><b><?php echo number_format($aftertax, $decimal, $a_decimal, $thousand).',-';?></b></td>
         </tr>
<?php } ?>

   <td colspan="2" style="width:76.8px;"><b>Bayar</b></td>
          <td style="width:43.2px;"></td>
          <td style="width:48px;"></td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="pay"></td>
         </tr>

         
        <tr class="siv">
          <td colspan="5" style="width:228px;">
        <div class="dotted-border"></div> </td>
        <td style="width:12px;">(-) </td>
        </tr>

        <tr>
          <td colspan="3" style="width:116px;"></td>
          <td style="width:52px;">Kembali</td>
          <td style="width:72px;" colspan="2" align="right"><input type="text" id="change"></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

        <tr>
          <td style="width:237px;" colspan="6" align="right"><?php echo $kasir;?></td>
          </tr>

           <tr class="siv solid">
            <td colspan="6" style="width:240px;">
          <div class="solid-border" ></div>
        </td>
          </tr>

       
         
        </table>



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
