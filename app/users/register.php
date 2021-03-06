<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

if(isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['repeat-password'])) {
	$name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
	$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
	$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
	$password = trim($_POST['password']);
	$repeatPassword = trim($_POST['repeat-password']);

	if(strlen($password) < 8) {
		reportError('Passwords is too short, needs to be at least 8 characters!', '/register.php');
	}
	
	if($password === $repeatPassword) {
		$password = password_hash($password, PASSWORD_DEFAULT);
	} else {
		reportError('Passwords do not match!', '/register.php');
	}

	$statement = $pdo->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$statement) {
		die(var_dump($pdo->errorInfo()));
	}

	$user = $statement->fetch(PDO::FETCH_ASSOC);

	if($user) {
		reportError('A user with those credentials already exist, please try again', '/register.php');
	}



	$statement = $pdo->prepare('INSERT INTO users (name, username, email, password) 
	VALUES (:name, :username, :email, :password)');
	$statement->bindParam(':name', $name, PDO::PARAM_STR);
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->bindParam(':password', $password, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$statement) {
		die(var_dump($pdo->errorInfo()));
	}

	$statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	
	if(!$user) {
		die(var_dump($user->errorInfo()));
	}

	$_SESSION['user_authenticated'] = $user;
	saved_to_database('/');
}
