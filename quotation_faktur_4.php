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
require_once __DIR__ . '/libs/FakturBootstrap.php';
fakturSecureInit();
global $conn, $nota, $tipe, $tabel, $tabeldatabase, $judul;

$halaman = "faktur_four";
$dataapa = "Faktur";

$header = fakturApplyHeader($tipe, fakturLoadHeader($conn, $tipe, $nota));
extract($header);

date_default_timezone_set("Asia/Jakarta");
$today = date('d-m-Y');
 
?>
<?php
        $decimal ="0";
        $a_decimal =",";
        $thousand =".";
        ?>
<?php
        $company = fakturLoadCompany($conn);
        $nama = $company['nama'] ?? '';
        $alamat = $company['alamat'] ?? '';
        $notelp = $company['notelp'] ?? '';
        $tagline = $company['tagline'] ?? '';
        $signature = $company['signature'] ?? '';
        $avatar = $company['avatar'] ?? '';

        $pelRow = fakturLoadPelanggan($conn, $pelanggan);
        $customer = $pelRow['nama'] ?? '';
        $nohp = $pelRow['nohp'] ?? '';
        $address = $pelRow['alamat'] ?? '';

$countitem = fakturCountItems($conn, $tabeldatabase, $nota);
$numofpage = max(1, (int) ceil($countitem / 9));
if ($countitem === 9) {
    $rowoflastpage = 9;
} else {
    $rowoflastpage = $countitem % 9;
}

$filler = 9 - $rowoflastpage;
$lastpage = $numofpage - 1;
        ?>











<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A5 landscape">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->



<?php

for ($i = 0; $i < $numofpage; $i++){
  $nohal=$i+1;  

  $limit =$nohal*9;
  $offset=$i*9;




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
                    <h5 style="font-size: 20px;margin-bottom: 15px;">FAKTUR PENJUALAN</h5>

                    <h5 style="font-size: 12px;margin: 0;padding: 0;"><b><?php echo date('d-m-Y',strtotime($tgl));?></b></h5>

                    <p style="font-size: 12px;margin: 0;padding-top: 3px;;">Kasir: <?php echo $kasir;?></p>

                    <p style="font-size: 12px;margin: 0;padding-top: 5px;;"><b>Halaman: <?php echo $nohal;?> dari <?php echo $numofpage;?></b></p>

                    <br>
                </div>
            </div>
            <div class="" style="display: flex;margin-top: -62px;">

            <table style="width:60%">
                <tr class="" style="background: rgba(217,225,242,1.0);border-top: 1px dashed">
                    <td style="font-size: 14px;"  class="db text-left" width="100px" style="background: rgba(217,225,242,1.0)">
                        KEPADA:<?php echo $customer;?> 
                    </td>
                      <td style="font-size: 12px;"></td>
                   
                </tr>
                <tr class="" style="background: rgba(217,225,242,1.0);border-bottom: 1px dashed;">
                  
                    <td style="font-size: 12px;"><?php echo $nohp;?></td>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            </div>
            <br>

            <table width="100%" border="0">
               
                <tr>
                    <th style="width: 80%;font-size: 12px;background: rgba(217,225,242,1.0)">Faktur:#<?php echo $nota;?></th>
                    <th></th>
                </tr>
              
               </table>
            
            <table width="100%" border="1px">
                <tr style="background: rgba(217,225,242,1.0);border-bottom: 1px solid;">
                    <th class="text-center" style="width:5%">
                        #
                    </th>
                    <th class="text-center" colspan="3">
                        Detail
                    </th>
                    <th class="text-center" style="width:12%">
                        Harga
                    </th>
                    <th class="text-center" style="width:10%">
                        Qty
                    </th>
                    <th class="text-center" style="width:12%">
                        Total
                    </th>
                </tr>
                <tbody>

                    <?php
                    $pageItems = fakturLoadItems($conn, $tabeldatabase, $nota, $i * 9, 9);
                    $num = ($i) * 9 + 1;
                  foreach ($pageItems as $rowa) {
                    ?>

                <tr>
                    <td><?php echo $num++;?></td>
                    <td colspan="3"><?php echo $rowa['nama'];?></td>
                    <td style="text-align:center"><?php echo number_format($rowa['harga']);?></td>
                    <td style="text-align:center"><?php echo $rowa['jumlah'];?></td>
                    <td style="text-align:right"><?php echo number_format($rowa['hargaakhir']);?></td>
                </tr>

            <?php } ?>
             

             <?php if($i==$lastpage){
                    for ($a = 1; $a < $filler; $a++){
                ?>
             <tr><td>&nbsp;</td><td colspan="3">&nbsp;</td><td style="text-align:center">&nbsp;</td><td style="text-align:center">&nbsp;</td><td style="text-align:right">&nbsp;</td></tr>
             <?php } } ?>


                </tbody>
                <tfoot>

    <?php if($i==$lastpage){?>

                <tr style="background: rgba(217,225,242,1.0);">
                    <td>&nbsp;</td>
                    
                    <td colspan="2">Diskon <?php echo $diskon;?>%</td>
                    <td><?php echo number_format($pot, $decimal, $a_decimal, $thousand).',-';?></td>
                    <td colspan="2">Jumlah</td>
                    <td colspan="1" style="text-align:right"><?php echo number_format(($pot+$total), $decimal, $a_decimal, $thousand).',-';?></td>
                </tr>
                <tr style="background: rgba(217,225,242,1.0);">
                    <td colspan="4">&nbsp;</td>
                    
                    <td colspan="2">Total (Rp)</td>
                    <td style="text-align:right"><b><?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></b></td>
                </tr>
                </tfoot>
<?php } else {?>

   <tr style="background: rgba(217,225,242,1.0);">
                    
                    <td colspan="7" style="text-align:center"><b>HALAMAN NOMOR <?php echo $nohal;?> dari <?php echo $numofpage;?></b></td>
                    
                   
                </tr>
                <tr style="background: rgba(217,225,242,1.0);">
                    <td colspan="7" style="text-align:center"><b>TOTAL ADA DI HALAMAN TERAKHIR (<?php echo $numofpage;?>)</b></td>
                </tr>
                </tfoot>


<?php } ?>


            </table>
            <br>


            <table width="94%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="5%" rowspan="3" valign="top"><strong class="asd"> &nbsp;<br></strong></td>


<?php if($status!='sudah'){?>
                    <td width="40%" align="center" valign="top">
<?php
$qws1 = fakturLoadRekeningAt($conn, 0);
$qws2 = fakturLoadRekeningAt($conn, 1);
?>


                        <h6 style="margin-bottom: 5px;"><b><?php echo $qws1['bank'];?> <?php echo $qws1['norek'];?> <?php echo $qws1['nama'];?></b></h6>
                        <h6 style="margin-top: 5px;"><b><?php echo $qws2['bank'];?> <?php echo $qws2['norek'];?> <?php echo $qws2['nama'];?></b></h6>

                    </td>
<?php } else { ?>
 <td width="40%" align="center" valign="top">
<h5 style="font-size: 30px">LUNAS</h5>
</td>

<?php } ?>


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
                        style="margin-top: 5px;">Mengetahui</h6></td>
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
