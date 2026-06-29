
<?php
session_start();
 include "configuration/config_connect.php";
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
              $kasir = $_SESSION["username"]; 
              $jam=date('H:i');
              $today=date('Y-m-d');

if($stok>0){
    
    if($qty<=$stok){

$peng=mysqli_fetch_assoc(mysqli_query($conn,"select * from barang where kode='$kode'"));

$hargajual=$peng['hargajual'];
$hargabeli=$peng['hargabeli'];
$nama=$peng['nama'];
$sold=$peng['terjual'];

    
            $sql="select * from $tabeldatabase where nota='$nota' and kode='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){
                      
    $stok=$stok-$pang['jumlah'];
   $limit=$stok+$pang['jumlah'];
   
   if($qty>$limit){
       $qty=$limit;
   }   

   $soldid=$sold +$qty;
           $jml=$pang['jumlah']+$qty;
           $sise=$peng['sisa']-$qty;

   $pang=mysqli_fetch_assoc(mysqli_query($conn,"select * from $tabeldatabase where nota='$nota' and kode='$kode'"));

        $jml=$pang['jumlah']+$qty;                

          $ping=mysqli_query($conn,"update $tabeldatabase set jumlah='$jml' where nota='$nota' and kode='$kode'");
    
     $sql3 = "UPDATE barang SET terjual='$soldid', sisa='$sise' where kode='$kode'";
               $updatestok = mysqli_query($conn, $sql3);


              } else {

            $sqle3="SELECT * FROM barang where kode='$kode'";
            $hasile3=mysqli_query($conn,$sqle3);
            $row=mysqli_fetch_assoc($hasile3);
            $terjual=$row['terjual']+$qty;
            $stok=$row['sisa']-$qty;

               mysqli_query($conn,"SET session sql_mode = ''");	$sql2 = "insert into $tabeldatabase values( '$nota','$kode','$nama','$hargajual','0','$hargajual','$hargabeli','$qty','0','$hargajual','')";
               $insertan = mysqli_query($conn, $sql2);

               $sql3 = "UPDATE barang SET terjual='$terjual', sisa='$stok' where kode='$kode'";
               $updatestok = mysqli_query($conn, $sql3);

             $output['status']="berhasil";
                    $output['message']="";

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