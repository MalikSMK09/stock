<?php
/*
-- Source Code from My Notes Code (www.mynotescode.com)
--
-- Follow Us on Social Media
-- Facebook : http://facebook.com/mynotescode
-- Twitter  : http://twitter.com/mynotescode
-- Google+  : http://plus.google.com/118319575543333993544
--
-- Terimakasih telah mengunjungi blog kami.
-- Jangan lupa untuk Like dan Share catatan-catatan yang ada di blog kami.
*/

// Load file koneksi.php
include "configuration/config_connect.php";





if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	// Load librari PHPExcel nya
	require_once 'PHPExcel/PHPExcel.php';

	$inputFileType = 'CSV';
	$inputFileName = 'tmp/data.csv';

	$reader = PHPExcel_IOFactory::createReader($inputFileType);
	$excel = $reader->load($inputFileName);

	$numrow = 1;
	$worksheet = $excel->getActiveSheet();
	foreach ($worksheet->getRowIterator() as $row) {
		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
			// START -->
			// Skrip untuk mengambil value nya
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

			$get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
			foreach ($cellIterator as $cell) {
				array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
			}
			// <-- END

			// Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
							   $no = $get[0]; // Ambil data kode
                             $kode = sprintf("%06s", $no);
                            $sku = $get[1]; // Ambil data nama
                            $nama = $get[2]; // Ambil data hbeli
                            $hbeli = $get[3]; // Ambil data hjual
                            $hjual = $get[4]; // Ambil data alamat
                            $satuan = $get[5]; // Ambil data alamat
                            $kategori = $get[6]; // Ambil data NIS
                            $brand = $get[7]; // Ambil data nama
                            $ukuran = $get[8]; // Ambil data jenis kelamin
                            $warna = $get[9]; // Ambil data telepon
                           
                            $exp = $get[10]; // Ambil data NIS
                            $lokasi= $get[11]; // Ambil data nama
                           
                            $stokmin = $get[12];
                             $sisa = $get[13];
                              $terbeli = $get[14];
                               $terjual = $get[15];
                                $barcode = $get[16];
                                 $keterangan = $get[17];
                                  $sup = $get[18];
                            $avatar = "dist/upload/index.jpg"; // Ambil data jenis kelamin
                            $retur=0;
                           
			// Cek jika semua data tidak diisi
							if($kode == "" && $nama == "" && $hbeli == "" && $hjual == "" && $no == "" && $avatar == "")
								continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

			// Tambahkan value yang akan di insert ke variabel $query
			// Buat query Insert
			mysqli_query($conn,"SET session sql_mode = ''");	$query = "INSERT INTO barang VALUES('".$no."','".$kode."','".$sku."','".$nama."','".$kategori."','".$brand."','".$barcode."','".$hbeli."','".$hjual."','".$terjual."','".$terbeli."','".$sisa."','".$retur."','".$stokmin."','".$ukuran."','".$warna."','".$exp."','".$satuan."','".$lokasi."','".$keterangan."','".$sup."','".$avatar."')";
			mysqli_query($conn, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

header('location: impor.php'); // Redirect ke halaman awal
?>
