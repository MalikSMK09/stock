<?php
$servername = "localhost";
$username = "root";
$password= "";
$dbname="proplus";

global $conn;
	$link = mysqli_connect($servername, $username, $password,$dbname);
	// Check connection
	if (!$link) {
		die("Connection failed: " . mysqli_connect_error());
	}

$query = mysqli_query($link, "SHOW TABLES IN $dbname");
while ($row = mysqli_fetch_array($query)) {
    echo $row[0]." ";
    mysqli_query($link, "DROP TABLE ".$row[0]." ");
    echo "Deleted <br>";
}

?>