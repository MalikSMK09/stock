<?php


// Load file koneksi.php
include "configuration/config_connect.php";


function autoNum($conn,$table,$param){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT MAX($param) as max_id FROM $table ORDER BY $param";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = $id_max;
  $sort_num++;
  $new_code = sprintf("%04s", $sort_num);
  return $new_code;
 }

if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	// Load librari PHPExcel nya
			
			$nama_file_baru = 'data_pelanggan.csv';

        // Cek apakah terdapat file tsb pada folder tmp
                if(is_file('tmp/'.$nama_file_baru)) // Jika file tersebut ada
                    unlink('tmp/'.$nama_file_baru); // Hapus file tersebut

                $nama_file = $_FILES['file']['name']; // Ambil nama file yang akan diupload
                $tmp_file = $_FILES['file']['tmp_name'];
                $ext = pathinfo($nama_file, PATHINFO_EXTENSION); // Ambil ekstensi file yang akan diupload

   if($ext != "csv"){


   } else {

   	  // Upload file yang dipilih ke folder tmp
       move_uploaded_file($tmp_file, 'tmp/'.$nama_file_baru);


       require_once 'PHPExcel/PHPExcel.php';

	$inputFileType = 'CSV';
	$inputFileName = 'tmp/data_pelanggan.csv';

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
							  
                             $kode = autoNum($conn,'pelanggan','kode');
                           $nama = $get[1]; // Ambil data nama
                            $nohp = $get[2]; // Ambil data telp
                             $email = $get[3]; // Ambil data telp
                            $alamat = $get[4]; // Ambil data alamat
                            $tgl=date('Y-m-d');
                            $status="pelanggan";
                           
			// Cek jika semua data tidak diisi
							if($kode == "" && $nama == "" && $nohp == "" && $alamat == "")
								continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

			$cek=mysqli_query($conn,"select * from pelanggan where nama='$nama'");
			if(mysqli_num_rows($cek)>0){} else {
			mysqli_query($conn,"SET session sql_mode = ''");	$query = "INSERT INTO pelanggan VALUES('".$kode."','".$tgl."','".$nama."','".$alamat."','".$nohp."','".$email."','".$kode."','".$status."','')";
			mysqli_query($conn, $query);
		}


		}

		$numrow++; // Tambah 1 setiap kali looping
	}






}


} 
header('location: pelanggan.php'); // Redirect ke halaman awal


?>
