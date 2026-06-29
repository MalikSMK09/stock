
 
<?php
include  "configuration/config_barcode.php"; // include php barcode 128 class
include "configuration/config_connect.php";
 
$set=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang_setting_barcode"));

$atas=$set['label_atas'];
$bawah=$set['label_bawah'];
$kolom = $set['jml_kolom'];  // jumlah kolom



 
if ($_POST['jumlah'] ==""){
	$copy = "1";
} else {
	$copy = $_POST['jumlah'];
} // jumlah copy barcode

$barcode = $_POST['barcode'];
$kode = $_POST['kode'];
$counter = 1;
// sql query ke database
$sql_barcode = "SELECT * FROM barang WHERE kode='$kode' ";
$baca_barcode = mysqli_query($conn, $sql_barcode) or die ("Gagal Query".mysqli_error());
$data_barcode = mysqli_fetch_array($baca_barcode);


if($atas==1){
	$labelatas=substr($data_barcode['nama'],0,25);

} else if($atas==2){
	$labelatas=$barcode;
} else {

$decimal ="0";
$a_decimal =",";
$thousand =".";
$denom="Rp";
	$labelatas= $denom . ' ' . number_format($data_barcode['hargajual'], $decimal, $a_decimal, $thousand).'';
}



if($bawah==1){
	$labelbawah=substr($data_barcode['nama'],0,25);

} else if($bawah==2){
	$labelbawah=$barcode;
} else {

$decimal ="0";
$a_decimal =",";
$thousand =".";
$denom="Rp";
	$labelbawah= $denom . ' ' . number_format($data_barcode['hargajual'], $decimal, $a_decimal, $thousand).'';
}



//menampilkan hasil generate barcode
echo"
<table cellpadding='10'>";
for ($ucopy=1; $ucopy<=$copy; $ucopy++) {
if (($counter-1) % $kolom == '0') { echo "
<tr>"; }
echo'<td style="font-size:10;text-align:center"><b>'.$labelatas.'</b>';
echo bar128( stripslashes($_POST['barcode']),$labelbawah );
echo "</td>
";
if ($counter % $kolom == '0') { echo "</tr>
"; }
$counter++;
}
echo "</table>
";
?>
<script>

          setTimeout(function(){window.print()}, 2000);
           </script>