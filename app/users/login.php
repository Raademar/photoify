<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

if(isset($_POST['username'], $_POST['password'])) {
	$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
	$password = $_POST['password'];

	$statement = $pdo->prepare('SELECT * FROM users WHERE email = :username OR username = :username');
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	if(!$user) {
		reportError('Wrong login credentials given.', '/login.php');
	}
	if(password_verify($password, $user['password'])){
		$_SESSION['user_authenticated'] = [
			'id' => $user['id'],
			'name' => $user['name'],
			'username' => $user['username'],
			'email' => $user['email'],
			'password' => $user['password'],
		];
		$_SESSION['errors'] = '';
		redirect('/index.php');
	} else {
		reportError('Wrong login credentials given.', '/login.php');
	}
} else {
	redirect('/login.php');
}
