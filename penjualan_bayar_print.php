<!DOCTYPE html>
<html lang="en">

<head>
   
    <meta charset="utf-8">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="libs/faktur/four/paper.css">
    <link rel="stylesheet" href="libs/faktur/four/normalize.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/ico/font-awesome/css/font-awesome.min.css">


    <style>
table, th, td {
    font-size: 14px;
}

th, td {

    text-align: left;
    padding: 2px !important;
}

.t-center {
    text-align: center;
}

.t-left {
    text-align: left;
}

.bgcolor {
    background: #f1f1f1;
}
    </style>

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page {
        size: A4;
        margin-top: 4px;
        margin-bottom: 10px;
        margin-left: 20px;
    }</style>

    <style>
        /* Three image containers (use 25% for four, and 50% for two, etc) */
        .column {
            float: left;
            padding: 5px;
        }

        /* Clear floats after image containers */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        table tbody tr td {
            padding: 2px !important;
            line-height: 1.35 !important;
        }

        @media print {
            .box-body {
                margin-top: 5px !important;
                margin-bottom: 10px;
            }
        }
    </style>

    <script>
        /*window.onload = function () {
          window.print();
           window.top.close();

        }*/
    </script>
    <style>
        .center-me {
            font-size: 15px;
            margin: auto;
            height: 10px;
            max-width: 500px;
            margin: 75px auto 40px auto;
            display: flex;
        }
    </style>


    <style>
@media print{
   .noprint{
       display:none;
   }
  footer {page-break-after: always;}
}




    </style>
</head>



<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$nota = $_GET['q'];

include "configuration/config_connect.php";
$halaman = "faktur_kwintansi"; // halaman
$dataapa = "Kwintansi"; // data
$tabeldatabase = "salepayment"; // tabel database

$tabel = "sale";

date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');
 
?>
<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php

        $sql1="SELECT * FROM data";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $nama=$row['nama'];
        $alamat=$row['alamat'];
        $notelp=$row['notelp'];
        $tagline=$row['tagline'];
        $signature=$row['signature'];
        $avatar=$row['avatar'];


      

$tabel = "sale"; // tabel database
$tabeldatabase = "salepayment"; // tabel database
$judul="Invoice";

  $sql1="SELECT * FROM $tabel where nota='$nota'";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        
        $nomor=$row['nomor'];
           $kasir=$row['kasir'];
        $due=$row['duedate'];
        $subayar=$row['sudahbayar'];
       
        $total=$row['total'];
      
         $tgl=$row['tglsale'];
        $pelanggan=$row['pelanggan'];
        $keterangan=$row['keterangan'];
      

          if($row['status']=='belum'){
            $status="Belum Lunas";
          } else if($row['status']=='dibayar'){
            $status="Lunas";
          } else {
            $status="N/A";
          }
       

        $sql1="SELECT * FROM pelanggan where kode='$pelanggan' ";
        $hasil1=mysqli_query($conn,$sql1);
        $row=mysqli_fetch_assoc($hasil1);
        $customer=$row['nama'];
        $nohp=$row['nohp'];
        $address=$row['alamat'];


$lop=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(nota) as countitem FROM sale_payment WHERE nota='$nota'"));


$numrow=7;

$numofpage=ceil($lop['countitem']/$numrow);

if($lop['countitem']==$numrow){
    $rowoflastpage=$numrow;
} else {
    $rowoflastpage=$lop['countitem'] % $numrow;
}


$filler=$numrow-$rowoflastpage;
$lastpage=$numofpage-1;
        ?>











<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A5 landscape">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->



<?php

