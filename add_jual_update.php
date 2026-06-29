<?php

include "configuration/config_connect.php";



if(isset($_POST["id"])){
    if(isset($_POST["qty"])){

$no = mysqli_real_escape_string($conn, $_POST["id"]);
$qty = mysqli_real_escape_string($conn, $_POST["qty"]);
 

$cek=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM transaksimasuk WHERE no='$no' "));

$harga=$cek['harga'];
$kode=$cek['kode'];
$oldqty=$cek['jumlah'];
$cut=$qty-$oldqty;

$ceki=mysqli_fetch_assoc(mysqli_query($conn,"SELECT sisa,terjual FROM barang WHERE kode='$kode' "));
$limit=$ceki['sisa']+$oldqty;
$sold=$ceki['terjual']-$oldqty;

if($qty>$limit){
    $qty=$limit;
$output['status']="gagal";
$output['message']="Stok tersedia hanya ".$limit."";

} else {
    $qty=$qty;
    $output['status']="berhasil";
    $output['message']="";
}
$soldid=$sold+$qty;

$sisa=$limit-$qty;
$brg=mysqli_query($conn,"update barang set terjual='$soldid', sisa='$sisa' where kode='$kode'");


$up="UPDATE transaksimasuk SET jumlah='$qty'WHERE no='$no'";
                        $s=mysqli_query($conn,$up);

echo json_encode($output);



} }
?>