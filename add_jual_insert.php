
<?php
include "configuration/config_ajax_auth.php";
$tabeldatabase="transaksimasuk";

   $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
            
              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
             
                   
              $inqty = mysqli_real_escape_string($conn, $_POST["qty"]);
              if($inqty<=1 || $inqty==''){
                  $qty=1;
              } else {
                  $qty=$inqty;
              }
            
              $stok = mysqli_real_escape_string($conn, $_POST["stok"]);

$output = array('status' => 'gagal', 'message' => '');

if($stok>0){
    
    if($qty<=$stok){

$peng=mysqli_fetch_assoc(mysqli_query($conn,"select * from barang where kode='$kode'"));

$hargajual=$peng['hargajual'];
$hargabeli=$peng['hargabeli'];
$nama=$peng['nama'];
$sisa=$peng['sisa'];

    
            $sql="select * from $tabeldatabase where nota='$nota' and kode='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

   $pang=mysqli_fetch_assoc(mysqli_query($conn,"select * from $tabeldatabase where nota='$nota' and kode='$kode'"));
   $jml=$pang['jumlah']+$qty;

   if($jml>$sisa){
       $output['status']="gagal";
       $output['message']="Gagal, Jumlah diinput melebihi stok tersedia";
   } else {
          $ping=mysqli_query($conn,"update $tabeldatabase set jumlah='$jml' where nota='$nota' and kode='$kode'");
          $output['status']="berhasil";
          $output['message']="";
   }

              } else {

            if($qty>$sisa){
                $output['status']="gagal";
                $output['message']="Gagal, Jumlah diinput melebihi stok tersedia";
            } else {

               mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabeldatabase values( '$nota','$kode','$nama','$hargajual','0','$hargajual','$hargabeli','$qty','0','$hargajual','')";
               $insertan = mysqli_query($conn, $sql2);

             $output['status']="berhasil";
                    $output['message']="";

               }
               } 


} else {
     $output['status']="gagal";
                    $output['message']="Gagal, Jumlah diinput melebihi stok tersedia";
}               
               



} else {


   $output['status']="gagal";
$output['message']="GAGAL, Stok Kurang!";
}

echo json_encode($output);


           ?>