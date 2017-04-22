<?php

	// this php contains the methods in the login page

	// don't forget to include these php for the session to continue and get the available sessions
	include("connect.php");
	include("functions.php");

	// again, if the user is already logged in, he must not go anywhere but in the profile page
	if(logged_in()) {
		header("location: subjects.php");
		exit();
	}

	$error = "";

	// checking for the availability of submit
	if(isset($_POST['submit'])) {

		$email = mysqli_real_escape_string($con, $_POST['email']);
		$password = mysqli_real_escape_string($con, $_POST['password']);
		$checkbox = isset($_POST['keep']);

		// checking the validity of email upon logging in
		if(email_exists($email, $con)) {

			$result = mysqli_query($con, "SELECT password FROM students WHERE email='$email'");
			$retrievepassword = mysqli_fetch_assoc($result);

			// checks for the validity of the password
			if(md5($password) !== $retrievepassword['password']) {
				$error = "Password is incorrect";
			} else {
				$_SESSION['email'] = $email;

				$fnameresult = mysqli_query($con, "SELECT firstName FROM students WHERE email='$email'");
				$fname = mysqli_fetch_assoc($fnameresult);

				$lnameresult = mysqli_query($con, "SELECT lastName FROM students WHERE email='$email'");
				$lname = mysqli_fetch_assoc($lnameresult);

				$_SESSION['fname'] = $fname['firstName'];
				$_SESSION['lname'] = $lname['lastName'];

				if ($checkbox == "on") {
					setcookie("email", $email, time()+3600);
				}
				header("location: subjects.php");
			} // end of password matching IF-ELSE statement

		} else { // if email does not exists
			$error = "Email does not exists";
		}

	} // end of isset IF-statement


?>

<!DOCTYPE html>

<html>

<head>

	<title>Login Page</title>
	<link rel="stylesheet" href="css/style2.css"/>

</head>

<body>

	<div id="error" style="<?php if($error != "") {
	?> display: block; <?php } ?>">
		<?php echo $error; ?>
	</div>

	<div id="wrapper">

		<div id = "menu">
			<a href="index.php" id="tologin">Sign Up</a>
			<a href="login.php" id="toregister">Login</a>
		</div>

		<div id="login" class="formDiv">

			<form method="POST" action="login.php">

			<!-- Email -->
			<div class="floating">
				<!-- <label>Email:</label><br/> -->
				<img class="icons top" src="resources/universal-icons/png/user.png" alt="">
				<input type="text" placeholder="Email" name="email" class="inputFields top" required/><!-- <br/><br/> -->
			</div>

			<!-- Password -->
			<div class="floating">
				<!-- <label>Password:</label><br/> -->
				<img class="icons" src="resources/universal-icons/png/padlock.png" alt="">
				<input type="password" placeholder="Password" name="password" class="inputFields" required/><!-- <br/><br/> -->
			</div>

			<!-- Keep me logged in -->
			<div class="floating left">
				<input type="checkbox" name="keep"/>
				<label>Keep me logged in</label><!-- <br/><br/> -->
			</div>

				<input type="submit" class="theButtons" name="submit" value="Login"/>

			</form>

		</div>

	</div>

</body>

</html>
