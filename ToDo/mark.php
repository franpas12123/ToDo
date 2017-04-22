<?php

	// this paph contains the method when the user marks as done his tasks/assignments

	// don't forget to include these php for the session to continue and get the available sessions
	include("connect.php");
	include("functions.php");

	// the PDO way
	if (isset($_GET['as'], $_GET['item'])) {
		$as = $_GET['as'];
		$item = $_GET['item'];

		// checking if task is mark as done or not
		switch ($as) {
			case 'done':
				$doneQuery = $db->prepare("UPDATE assignments SET done = 1 WHERE id = :item AND user = :user AND courseName = :courseName");

				$doneQuery->execute([
					'item' => $item, 
					'user' => $_SESSION['email'],
					'courseName' => $_SESSION['courseName']
					]);
				break;

			case 'notdone':
				$doneQuery = $db->prepare("UPDATE assignments SET done = 0 WHERE id = :item AND user = :user AND courseName = :courseName");

				$doneQuery->execute([
					'item' => $item, 
					'user' => $_SESSION['email'],
					'courseName' => $_SESSION['courseName']
					]);
				break;
		} // end of switch statement
	} // end of if-statement 

	header('Location: profile.php');

?>