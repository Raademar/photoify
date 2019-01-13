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
// ----------------------------
// POST ROUTE TO PROFILE SETTINGS

if(isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['description'])) {

  $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING));
	$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
	$email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
  
  $statement = $pdo->prepare('UPDATE users SET name = :name, username = :username, email = :email, description = :description WHERE id = :user_id');
  
  if(!$statement) {
		die(var_dump($pdo->errorInfo()));
  }
  
  $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
	$statement->bindParam(':name', $name, PDO::PARAM_STR);
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->bindParam(':description', $description, PDO::PARAM_STR);
	$statement->execute();
  
}
// ----------------------------

// POST ROUTE TO UPDATE PROFILE IMAGE
if($_FILES['profile-photo']['name'] !== '') {
  if(file_exists($_SERVER['DOCUMENT_ROOT'].$user['profile_image'])) {
    if(unlink($_SERVER['DOCUMENT_ROOT'].$user['profile_image'])){
    } else {
      reportError('Something went wrong', "/profile.php");
    }
  } else {
    reportError('File does not exist.', "/profile.php");
  }

  // If the user edits to a new image, select that one as $image
  $image = $_FILES['profile-photo'];

  if($image['size'] == 0) {
    reportError('Please choose a photo to upload.', "/profile.php");
  }

  $destination = '/../uploads/' . $_SESSION['user_authenticated']['id']  . '/profile_pictures/' . time() . '-' . $image['name'];
  move_uploaded_file($image['tmp_name'], __DIR__.$destination);

  // Set the $destination variable to be stored in the DB.
  $destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];

} else {
  // Else we keep the same image as previous.
  $image = $user['profile_image'];

  // Set the $destination variable to be stored in the DB.
  $destination = $image;
}
	
$statement = $pdo->prepare('UPDATE users SET profile_image = :image WHERE id = :id');
$statement->bindParam(':image', $destination, PDO::PARAM_STR);
$statement->bindParam(':id', $id, PDO::PARAM_STR);
$statement->execute();

if(!$statement){
  die(var_dump($pdo->errorInfo()));
}

$_SESSION['errors'] = '';
redirect('/profile.php');

