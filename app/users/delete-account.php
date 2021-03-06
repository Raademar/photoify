<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

$request = json_decode(file_get_contents('php://input'));
if(isset($request->delete)) {
	$id = $_SESSION['user_authenticated']['id'];
	$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
	$statement->bindParam(':user_id', $id, PDO::PARAM_STR);
	$statement->execute();
	$users = $statement->fetch(PDO::FETCH_ASSOC);

	if (!$users){   
		reportError('No user found', '/profile.php');
	} else {
			$statement = $pdo->prepare('DELETE FROM users WHERE id = :user_id');
			$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
			$statement->execute();
			$statement = $pdo->prepare('DELETE FROM posts WHERE user_id = :user_id');
			$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
			$statement->execute();
			$statement = $pdo->prepare('DELETE FROM comments WHERE user_id = :user_id');
			$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
			$statement->execute();
			$statement = $pdo->prepare('DELETE FROM likes WHERE user_id = :user_id');
			$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
			$statement->execute();

			// remove all of the users uploaded data.
			rrmdir(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id']);

			redirect('/app/users/logout.php');
	}
} else {	
	reportError('Something went wrong when trying to delete your account.', '/profile.php');
	}
