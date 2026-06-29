<?php

include "configuration/config_connect.php";

$nota=$_GET['nota'];
$tipe=$_GET['tipe'];

$a=mysqli_fetch_assoc(mysqli_query($conn,"SELECT tipenota FROM backset"));

$q=$a['tipenota'];


if($tipe=="quotation"){


if($q==1){
  echo "<script type='text/javascript'>window.location = 'quotation_faktur_1.php?nota=$nota&tipe=$tipe';</script>";
} else if($q==2){
echo "<script type='text/javascript'>window.location = 'quotation_faktur_2.php?nota=$nota&tipe=$tipe';</script>";
} else if($q==3) {
echo "<script type='text/javascript'>window.location = 'quotation_faktur_3.php?nota=$nota&tipe=$tipe';</script>";
} else if($q==4){
echo "<script type='text/javascript'>window.location = 'quotation_faktur_4.php?nota=$nota&tipe=$tipe';</script>";
} else {
  echo "<script type='text/javascript'>window.location = 'quotation_faktur_5.php?nota=$nota&tipe=$tipe';</script>";
}



} else {

if($q==1){
  echo "<script type='text/javascript'>window.location = 'faktur_one?nota=$nota&tipe=$tipe';</script>";
} else if($q==2){
echo "<script type='text/javascript'>window.location = 'faktur_two?nota=$nota&tipe=$tipe';</script>";
} else if($q==3) {
echo "<script type='text/javascript'>window.location = 'faktur_three?nota=$nota&tipe=$tipe';</script>";
} else if($q==4){
echo "<script type='text/javascript'>window.location = 'faktur_four?nota=$nota&tipe=$tipe';</script>";
} else {
  echo "<script type='text/javascript'>window.location = 'faktur_five?nota=$nota&tipe=$tipe';</script>";
}


}


?>