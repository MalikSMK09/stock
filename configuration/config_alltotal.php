<?php


include 'config_connect.php';
date_default_timezone_set("Asia/Jakarta");
$harisekarang=date('d');
$bulansekarang=date('m');

$tahunsekarang=date('Y');
$now=date('Y-m-d');
$bulanlalu = date('m',strtotime("-1 month"));
$tahunlalu = date('Y',strtotime("-1 year"));
$today = date('d-m-Y : H:i');

// Total Data1

$sqlx2="SELECT COUNT(userna_me) as data FROM user";
$hasilx2=mysqli_query($conn,$sqlx2);
$row=mysqli_fetch_assoc($hasilx2);
$datax1=$row['data'];

// Total Data2

$sqlx2="SELECT COUNT(kode) as data FROM supplier";
$hasilx2=mysqli_query($conn,$sqlx2);
$row=mysqli_fetch_assoc($hasilx2);
$datax2=$row['data'];

// Total Data3

$sqlx2="SELECT COUNT(kode) as data FROM barang";
$hasilx2=mysqli_query($conn,$sqlx2);
$row=mysqli_fetch_assoc($hasilx2);
$datax3=$row['data'];

// Total Data4

 

$sqlx2="SELECT COUNT(kode) as data FROM barang where sisa <= stokmin ";
$hasilx2=mysqli_query($conn,$sqlx2);
$row=mysqli_fetch_assoc($hasilx2);
$datax4=$row['data'];


  
// Data Stok

$sqlx2="SELECT SUM(sisa) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $stok1=$row['data'];

$sqlx2="SELECT SUM(terjual) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $stok2=$row['data'];

$sqlx2="SELECT SUM(terbeli) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $stok3=$row['data'];

$sqlx2="SELECT COUNT(kode) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $stok4=$row['data'];



  $sqlx2="SELECT SUM(sisa*hargabeli) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $val1=$row['data'];

$sqlx2="SELECT SUM(sisa*hargajual) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $val2=$row['data'];

$val3=$val2-$val1;

$sqlx2="SELECT SUM(terjual*hargajual) AS data FROM barang ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $val4=$row['data'];


$sqlx2="SELECT SUM(total) AS data, SUM(biaya) as cost FROM buy ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv11=$row['data']+$row['cost'];

$sqlx2="SELECT SUM(total) AS data, SUM(biaya) as cost FROM buy WHERE status LIKE '%dibayar%' OR status LIKE '%diterima%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv12=$row['data']+$row['cost'];

$sqlx2="SELECT SUM(total) AS data,SUM(biaya) as cost FROM buy WHERE status LIKE '%belum%' OR status LIKE '%hutang%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv13=$row['data']+$row['cost'];

$sqlx2="SELECT SUM(total) AS data,SUM(biaya) as cost FROM buy WHERE NOW() <= tglsale  AND status LIKE '%belum%' OR status LIKE '%hutang%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv14=$row['data']+$row['cost'];

 $inv15 = $inv13 - $inv14;

  
// Total Data1-------------------------------------------------------------------

  $sqlx2="SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data11=$row['data'];

  // Total Data2

  $sqlx2="SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%dibayar%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data21=$row['data'];

  // Total Data3

  $sqlx2="SELECT COUNT(nota) as data FROM buy WHERE status LIKE '%hutang%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data31=$row['data'];

  // Total Data4

  $sqlx2="SELECT COUNT(nota) as data FROM buy WHERE diterima!=''";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data41=$row['data'];

   // Total Data1 ------------------------------------------------------------------

  $sqlx2="SELECT COUNT(nota) as data FROM bayar WHERE nota NOT IN (SELECT nota FROM transaksimasuk)";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data1=$row['data'];

  // Total Data2

  $sqlx2="SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data2=$row['data'];

  // Total Data3

  $sqlx2="SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data3=$row['data'];

  // Total Data4

  $sqlx2="SELECT COUNT(nota) as data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data4=$row['data'];

  // Total Data1-------------------------------------------------------------------

  $sqlx2="SELECT SUM(biaya) AS data FROM operasional";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data14=$row['data'];

  // Total Data2

  $sqlx2="SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data24=$row['data'];

  // Total Data3

  $sqlx2="SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-$bulansekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data34=$row['data'];

  // Total Data4

  $sqlx2="SELECT SUM(biaya) AS data FROM operasional WHERE tanggal LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data44=$row['data'];

  // Total Data1-------------------------------------------------------------------

  $sqlx2="SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data12=$row['data'];

  // Total Data2

  $sqlx2="SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data22=$row['data'];

  // Total Data3

  $sqlx2="SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data32=$row['data'];

  // Total Data4

  $sqlx2="SELECT SUM(total) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data42=$row['data'];
// Total Data1-------------------------------------------------------------------

  $sqlx2="SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk)";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data13=$row['data'];

  // Total Data2

  $sqlx2="SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data23=$row['data'];

  // Total Data3

  $sqlx2="SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data33=$row['data'];

  // Total Data4

  $sqlx2="SELECT (SUM(total)-SUM(keluar)) AS data FROM bayar WHERE nota IN (SELECT nota FROM transaksimasuk) AND tglbayar LIKE '$tahunsekarang-$bulansekarang-$harisekarang'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $data43=$row['data'];

  // Invoice report


  $sqlx2="SELECT SUM(sudahbayar) AS data FROM sale";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv1=$row['data'];

  $sqlx2="SELECT SUM(total-sudahbayar) AS data FROM sale";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv2=$row['data'];


  $sqlx2="SELECT SUM(total) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv3=$row['data'];


  $sqlx2="SELECT SUM(total) AS data FROM sale WHERE tglsale LIKE '$tahunsekarang-$bulansekarang-$harisekarang' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $invx=$row['data'];
  $inv4 = $invx + 0;

  // Data Invoice

