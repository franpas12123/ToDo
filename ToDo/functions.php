<?php

	// this php contains the functions used in other php files.

	// the function that checks if the email used in registering already exists
	function email_exists($email, $con) {
		$result = mysqli_query($con, "SELECT id FROM students WHERE email = '$email'");

		if(mysqli_num_rows($result) == 1) {
			return true;
		} else {
			return false;
		} // end of mysqli_num_rows condition
	} // end of email_exists function

	// the function that checks if the user is logged in
	function logged_in() {

		if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
			return true;
		} else {
			return false;
		}

	}

?>