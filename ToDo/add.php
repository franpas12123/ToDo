<?php

	include("connect.php");
	include("functions.php");

	if(isset($_POST['content'])) {
		$content = trim($_POST['content']);

		if (!empty($content)) {

			// implementing the query the PDO way
			$addedQuery = $db->prepare("INSERT INTO assignments (user, courseName, content, done, created) VALUES (:user, :courseName, :content, 0, NOW())");

			$addedQuery->execute([
				'user' => $_SESSION['email'],
				'courseName' => $_SESSION['courseName'],
				'content' => $content
				]);
		}
	}

	header('Location: profile.php');

?>