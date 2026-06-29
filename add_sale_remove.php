<?php
//Include file koneksi ke database
include "configuration/config_ajax_auth.php";
 $id = mysqli_real_escape_string($conn, $_POST["id"]);

//Query hapus data dalam keranjang
$sql="DELETE FROM invoicejual WHERE no='$id'";

//Mengeksekusi/menjalankan query diatas
$hasil=mysqli_query($conn,$sql);
?>