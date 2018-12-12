<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

if(isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['repeat-password'])) {
	$name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
	$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
	$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
	$password = trim($_POST['password']);
	$repeatPassword = trim($_POST['repeat-password']);

	if($password === $repeatPassword) {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$statement = $pdo->prepare('INSERT INTO users (name, username, email, password) 
			VALUES (:name, :username, :email, :password)');
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':username', $username, PDO::PARAM_STR);
		$statement->bindParam(':email', $email, PDO::PARAM_STR);
		$statement->bindParam(':password', $password, PDO::PARAM_STR);
		$statement->execute();
	}

}
