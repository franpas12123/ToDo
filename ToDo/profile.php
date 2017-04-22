<?php

	// this php contains everything in the profile page of the user

	// don't forget to include these php for the session to continue and get the available sessions
	include("connect.php");
	include("functions.php");

	// if the user is logged in, must load the profile page
	if (logged_in()) {
		//echo "You are logged in";

		// the PDO way
		if (isset($_GET['as'], $_GET['item'])) {
			$as = $_GET['as'];
			$courseName = $_GET['item'];
			$_SESSION['courseName'] = $courseName;

		} // end of if-statement

		$itemsQuery = $db->prepare("SELECT id, content, done FROM assignments WHERE user = :user AND courseName = :courseName");

		$itemsQuery->execute([
			'courseName' => $_SESSION['courseName'],
			'user' => $_SESSION['email']]);

		$items = $itemsQuery->rowCount() ? $itemsQuery : [];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>To do</title>

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
			<h1 class="header">To do.</h1>

			<?php if(!empty($items)): ?>

			<ul class="items">
				<?php foreach($items as $item): ?>
					<li>
						<span class="item<?php echo $item['done'] ? ' done' : '' ?>"><?php echo $item['content']; ?></span>
						<?php if(!$item['done']): ?>
							<a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
							<a href="delete.php?as=done&item=<?php echo $item['id']; ?>" class="del-button">Delete</a>
						<?php else: ?>
							<a href="delete.php?as=done&item=<?php echo $item['id']; ?>" class="del-button">Delete</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php else: ?>
				<p>You haven't added any items yet.</p>
			<?php endif;?>

			<form class="item-add" action="add.php" method="POST">
				<input type="text" name="content" placeholder="Type a new item here." class="input" autocomplete="off" required>
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
