<?php

include "configuration/config_ajax_auth.php";



if(isset($_POST["id"])){
    if(isset($_POST["qty"])){

$no = mysqli_real_escape_string($conn, $_POST["id"]);
$qty = mysqli_real_escape_string($conn, $_POST["qty"]);
 

$cek=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM invoicejual WHERE no='$no' "));

$harga=$cek['harga'];
$kode=$cek['kode'];
$oldqty=$cek['jumlah'];


$ceki=mysqli_fetch_assoc(mysqli_query($conn,"SELECT terjual,sisa FROM barang WHERE kode='$kode' "));
$limit=$ceki['sisa'];

if($qty>$limit){
    $qty=$limit;
$output['status']="gagal";
$output['message']="Stok tersedia hanya ".$limit."";

} else {
    $qty=$qty;
    $output['status']="berhasil";
    $output['message']="";
}

$up="UPDATE invoicejual SET jumlah='$qty'WHERE no='$no'";
                        $s=mysqli_query($conn,$up);

echo json_encode($output);



} }
?>