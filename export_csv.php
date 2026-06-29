<?php
// Load file koneksi.php
include "configuration/config_connect.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('IDwares')
					   ->setLastModifiedBy('Indotory Pro Plus')
					   ->setTitle("Data Barang")
					   ->setSubject("Barang")
					   ->setDescription("Data Barang Hasil Export Csv")
					   ->setKeywords("Data Barang");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); // Set kolom A1 dengan tulisan "NO"
$csv->setActiveSheetIndex(0)->setCellValue('B1', "SKU"); // Set kolom B1 dengan tulisan "NIS"
$csv->setActiveSheetIndex(0)->setCellValue('C1', "NAMA"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Harga Beli"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
$csv->setActiveSheetIndex(0)->setCellValue('E1', "Harga Jual"); // Set kolom E1 dengan tulisan "TELEPON"
$csv->setActiveSheetIndex(0)->setCellValue('F1', "satuan"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Kategori"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('H1', "brand"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('I1', "ukuran"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('J1', "warna"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('K1', "Expired"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('L1', "lokasi"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('M1', "stok minimal"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('N1', "Sisa"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('O1', "terbeli"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('P1', "terjual"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('Q1', "barcode"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('R1', "keterangan"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('S1', "Supplier"); // Set kolom F1 dengan tulisan "ALAMAT"
// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($conn, "SELECT * FROM barang");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
	$csv->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
	$csv->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['sku']);
	$csv->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama']);
	$csv->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['hargabeli']);
	$csv->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['hargajual']);
	$csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['satuan']);
	$csv->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['kategori']);
	$csv->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['brand']);
	$csv->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['ukuran']);
	$csv->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['warna']);
	$csv->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['expired']);
		$csv->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['lokasi']);
			$csv->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['stokmin']);
	
	// Khusus untuk no telepon. kita set type kolom nya jadi STRING
	$csv->setActiveSheetIndex(0)->setCellValueExplicit('N'.$numrow, $data['sisa'], PHPExcel_Cell_DataType::TYPE_STRING);
		$csv->setActiveSheetIndex(0)->setCellValueExplicit('O'.$numrow, $data['terbeli'], PHPExcel_Cell_DataType::TYPE_STRING);
		$csv->setActiveSheetIndex(0)->setCellValueExplicit('P'.$numrow, $data['terjual'], PHPExcel_Cell_DataType::TYPE_STRING);
	$csv->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data['barcode']);
	$csv->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['keterangan']);
	$csv->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['supplier']);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("Laporan Data Barang");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Barang.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
?>
