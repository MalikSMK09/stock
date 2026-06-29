<?php
//Include file koneksi ke database
include "configuration/config_connect.php";
 $id = mysqli_real_escape_string($conn, $_POST["id"]);

$cek=mysqli_fetch_assoc(mysqli_query($conn,"select * from invoicejual where no='$id'"));
$kode=$cek['kode'];
$qty=$cek['jumlah'];

$brg=mysqli_fetch_assoc(mysqli_query($conn,"select sisa,terjual from barang where kode='$kode'"));
$stok=$brg['sisa']+$qty;
$terjual=$brg['terjual']-$qty;

$up=mysqli_query($conn,"update barang set sisa='$stok',terjual='$terjual' where kode='$kode'");


//Query hapus data dalam keranjang
$sql="DELETE FROM invoicejual WHERE no='$id'";

//Mengeksekusi/menjalankan query diatas
$hasil=mysqli_query($conn,$sql);
?>