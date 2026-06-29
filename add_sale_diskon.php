
<?php
 include "configuration/config_connect.php";

   $no = mysqli_real_escape_string($conn, $_POST["no"]);
    $per = mysqli_real_escape_string($conn, $_POST["perdis"]);
     $dis = mysqli_real_escape_string($conn, $_POST["diskon"]);
   

   $co=mysqli_query($conn,"update invoicejual set harga='$dis', diskon_persen='$per', diskon_harga='$dis' where no='$no'");



 $output['status']="berhasil";
                    $output['message']="gagal";
   echo json_encode($output);