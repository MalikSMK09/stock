<?php

error_reporting(E_ALL ^ E_DEPRECATED);
$servername = "localhost";
$username = "setyajay_user";
$password= "enter4j4ya#";
$dbname="setyajay_stock";

      $koneksi = mysqli_connect($servername, $username, $password);
        $db = mysqli_select_db($koneksi ,$dbname);

	// Create connection
	global $conn;
	mysqli_query($conn,"SET session sql_mode = ''");	
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
