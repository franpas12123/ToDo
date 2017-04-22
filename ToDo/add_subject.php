<?php

	include("connect.php");
	include("functions.php");

	// checking if the content is available
	if(isset($_POST['courseName'])) {
		$courseName = trim($_POST['courseName']);

		if (!empty($courseName)) {

			// implementing the query the PDO way
			$addedQuery = $db->prepare("INSERT INTO subjects (courseName, user, created) VALUES (:courseName, :user, NOW())");

			$addedQuery->execute([
				'courseName' => $courseName,
				'user' => $_SESSION['email']]);
		}
	}

	header('Location: subjects.php');

?>