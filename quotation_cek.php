<?php
include "configuration/config_connect.php";


$q=$_GET['q'];

$sql=mysqli_query($conn,"SELECT * FROM quotation_list WHERE conv='1'");

if( mysqli_num_rows($sql)<1){
 echo "<script type='text/javascript'>window.location = 'quotation_conv?q=$q';</script>";
} else {

$result=mysqli_fetch_assoc($sql);
$nota=$result['nota'];

	if($nota==$q){
echo "<script type='text/javascript'>window.location = 'quotation_conv?q=$q';</script>";
	} else {

 echo "<script type='text/javascript'>window.location = 'quotation_confirm?q=$nota';</script>";

}

}


?>