
<?php
include "configuration/config_ajax_auth.php";
$tabeldatabase="transaksimasuk";

   $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
            $bar = mysqli_real_escape_string($conn, $_POST["barcode"]);


$peng=mysqli_fetch_assoc(mysqli_query($conn,"select * from barang where barcode='$bar'"));

$hargajual=$peng['hargajual'];
$hargabeli=$peng['hargabeli'];
$nama=$peng['nama'];
$kode=$peng['kode'];
$qty=1;
$sisa=$peng['sisa'];


              $kasir = $_SESSION["username"]; 
              $jam=date('H:i');
              $today=date('Y-m-d');

$output = array('status' => 'gagal', 'message' => '');

if($sisa>0){


            $sql="select * from $tabeldatabase where nota='$nota' and kode='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

   $pang=mysqli_fetch_assoc(mysqli_query($conn,"select * from $tabeldatabase where nota='$nota' and kode='$kode'"));
   $jml=$pang['jumlah']+$qty;

   if($jml>$sisa){
       $output['status']="gagal";
       $output['message']="GAGAL, Stok Kurang!";
   } else {
          $ping=mysqli_query($conn,"update $tabeldatabase set jumlah='$jml' where nota='$nota' and kode='$kode'");
          $output['status']="berhasil";
          $output['message']="";
   }

              } else {

               mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabeldatabase values( '$nota','$kode','$nama','$hargajual','0','$hargajual','$hargabeli','$qty','0','$hargajual','')";
               $insertan = mysqli_query($conn, $sql2);

             $output['status']="berhasil";
                    $output['message']="";

               } 


} else {


   $output['status']="gagal";
$output['message']="GAGAL, Stok Kurang!";
}

echo json_encode($output);


           ?>