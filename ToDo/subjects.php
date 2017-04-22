<?php

	include("connect.php");
	include("functions.php");

	// if the user is logged in, must load the profile page
	if (logged_in()) {
		//echo "You are logged in";

		$itemsQuery = $db->prepare("SELECT id, courseName FROM subjects WHERE user = :user");

		$itemsQuery->execute([
			'user' => $_SESSION['email']
		]);

		$items = $itemsQuery->rowCount() ? $itemsQuery : [];
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
		<div class="list">
			<h1 class="header">My Courses.</h1>

			<?php if(!empty($items)): ?>

			<ul class="items">
				<?php foreach($items as $item): ?>
					<li>
						<span><?php echo $item['courseName']; ?></span>
							<a href="profile.php?as=done&item=<?php echo $item['courseName']; ?>" class="done-button">View Assignments</a>
							<a href="delete_subject.php?as=done&item=<?php echo $item['id']; ?>" class="del-button">Delete</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php else: ?>
				<p>You haven't added any subjects yet.</p>
			<?php endif;?>

			<form class="item-add" action="add_subject.php" method="POST">
				<input type="text" name="courseName" placeholder="Type a new subject here." class="input" autocomplete="off" required>
				<input type="submit" value="Add" class="submit">
			</form>

		</div>

		<!-- <a href="changepassword.php" class="buttons">Change Password</a> -->

	</body>
</html>

<?php

	} else {
		header("location: login.php");
		exit();
	} // end of if-else-statement if the user is logged in

?>
