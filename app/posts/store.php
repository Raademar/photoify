<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

if(isset($_FILES['image'])) {
  $image = $_FILES['image'];
	$desc = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) ?? '';
  $errors = [];

  if($image['size'] >= 3145728) {
    $errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
  }

  if(count($errors) > 0) {
    $_SESSION['errors'] = $errors;

    print_r($errors);
    exit;
  }
  
  // Here we check if the user already have a folder for uploads, if not, create one.
  if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'])) {
    mkdir(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'], 0777, true);
  }
  $destination = '/../uploads/' . $_SESSION['user_authenticated']['id'] . '/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);

	// Set the $destination variable to be stored in the DB.
	$destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/' . time() . '-' . $image['name'];
	
	$statement = $pdo->prepare('INSERT INTO posts (user_id, description, tags, image) 
		VALUES (:user_id, :description, :tags, :image)');
	$statement->bindParam(':user_id', $_SESSION['user_authenticated']['id'], PDO::PARAM_INT);
	$statement->bindParam(':description', $desc, PDO::PARAM_STR);
	$statement->bindParam(':tags', $tags, PDO::PARAM_STR);
	$statement->bindParam(':image', $destination, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$pdo){
		die(var_dump($statement->errorInfo()));
	}

}

redirect('/');
