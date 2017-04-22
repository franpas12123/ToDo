<?php

	// this php contains the method in changing the password of the user if he wants to

	// don't forget to include these php for the session to continue and get the available sessions
	include("connect.php");
	include("functions.php");

	$error = "";

	// checking if the new password inputted is available
	if (isset($_POST['savepass'])) {
		$password = $_POST['password'];
		$confirmPassword = $_POST['passwordConfirm'];

		// checking the length of the new password and if it matches the confirming password
		if (strlen($password) < 8) {
			$error = "Password must be greater than 8 characters";
		} else if ($password !== $confirmPassword) {
			$error = "Password does not match";
		} else {
			$password = md5($password);
			$email = $_SESSION['email'];

			if (mysqli_query($con, "UPDATE students SET password = '$password' WHERE email = '$email'")) {
				$error = "Password changed, <a href='subjects.php'>click here</a> to go back to subjects";
			} // end of if-statement of query
		}

	} // end of 'savepass' if-else-statement


	// checking if the user is logged in before allowing him/her to change his/her password
	if(logged_in()) {

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Subjects</title>

		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/main2.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

	</head>
	<body>
		<div id="main" class="container">
			<div class="header1">
				<nav class="header-nav">
					<!-- <div id="profpic-area"> -->
						<a href="#" id="a-profpic"><img src="resources/garfield-cropped.jpg" id ="profpic" alt=""></a>
						<div class="namecontainer">
							<h1><?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?><h1>
						</div>
						<!-- put pof pic here. access pic from db -->
					<!-- </div> -->
					<div class="navright">
						<ul>
							<li class="navlist"><a class="navmenu" href="subjects.php">Subjects</a></li>
							<li class="navlist"><a class="navmenu" href="changepassword.php">Change Password</a></li>
							<li class="navlist"><a href="logout.php"><img id="logout" src="resources/power.png" alt="Log-Out"></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<?php echo $error; ?>
		<div class="changecontainer">
			<form method="POST" action="changepassword.php">

				<label>New Password:</label><br/>
				<input type="password" name="password"><br/><br/>

				<label>Re-enter Password:</label><br/>
				<input type="password" name="passwordConfirm"><br/><br/>

				<input type="submit" name="savepass" value="Save"><br/><br/>

			</form>
		</div>
	</body>
</html>
<?php
	} else {
		header("location: subjects.php");
	} // end of if-else-statement if logged in

?>