$sqlx2="SELECT SUM(total) AS data1 FROM sale ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv1a=$row['data1'];

$sqlx2="SELECT SUM(sudahbayar) AS data FROM sale";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv2a=$row['data'];

$sqlx2="SELECT SUM(total-sudahbayar) AS data FROM sale WHERE status LIKE '%belum%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv3a=$row['data'];

$sqlx2="SELECT SUM(total-sudahbayar) AS data FROM sale WHERE duedate <= '$now' AND status LIKE '%belum%'  ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $inv4a=$row['data'];




//Dashboard stat

  //Hutang

$noew=date('Y-m-d');
$day30=date('Y-m-d', strtotime($noew. ' + 29 days'));
$day60=date('Y-m-d', strtotime($noew. ' + 59 days'));
$day90=date('Y-m-d', strtotime($noew. ' + 89 days'));



  //  <0 days
  $sqlx2="SELECT SUM(total) AS databeli FROM buy WHERE tglsale < '$noew' AND status LIKE '%hutang%' OR status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $buynow=$row['databeli'] + 0;

//  <30 days
  $sqlx2="SELECT SUM(total) AS databeli FROM buy WHERE tglsale BETWEEN '" . $noew . "' AND  '" . $day30 . "' AND status LIKE '%hutang%' OR status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $buy30=$row['databeli'] + 0;

  //  30 to 60 days
   $sqlx2="SELECT SUM(total) AS databeli FROM buy WHERE tglsale BETWEEN '" . $day30 . "' AND  '" . $day60 . "' AND status LIKE '%hutang%' OR status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $buy3060=$row['databeli'] + 0;

  //  60 to 90 days
  $sqlx2="SELECT SUM(total) AS databeli FROM buy WHERE tglsale BETWEEN '" . $day60 . "' AND  '" . $day90 . "' AND status LIKE '%hutang%' OR status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $buy6090=$row['databeli'] + 0;

//  >90 days
  $sqlx2="SELECT SUM(total) AS databeli FROM buy WHERE tglsale > '$day90' AND  status LIKE '%hutang%' OR status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $buy90=$row['databeli'] + 0;
  

//piutang
//  <0 days
  $sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE duedate < '$noew' AND status LIKE '%belum%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $salenow=$row['datasale'] + 0;

//  <30 days
  $sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE duedate BETWEEN '" . $noew . "' AND  '" . $day30 . "' AND status LIKE '%belum%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $sale30=$row['datasale'] + 0;

//  30 to 60 days
  $sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE duedate BETWEEN '" . $day30 . "' AND  '" . $day60 . "' AND status LIKE '%belum%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $sale3060=$row['datasale'] + 0;

  //  30 to 60 days
  $sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE duedate BETWEEN '" . $day60 . "' AND  '" . $day90 . "' AND status LIKE '%belum%' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $sale6090=$row['datasale'] + 0;

  //  >90 days
   $sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE duedate > '$day90' AND status LIKE '%belum%'";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $sale90=$row['datasale'] + 0;

//retail 1

  $sqlx2="SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang'  ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $retahun=$row['retail'] + 0;

  $sqlx2="SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang' AND MONTH(tglbayar) = '$bulanlalu'  ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $rebulanlalu=$row['retail'] + 0;

   $sqlx2="SELECT SUM(total) AS retail FROM bayar WHERE YEAR(tglbayar) = '$tahunsekarang' AND MONTH(tglbayar) = '$bulansekarang'  ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $rebulan=$row['retail'] + 0;

$sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $saleyear=$row['datasale'] + 0;


$sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' AND MONTH(duedate) = '$bulanlalu' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $salelastmonth=$row['datasale'] + 0;


$sqlx2="SELECT SUM(total) AS datasale FROM sale WHERE status LIKE '%dibayar%' AND YEAR(duedate) = '$tahunsekarang' AND MONTH(duedate) = '$bulansekarang' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $salemonth=$row['datasale'] + 0;



$sqlx2="SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' AND MONTH(tanggal) = '$bulansekarang' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $opmonth=$row['operasi'] + 0;



$sqlx2="SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' AND MONTH(tanggal) = '$bulanlalu' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $oplastm=$row['operasi'] + 0;

  $sqlx2="SELECT SUM(biaya) AS operasi FROM operasional WHERE YEAR(tanggal) = '$tahunsekarang' ";
  $hasilx2=mysqli_query($conn,$sqlx2);
  $row=mysqli_fetch_assoc($hasilx2);
  $opyear=$row['operasi'] + 0;

$sum1 = $rebulan+$salemonth - $opmonth;
$sum2 =  $rebulanlalu+$salelastmonth - $oplastm;
$sum3 =  $retahun+$saleyear - $opyear;

$sqle="SELECT COUNT(nota) as aktife FROM quotation WHERE status='aktif'";
$hasile1=mysqli_query($conn,$sqle);
$row=mysqli_fetch_assoc($hasile1);
$qaktif=$row['aktife'];

$sqle1="SELECT COUNT(nota) as suc FROM quotation WHERE status='berhasil'";
$hasile2=mysqli_query($conn,$sqle1);
$row=mysqli_fetch_assoc($hasile2);
$qsuc=$row['suc'];

$sqle2="SELECT COUNT(nota) as non FROM quotation WHERE status='nonaktif'";
$hasile3=mysqli_query($conn,$sqle2);
$row=mysqli_fetch_assoc($hasile3);
$qnon=$row['non'];

$sqle3="SELECT COUNT(nota) as exp FROM quotation WHERE status='aktif' AND due<='$now'";
$hasile4=mysqli_query($conn,$sqle3);
$row=mysqli_fetch_assoc($hasile4);
$qexp=$row['exp'];
?>

