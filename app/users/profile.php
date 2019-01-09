<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

$id = (int) $_SESSION['user_authenticated']['id'];
$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

// POST ROUTE TO ACCOUNT SETTINGS

if(isset($_POST['password'], $_POST['password2'])) {
  $password = trim($_POST['password']);
  $password2 = trim($_POST['password2']);

  $errors = [];

  if($password === $password2) {
		$password = password_hash($password, PASSWORD_DEFAULT);
	} else {
    $errors[] = "Passwords do not match!";
    print_r($errors);
    exit;
	}

  $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :user_id');

  if(!$statement) {
		die(var_dump($pdo->errorInfo()));
  }
  
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
  $statement->bindParam(':password', $password, PDO::PARAM_STR);
	$statement->execute();
}

// if(isset($_POST['password'])) {
//   $password = $_POST['password'];

//   $errors = [];

//   if($image['size'] >= 3145728) {
//     $errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
//   }
  
//   if(!password_verify($password, $_SESSION['user_authenticated']['password'])) {
//     $errors[] = 'The password provided did not match your saved password. Please try again!';
//   }

//   if(count($errors) > 0) {
//     $_SESSION['errors'] = $errors;

//     print_r($errors);
//     exit;
//   }
  
//   // Here we check if the user already have a folder for uploads, if not, create one.
//   if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'] . '/profile_pictures/')) {
//     mkdir(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'] . '/profile_pictures/', 0777, true);
//   }
//   $destination = '/../uploads/' . $_SESSION['user_authenticated']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];
// 	move_uploaded_file($image['tmp_name'], __DIR__.$destination);

// 	// Set the $destination variable to be stored in the DB.
// 	$destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];
	
//   $statement = $pdo->prepare('UPDATE users SET name = :name, username = :username, description = :description, profile_image = :profile_image WHERE id = :user_id');

// 	if(!$statement) {
// 		die(var_dump($pdo->errorInfo()));
// 	}

// 	$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
//   $statement->bindParam(':name', $name, PDO::PARAM_STR);
//   $statement->bindParam(':username', $username, PDO::PARAM_STR);
// 	$statement->bindParam(':description', $desc, PDO::PARAM_STR);
// 	$statement->bindParam(':profile_image', $destination, PDO::PARAM_STR);
// 	$statement->execute();
	
// 	if(!$statement){
// 		die(var_dump($statement->errorInfo()));
// 	}

// }





// ***********************************

redirect('/profile.php');


// $name = ($_POST['name']) ? trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)) : $user['name'];
// $username = ($_POST['username']) ? trim(filter_var($_POST['username'] , FILTER_SANITIZE_STRING)) : $user['username'];
// $image = ($_FILES['image']) ? $_FILES['image'] : $user['profile_image'];
// $desc = ($_POST['description']) ? trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) : $user['description'];