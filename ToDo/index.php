<?php

	// this php contains the registration page

	// don't forget to include these php for the session to continue and get the available sessions
	include("connect.php");
	include("functions.php");

	// if the user is already logged in, he must be on the profile page only and always
	if(logged_in()) {
		header("location: subjects.php");
		exit();
	}

	$error = "";

	// checking if the submission is available, getting all data inputted in upon registering
	if (isset($_POST['submit'])) {
		$firstName = mysqli_real_escape_string($con, $_POST['fname']);
		$lastName = mysqli_real_escape_string($con, $_POST['lname']);
		$email = mysqli_real_escape_string($con, $_POST['email']);
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];
		$image = $_FILES['image']['name'];
		$tmp_image = $_FILES['image']['tmp_name'];
		$imageSize = $_FILES['image']['size'];

		$condition = isset($_POST['conditions']);

		// checking the validity of every data inputted in
		if(strlen($firstName) < 3) {
			$error = "First name is too short";
		} else if(strlen($lastName) < 3) {
			$error = "Last name is too short";
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "Please enter valid email address";
		} else if (email_exists($email, $con)) {
			$error = "Email already exists";
		} else if (strlen($password) < 8) {
			$error = "Password must be greater than 8 characters";
		} else if ($password !== $passwordConfirm) {
			$error = "Password does not match";
		} else if ($image == "") {
			$error = "Please upload your image";
		} else if ($imageSize > 1048576) {
			$error = "Image size must be less than 1mb";
		} else if (!$condition) {
			$error = "You must agree with terms and conditions";
		} else {
			
			$password = md5($password);
			
			$imageExt = explode(".", $image);
			$imageExtension = $imageExt[1];
			
			if ($imageExtension == 'PNG' || $imageExtension == 'png' || $imageExtension == 'JPG' || $imageExtension == 'jpg') {

				$image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;

				$insertQuery = "INSERT INTO  students(firstName, lastName, email, password, image) VALUES ('$firstName', '$lastName', '$email', '$password', '$image')";

				if(mysqli_query($con, $insertQuery)) {
					if(move_uploaded_file($tmp_image, "images/$image")) {
						$error = "You are successfully registered";
					} else {
						$error = "Images is not uploaded";
					}
				} // end of mysqli_query IF-statement
			} // end of imageExtension IF-statement
			else {
				$error = "File must be an image";
			} // end of else-statement between imageExtension condition

		} // end of else-statement between strlen firstname condition

	} // end of isset IF-statement


?>

<!DOCTYPE html>

<html>

<head>

	<title>Registration Page</title>
	<link rel="stylesheet" href="css/style2.css"/>

</head>

<body>

	<div id="error" style="<?php if($error != "") {
	?> display: block; <?php } ?>">
		<?php echo $error; ?>
	</div>

	<div id="wrapper">

		<div id = "menu">
			<a href="index.php">Sign Up</a>
			<a href="login.php">Login</a>
		</div>

		<div id="register" class="formDiv">

			<form method="POST" action="index.php" enctype="multipart/form-data" autocomplete="on">
				
				<!-- First Name -->
				<div class="floating-inputs">
					<!-- <label>First Name:</label><br/> -->
					<img class="icons top" src="resources/universal-icons/png/user.png" alt="">
					<input type="text" name="fname" placeholder="First name" class="inputFields top" required/><!-- <br/><br/> -->
				</div>
				
				<!-- Last Name -->
				<div class="floating-inputs">
					<!-- <label>Last Name:</label><br/> -->
					<img class="icons" src="resources/universal-icons/png/user.png" alt="">
					<input type="text" name="lname" placeholder="Last name" class="inputFields" required/><!-- <br/><br/> -->
				</div>
				
				<!-- Email -->
				<div class="floating-inputs">
					<!-- <label>Email:</label><br/> -->
					<img class="icons" src="resources/universal-icons/png/envelope.png" alt="">
					<input type="text" name="email" placeholder="Email" id="email" class="inputFields" required/><!-- <br/><br/> -->
				</div>
				
				<!-- Password -->
				<div class="floating-inputs">
					<!-- <label>Password:</label><br/> -->
					<img class="icons" src="resources/universal-icons/png/padlock.png" alt="">
					<input type="password" name="password" placeholder="Password" class="inputFields" required/><!-- <br/><br/> -->
				</div>
				
				<!-- Re-enter Password -->
				<div class="floating-inputs">
					<!-- <label>Re-enter Password:</label><br/> -->
					<img class="icons" src="resources/universal-icons/png/padlock.png" alt="">
					<input type="password" name="passwordConfirm" placeholder="Re-type password" class="inputFields" required/><!-- <br/><br/> -->
				</div>
				
				<!-- Profile Picture -->
				<div class="floating-inputs">
					<!-- <label>Image:</label><br/> -->
					<p id="profpic">Profile Picture</p>
					<img class="icons" src="resources/universal-icons/png/folder.png" alt="">
					<input type="file" name="image" class="inputFields" id="imageUpload" /><!-- <br/><br/> -->
				</div>
				
				<!-- Terms and Condition -->
				<div>
					<input type="checkbox" name="conditions"/>
					<label>I agree with terms and conditions</label><br/><br/>
				</div>
				
				<input type="submit" class="theButtons" name="submit"/>

			</form>

		</div>

	</div>

</body>

</html>