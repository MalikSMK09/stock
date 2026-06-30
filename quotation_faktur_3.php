
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require_once __DIR__ . '/libs/FakturBootstrap.php';
fakturSecureInit();
global $conn, $nota, $tipe, $tabel, $tabeldatabase, $judul;

$halaman = "faktur_one";
$dataapa = "Faktur";

$header = fakturApplyHeader($tipe, fakturLoadHeader($conn, $tipe, $nota));
extract($header);

$forward = mysqli_real_escape_string($conn, $tabeldatabase);
$forwardpage = mysqli_real_escape_string($conn, $halaman);

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

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		 <title> <?php echo $judul;?></title>
		  <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
		  	<link rel="stylesheet" href="dist/ico/font-awesome/css/font-awesome.min.css">
		<!-- Invoice styling -->
			<link rel="stylesheet" href="libs/faktur/three/style.css"  />
	</head>



<style>
@media print {
  #printPageButton {
    display: none;
  }
}
</style>

	<body>
		
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="4">
						<table>
							<tr>
								<td class="title">
			<img src="<?php echo $avatar;?>" alt="<?php echo $nama;?>" style="width: 100%; max-width: 90px;height:90px;" />
								</td>

								<td>
									<?php echo $judul;?> <?php echo $nota;?><br />
									Tanggal <?php echo date('d-m-Y',strtotime($tgl));?><br />
								
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td style="max-width: 60px">
									  <?php echo $nama;?><br />
									
									<?php echo $notelp;?>
								</td>

								<td style="max-width: 60px">
									<?php echo $customer;?><br />
									<?php echo $address;?><br />
									<?php echo $nohp;?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				

				

				<tr class="heading">
					
					<td style="text-align:left">PRODUK</td>
					<td>Harga Satuan</td>
					<td style="text-align:center">Jumlah</td>
					<td style="text-align:right">Subtotal</td>
				</tr>

<?php
 $itemRows = fakturLoadItems($conn, $tabeldatabase, $nota, 0, 1000);
 $no_urut=0;
 foreach ($itemRows as $fill){
?>
				<tr class="item">
					
					
					<td style="text-align:left"><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
					<td><?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
					<td style="text-align:center"><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
					<td style="text-align:right"><?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
				</tr>
<?php } ?>
		

				
				<tr class="total">
					<td></td>
					<td style="text-align:right">Diskon <?php echo $diskon;?>%:</td>
					
					<td colspan="2" style="text-align:right"><?php echo number_format($pot, $decimal, $a_decimal, $thousand).',-';?></td>			
				</tr>

				<tr class="total">
					<td></td>
					<td style="text-align:right">Biaya Tambahan:</td>
					
					<td colspan="2" style="text-align:right"><?php echo number_format($biaya, $decimal, $a_decimal, $thousand).',-';?></td>			
				</tr>

				<tr class="total">

					<?php if($tipe=='quotation'){?>

							<td><b>Berlaku sampai <?php echo date('d-m-Y',strtotime($due));?></b></td>

					<?php } else {?>

					 <?php if ($status=='sudah'){?>
		
					<td><b>LUNAS</b></td>
				<?php } else {?>
					<td>Pembayaran</td>
				<?php } ?>

			<?php } ?>
					
					<td style="text-align:right"><b>Grand Total:</b></td>
									
					<td colspan="2" style="text-align:right"><b>Rp <?php echo number_format($total, $decimal, $a_decimal, $thousand).',-';?></b></td>
				</tr>

<?php if($tipe=='quotation'){?>

	<tr>
		<td colspan="3"><p  style="max-width:40%;word-wrap: break-word"><small><?php echo $keterangan;?></small></p></td>
	</tr>

<?php } else {?>
				 <?php if ($status!='sudah'){?>

				 <?php foreach (fakturLoadRekeningAll($conn) as $fill) { ?>

				<tr class="item">
					
					<td><strong><?php echo $fill['bank'];?>:</strong>  <?php echo $fill['norek'];?> A.n <?php echo $fill['nama'];?></td>
					
				</tr>
<?php } ?>



<?php } ?>
<?php } ?>



				
			</table>
<button id="printPageButton" class="btn btn-lg bg-maroon" onClick="window.print()"><i class="fa fa-print"></i> Print</button>			
		</div>
		

	</body>
</html>

