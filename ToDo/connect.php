<?php  

	// this php contains the method in connecting to the database

	$con = mysqli_connect("localhost", "root", "", "testing");

	if (mysqli_connect_errno()) {
		echo "Error occured while connecting with database".mysqli_connect_errno();
	} else {
		# code...
	}

	$db = new PDO('mysql:dbname=testing;host=localhost', 'root', '');

	if(!isset($_SESSION)) {
		session_start();
	}
	
?>