for ($i = 0; $i < $numofpage; $i++){
  $nohal=$i+1;  

  $limit =$nohal*$numrow;
  $offset=$i*$numrow;




?>


<section id="content-print" style="background: white;border-bottom: 1px dashed;">

     <?php if($i==0){?>

    <a href="" onClick="window.print()" class="btn btn bg-maroon noprint"><i class="fa fa-print" style="text-align:center"></i> Print</a>

<?php    } ?>
    

    <div class="box-body" id="box_data" style="display: flex;padding: 5px 10px 0 10px;margin-bottom: -21px;">
        <div style="width: 100%;padding-right: 10px;" class="col-md-12">

            <div class="row">
                <div class="col-lg-4" style="width: 70%;padding-left: 20px;">
                    <h5 style="font-size: 20px;margin-bottom: 5px;">  <?php echo $nama;?></h5>
                     <p style="font-size: 12px;margin: 0;padding: 0;"><?php echo $notelp;?>,<small><?php echo $alamat;?></small></p>
                </div>
                <div class="col-lg-8" style="width: 30%;">
                    <h5 style="font-size: 20px;margin-bottom: 15px;">TANDA TERIMA</h5>

                    <h5 style="font-size: 12px;margin: 0;padding: 0;"><b>Nama Kasir: <?php echo $kasir;?></b></h5>

                    <p style="font-size: 12px;margin: 0;padding-top: 3px;;">Nomor Faktur: <?php echo $nomor;?></p>

                    <p style="font-size: 12px;margin: 0;padding-top: 5px;;">Tanggal Faktur: <?php echo date('d-m-Y',strtotime($tgl));?></p>

                    <br>
                </div>
            </div>
            <div class="" style="display: flex;margin-top: -62px;">

            <table style="width:60%">
                <tr class="" style="background: rgba(217,225,242,1.0);border-top: 1px dashed">
                    <td style="font-size: 12px;" colspan="2"  class="db text-left" width="100px" style="background: rgba(217,225,242,1.0)">
                       Telah terima dari:
                    </td>
                      
                   
                </tr>
                <tr class="" style="background: rgba(217,225,242,1.0);border-bottom: 1px dashed;">
                  
                    <td  colspan="2" style="font-size: 14px;"><?php echo $customer;?> </td>
                        
                    </td>
                   
                </tr>
            </table>
            </div>
            <br>

            <table width="100%" border="0">
               
                <tr>
                    <th style="width: 80%;font-size: 12px;background: rgba(217,225,242,1.0)">Nomor Faktur Transaksi:#<?php echo $nomor;?></th>
                    <th></th>
                </tr>
              
               </table>
            
            <table width="100%" border="1px">
                <tr style="background: rgba(217,225,242,1.0);border-bottom: 1px solid;">
                    <th class="text-center" style="width:5%">
                        #
                    </th>
                    <th class="text-center" colspan="3">
                        Keterangan
                    </th>
                    <th class="text-center" style="width:12%">
                        Tanggal
                    </th>
                   
                    <th class="text-center" style="width:12%">
                        Sejumlah
                    </th>
                </tr>
                <tbody>

                    <?php
                    $sql1a=mysqli_query($conn,"SELECT * FROM sale_payment WHERE nota='$nota' ORDER BY no DESC LIMIT $offset,$numrow");
                    $num = ($i) * $numrow + 1;
                  while($rowa=mysqli_fetch_assoc($sql1a)){

            
                    ?>

                <tr>
                    <td><?php echo $num++;?></td>
                    <td colspan="3"><?php echo $rowa['keterangan'];?></td>
                    
                    <td style="text-align:center"><?php echo date('d-m-Y',strtotime($rowa['tanggal']));?></td>
                    <td style="text-align:right"><?php echo number_format($rowa['jumlah'], $decimal, $a_decimal, $thousand);?></td>
                </tr>

            <?php } ?>
             

             <?php if($i==$lastpage){
                    for ($a = 1; $a < $filler; $a++){
                ?>
             <tr><td>&nbsp;</td><td colspan="3">&nbsp;</td><td style="text-align:center">&nbsp;</td><td style="text-align:right">&nbsp;</td></tr>
             <?php } } ?>


                </tbody>
                <tfoot>

    <?php if($i==$lastpage){?>

                <tr style="background: rgba(217,225,242,1.0);">
                
                   
                    <td colspan="4"></td>
                    <td>Total</td>
                    <td colspan="1" style="text-align:right"><b><?php echo number_format($subayar, $decimal, $a_decimal, $thousand);?></b></td>
                </tr>
                <tr >
                    <td colspan="3" rowspan="4">
                        
                        <table>
                            <tr>
                                <td style="width:30%;font-size: 12px;">Total Tagihan</td>
                                <td colspan="2" style="font-size: 12px">Rp <?php echo number_format($total, $decimal, $a_decimal, $thousand);?></td>
                            </tr>
                            <tr>
                                 <td style="width:30%;font-size: 12px;">Sudah Dibayar</td>
                                <td style="font-size: 12px">Rp <?php echo number_format($subayar, $decimal, $a_decimal, $thousand);?></td>
                            </tr>
                            <tr>
                                 <td style="width:30%;font-size: 12px;">Sisa Hutang</td>
                                <td style="font-size: 12px">Rp <?php echo number_format(($total-$subayar), $decimal, $a_decimal, $thousand);?></td>
                            </tr>

                        </table>


                    </td>
                     <td>Status</td>
                   
                    <td colspan="2"><b><?php echo $status;?></b></td>
                   
                </tr>

                <tr style="border-top:none">
                    
                     <td>Jatuh Tempo</td>
                   
                    <td colspan="2"><b><?php echo date('d-m-Y',strtotime($due));?></b></td>
                </tr>


                <tr style="border-top:none">
                  
                   
                    <td rowspan="2" colspan="3"><b>112233</b></td>
                </tr>
                <tr style="border-top:none">
                            
                   
                   
                </tr>
                </tfoot>
<?php } else {?>

   <tr style="background: rgba(217,225,242,1.0);">
                    
                    <td colspan="7" style="text-align:center"><b>HALAMAN NOMOR <?php echo $nohal;?> dari <?php echo $numofpage;?>. TOTAL ADA DI HALAMAN TERAKHIR</b></td>
                    
                   
                </tr>
                 <tr >
                    <td colspan="3" rowspan="4">
                        
                        <table>
                            <tr>
                                <td style="width:30%;font-size: 12px;">Total Tagihan</td>
                                <td colspan="2" style="font-size: 12px">Rp <?php echo number_format($total, $decimal, $a_decimal, $thousand);?></td>
                            </tr>
                            <tr>
                                 <td style="width:30%;font-size: 12px;">Sudah Dibayar</td>
                                <td style="font-size: 12px">Rp <?php echo number_format($subayar, $decimal, $a_decimal, $thousand);?></td>
                            </tr>
                            <tr>
                                 <td style="width:30%;font-size: 12px;">Sisa Hutang</td>
                                <td style="font-size: 12px">Rp <?php echo number_format(($total-$subayar), $decimal, $a_decimal, $thousand);?></td>
                            </tr>

                        </table>


                    </td>
                     <td>Status</td>
                   
                    <td colspan="2"><b><?php echo $status;?></b></td>
                   
                </tr>

                <tr style="border-top:none">
                    
                     <td>Jatuh Tempo</td>
                   
                    <td colspan="2"><b><?php echo date('d-m-Y',strtotime($due));?></b></td>
                </tr>


                <tr style="border-top:none">
                  
                   
                    <td rowspan="2" colspan="3"><b>112233</b></td>
                </tr>
                </tfoot>


<?php } ?>


            </table>
            <br>


            <table width="94%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="5%" rowspan="3" valign="top"><strong class="asd"> &nbsp;<br></strong></td>


                    <td width="40%" align="center" valign="top">

                        <h6 style="margin-bottom: 5px;">Tanda Terima ini merupakan bukti Pembayaran yang sah</h6>
                       
                    </td>



                    <td width="16%" valign="top"><h6 style="margin-bottom: 0;">
                        <span style="text-decoration: dashed; padding-left: 100%;color: #000; border-bottom: 1px solid black;"></span>
                    </h6>
                        <h6 class="text-center"
                        style="margin-top: 5px;">Penerima</h6></td>




                         <td width="3%" valign="top"><h6 style="margin-bottom: 0;">
                        </td>




                         <td width="16%" valign="top"><h6 style="margin-bottom: 0;">
                        <span style="text-decoration: dashed; padding-left: 100%;color: #000; border-bottom: 1px solid black;"></span>
                    </h6>
                        <h6 class="text-center"
                        style="margin-top: 5px;">Penyetor</h6></td>
                </tr>

            </table>



        </div>

    </div>

   

</section>





<?php



if( $i % 2 != 0) {
echo '<footer></footer>';
}




 } ?>





</body>
</html>
