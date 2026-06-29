<?php
if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	// Load librari PHPExcel nya
	

	  $nama_file = $_FILES['file']['name']; // Ambil nama file yang akan diupload
      $path = $_FILES['file']['tmp_name'];
       $ext = pathinfo($nama_file, PATHINFO_EXTENSION); // Ambil ekstensi file yang akan diupload
       $handle = fopen($_FILES["file"]["tmp_name"], 'r');

echo $nama_file;
echo $path;
echo $ext;
echo $handle;

   }