<?php

error_reporting(E_ALL ^ E_DEPRECATED);
$servername = getenv('POS_DB_HOST') ?: "localhost";
$username = "setyajay_user";
$password= "enter4j4ya#";
$dbname="setyajay_stock";

	// Create connection
	global $conn;
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	mysqli_query($conn,"SET session sql_mode = ''");	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
