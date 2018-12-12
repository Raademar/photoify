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
		die(var_dump($pdo->errorInfo()));
		redirect('/login.php');
	}
	if(password_verify($password, $user['password'])){
		$_SESSION['user_authenticated'] = [
			'id' => $user['id'],
			'name' => $user['name'],
			'username' => $user['username'],
			'email' => $user['email'],
		];
		redirect('/index.php');
	} else {
		echo "Wrong credentials!";
	}
} else {
	redirect('/login.php');
}
