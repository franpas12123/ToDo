<?php

	include("connect.php");
	include("functions.php");

	// the PDO way
	if (isset($_GET['as'], $_GET['item'])) {
		$as = $_GET['as'];
		$item = $_GET['item'];

		
		switch ($as) {
			case 'done':
				$doneQuery = $db->prepare("DELETE FROM subjects WHERE id = :item AND user = :user; DELETE FROM assignments WHERE courseName = :courseName AND user = :user");

				$doneQuery->execute([
					'item' => $item, 
					'user' => $_SESSION['email'], 
					'courseName' => $_SESSION['courseName']
					]);
				break;

		} // end of switch statement
	} // end of if-statement 

	header('Location: subjects.php');

?>