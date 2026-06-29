<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";

date_default_timezone_set("Asia/Jakarta");
$today=date('Y-m-d');

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
$halaman = "add_buy"; // halaman
$dataapa = "Invoice Pembelian"; // data
$tabeldatabase = "invoicebeli"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];
$tabel = "buy";

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX(RIGHT(nota, 6)) as max_id FROM buy ORDER BY nota";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 6);
  $sort_num++;
  $new_code = sprintf("%06s", $sort_num);
  return $new_code;
 }
?>

<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
?>


<!-- SETTING STOP -->

<script>
  function SubmitForm() {
    var kode = $("#kode").val();
      var barang = $("#barang").val();
        var nama = $("#nama").val();
          var hargabeli = $("#hargabeli").val();
            var jumlah = $("#jumlah").val();
            var hargaakhir = $("#hargaakhir").val();
            var datatotal = $("#datatotal").val();

    //alert("Produk : "+nama+"\nTelah berhasil ditambahkan!");

    $.post("add_buy.php", { kode: kode, barang: barang, nama: nama, hargabeli: hargabeli, jumlah: jumlah, hargaakhir: hargaakhir, datatotal: datatotal}, function(data) {

    });


  }
</script>

<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>
<?php
  if($insert == "10"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah berhasil <b>ditambahkan</b> ke Data <?php echo $dataapa;?>.
</div>

<?php
  }
  if($insert == "3"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah <b>terupdate</b>.
</div>

<!-- BOX UPDATE GAGAL -->
<?php
  }
  ?>

       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?></h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    $kode=$nama=$hargabeli=$jumlah=$hargaakhir=$tglnota=$bayar=$kembalian="";
    $no = $_GET["no"];
    $kode = $_POST['kode'];
    $hargaakhir = $_POST['hargaakhir'];
    $tglnota = $_POST['tglnota'];
    $datatotal = $_POST['datatotal'];
        $insert = '1';



    if(($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){

         $sql="select * from $tabeldatabase where kode='$kode'";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){


          $kode = $fill["kode"];
          $nama = $fill["nama"];
                  $insert = '3';

    }
    }
    ?>
    <?php

    if($kode == null || $kode == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


    if(isset($_POST["tambah"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $barang = mysqli_real_escape_string($conn, $_POST["barang"]);
              $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
              $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
              $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
              $kasir = $_SESSION["username"];
              $kegiatan = "membeli barang memakai invoice";
              $status = "pending";
              $insert = ($_POST["insert"]);


                 $sql="select * from $tabeldatabase where nota='$kode' and kode='$barang'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

                    echo "<script type='text/javascript'>  alert('Barang sudah ada, silakan hapus dahulu untuk merubah!');</script>";
              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($jumlah >= '1')){
//masukan ke cart
               mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabeldatabase values( '$kode','$barang','$nama','$hargabeli','$jumlah','','$hargaakhir','')";
               $insertan = mysqli_query($conn, $sql2);
//update stok barang
//              $sqle3="SELECT * FROM barang where kode='$barang'";
//              $hasile3=mysqli_query($conn,$sqle3);
//              $row=mysqli_fetch_assoc($hasile3);
//              $sisaawal=$row['sisa'];
//              $terbeliawal=$row['terbeli'];
 //             $terjualawal=$row['terjual'];

 //             $terbeliakhir = $terbeliawal + $jumlah;
 //             $sisaakhir = $terbeliakhir - $terjualawal;

   //            $sql3 = "UPDATE barang SET terbeli='$terbeliakhir', sisa='$sisaakhir' where kode='$barang'";
   //            $updatestok = mysqli_query($conn, $sql3);
//merekam mutasi
               mysqli_query($conn,"SET session sql_mode = ''");	$sql4 = "INSERT INTO mutasi values ( '$kasir','$today','$barang','$sisaakhir','$jumlah','$kegiatan','$kode','','$status')";
               $mutasi = mysqli_query($conn, $sql4);

                 echo "<script type='text/javascript'>window.location = 'add_buy?item=add';</script>";
             }else{
              echo "<script type='text/javascript'>  alert('Gagal, Stok Kurang / Jumlah tidak boleh kosong!');</script>";

             }

      }

    }




    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
                $tgl = mysqli_real_escape_string($conn, $_POST["tgl"]);
                  $nopo = mysqli_real_escape_string($conn, $_POST["nopo"]);
                   $biaya = mysqli_real_escape_string($conn, $_POST["biaya"]);
              $supplier = mysqli_real_escape_string($conn, $_POST["supplier"]);
              $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
              $kasir = $_SESSION["username"];
              $berhasil = "berhasil";
              $belum = "belum";
              $insert = ($_POST["insert"]);
              $cek = mysqli_real_escape_string($conn, $_POST["cek"]);

if($supplier!=''){

  if($cek !=''){
                          $sql="select * from $tabel where nota='$kode'";
                         $result=mysqli_query($conn,$sql);

                         if(mysqli_num_rows($result)>0){

                          echo "<script type='text/javascript'>  alert('Data tidak bisa diubah!');</script>";
                        }
                      else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){

                       mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabel values( '$kode','$nopo','$tgl','$tglnota','$biaya','$datatotal','','$supplier','$kasir','$belum','','$keterangan','')";
                      $insertan = mysqli_query($conn, $sql2);

                     $sql3 = "UPDATE mutasi SET status='$berhasil' where keterangan='$kode'";
                     $updatemutasi = mysqli_query($conn, $sql3);


                    echo "<script type='text/javascript'>  alert('Berhasil, Pembelian sukses dilakukan!'); </script>";
                     echo "<script type='text/javascript'>window.location = 'pembelian';</script>";
                   }else{
                   echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan! Pastikan pembayaran benar');</script>";

                   }

           } else {
            echo "<script type='text/javascript'>  alert('Total Barang yang dibeli tidak boleh kosong');</script>";
           }
} else {
echo "<script type='text/javascript'>  alert('Supplier belum dipilih!');</script>";
}
      }

    }



    if($kode == null || $kode == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM $tabeldatabase WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


             ?>




  <div id="main">
   <div class="container-fluid">

          <form class="form-horizontal" method="post" action="<?php echo $halaman; ?>" id="Myform" class="form-user">
              <div class="box-body">

                <div class="row">

                  <div class="col-md-6">
                    <div class="box box-info">
                      <div class="box-body">


                        <div class="form-group col-md-6 col-xs-12" >
                          <label for="kode" class="col-sm-4 control-label">Kode Transaksi:</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>" maxlength="50" required readonly>
                  </div>
                </div>
                  <div class="form-group col-md-6 col-xs-12" >
                  <label for="tglnota" class="col-sm-4 control-label">Tanggal:</label>
                  <div class="col-sm-8">
             <input type="text" class="form-control pull-right" id="datepicker2" name="tgl" placeholder="Masukan Tanggal Nota" value="<?php echo $tglnota; ?>" >
          </div>
        </div>



        <div class="row" >
           <div class="form-group col-md-12 col-xs-12" >
                  <label for="barang" class="col-sm-2 control-label">Pilih Barang:</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;" name="barang" id="barang">
                      <option></option>
              <?php
              error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $sql=mysqli_query($conn,"select * from barang");
        while ($row=mysqli_fetch_assoc($sql)){
          if ($barang==$row['kode'])
          echo "<option value='".$row['kode']."' nama='".$row['nama']."' hargabeli='".$row['hargabeli']."' sisa='".$row['sisa']."' selected='selected'>".$row['sku']." | ".$row['nama']."</option>";
          else
          echo "<option value='".$row['kode']."' nama='".$row['nama']."' hargabeli='".$row['hargabeli']."'  sisa='".$row['sisa']."' >".$row['sku']." | ".$row['nama']."</option>";
        }
      ?>
                    </select>
                  </div>
                </div>
        </div>


            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-danger">
            <div class="box-body">

              <div class="row" >
                 <div class="form-group col-md-12 col-xs-12" >
                        <div class="col-sm-10">

                          <?php if($datatotal == "" || $datatotal == null){?>
                            <h1 align="center">Rp   <?php echo '0'.',-'; ?></h1>
                            <?php }else{ ?>
                        <h1 align="center">Rp   <?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?></h1>
                        <?php } ?>
                        </div>
                      </div>
              </div>


</div>
</div>
</div>


      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >


              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="box box-default">
                    <div class="box-body">

                  <div class="row" >

                      <div class="col-sm-4">
                      <label for="usr">Nama Barang</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" readonly>
                    </div>

                    <div class="col-sm-2">
                    <label for="usr">Sisa Stok</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" readonly>
                  </div>


                                                <script>
                                               function sum() {
                                                     var txtFirstNumberValue =  document.getElementById('jumlah').value
                                                     var txtSecondNumberValue = document.getElementById('hargabeli').value;
                                                     var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('hargaakhir').value = result;
                                                     }
                                                   if (!$(jumlah).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                                   if (!$(hargabeli).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                               }
                                               </script>

                  <div class="col-sm-2">
                  <label for="usr">Harga Satuan</label>
                  <input type="text" class="form-control" id="hargabeli" name="hargabeli" value="<?php echo $hargabeli; ?>" onkeyup="sum();">
                </div>


                <div class="col-sm-2">
                <label for="usr">Jumlah Beli</label>
                <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" placeholder="Masukan Jumlah" onkeyup="sum();">
              </div>

              <div class="col-sm-2">
              <label for="usr">Total Bayaran</label>
              <input type="text" class="form-control" id="hargaakhir" name="hargaakhir" value="<?php echo $hargaakhir; ?>" readonly>
            </div>

                  </div>
                </br>
                  <button type="submit" class="btn btn-block pull-left btn-flat btn-info" name="tambah" onclick="SubmitForm()" ><span class="glyphicon glyphicon-shopping-cart"></span> Tambah</button>



</div>
</div>
                </div>
              </div>



              <div class="row">
                <div class="col-md-12">
                  <div class="box box-success">
                    <div class="box-header with-border">

    <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 500);
</script>

                           <?php
if (isset($_GET['item'])) {
?>
    <div id="myAlert"  class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  Barang telah ditambahkan kedalam keranjang pembelian.
</div>

<!-- BOX HAPUS BERHASIL -->
<?php } ?>






             <b>Daftar Barang</b>
           </div>

           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "select * from $tabeldatabase where nota =".autoNumber()." order by no";
           $result = mysqli_query($conn, $sql);
           $rpp    = 5;
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
              <table class="data table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Harga Satuan</th>
                          <th>Jumlah beli</th>
                          <th>Total Bayar</th>
           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                          <th>Opsi</th>
           <?php }else{} ?>
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
           <td><?php  $cba =$fill['kode'];
        $r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT sku FROM barang WHERE kode='$cba'"));
       echo mysqli_real_escape_string($conn, $r['sku']); ?>
                        </td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <a class="btn btn-danger btn-xs" href="component/delete/delete_produk?get=<?php echo '2'.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=0&kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>">Hapus</a>
           <?php } else {}?>
           </td></tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>


           </div>

           </div>


         </div>
                  </div>
                </div>



                            <div class="row">
                              <div class="col-md-12">
                                <div class="box box-solid">
                                  <div class="box-header with-border">


                                    <div class="row" >
                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-2 control-label">Supplier:</label>
                                              <div class="col-sm-10">
                                                <select class="form-control select2" style="width: 100%;" name="supplier" id="supplier">
                                                  <option value="">Pilih</option>
                                          <?php
                                    $sql=mysqli_query($conn,"select * from supplier");
                                    while ($row=mysqli_fetch_assoc($sql)){
                                      if ($pelanggan==$row['kode'])
                                      echo "<option value='".$row['kode']."' selected='selected'>".$row['kode']." | ".$row['nama']."</option>";
                                      else
                                      echo "<option value='".$row['kode']."'>".$row['kode']." | ".$row['nama']."</option>";
                                    }
                                  ?>
                                                </select>
                                              </div>
                                            </div>


                                            <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-3 control-label">Jatuh Tempo:</label>
                                              <div class="col-sm-9">
                                                <input class="form-control" id="datepicker" name="tglnota" value="<?php echo date('Y-m-d');?>">
                                              </div>
                                            </div>


                                              <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-2 control-label">Biaya Lain:</label>
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control" id="biayae" name="biaya" value="0"  onkeyup="sum1();" autocomplete="off">
                                              </div>
                                            </div>



                                              <script>
                                   function sum1() {
                                         var txtFirstNumberValue =  document.getElementById('subtotal').value
                                         var txtSecondNumberValue = document.getElementById('biayae').value;
                                         var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('totale').value = result;
                                          
                                   } }
                                   </script>


                                            <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-3 control-label">Total :</label>
                                              <div class="col-sm-9">
                                                <input type="text" class="form-control" id="totale" name="total" value="<?php echo $datatotal; ?>" readonly>
                                                 <input type="hidden" class="form-control" id="subtotal" value="<?php echo $datatotal; ?>" readonly>
                                              </div>
                                            </div>






                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="keterangan" class="col-sm-2 control-label">Keterangan:</label>
                                              <div class="col-sm-10">
                                              <textarea class="col-sm-12 col-xs-12" id="keterangan" name="keterangan" value="<?php echo $keterangan; ?>" width="100%"> </textarea>
                                            </div>
                                              
                                            </div>


                                             <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-3 control-label">No. P.O/Faktur:</label>
                                              <div class="col-sm-9">
                                                <input class="form-control" name="nopo" value="PO<?php echo autoNumber();?>">
                                              </div>
                                            </div>


                                    </div>



                                  </div>
                                </div>
                              </div>
                            </div>


                            <input type="hidden" value="<?php echo $datatotal;?>" name="cek">

              <!-- /.box-body -->
              <div class="box-footer" >
                <div class="col-sm-6">
                <button type="submit" class="btn btn-block pull-left btn-flat btn-danger" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
</div>
              </div>
              <!-- /.box-footer -->


 </form>
</div>
<script>
function myFunction() {
    document.getElementById("Myform").submit();
}
</script>

    <!-- KONTEN BODY AKHIR -->

                                </div>
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
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="1-11-4-jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
$("#barang").on("change", function(){

  var nama = $("#barang option:selected").attr("nama");
  var hargabeli = $("#barang option:selected").attr("hargabeli");
  var sisa = $("#barang option:selected").attr("sisa");

  $("#nama").val(nama);
  $("#hargabeli").val(hargabeli);
  $("#stok").val(sisa);
  $("#hargaakhir").val(hargabeli);
  $("#jumlah").val(1);
});
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
