<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

$id = $_POST['id'];

$statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['description'])) {
  // If user has edited the image or uploaded a new image on the same post
  // delete the current image before we save the new one.
  if(isset($_FILES['image'])) {
    unlink($post['image']);
  }
  $image = ($_FILES['image']) ? $_FILES['image'] : $post['image'];
	$desc = ($_POST['description']) ? trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) : $post['description'];
  $errors = [];

  if($image['size'] >= 3145728) {
    $errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
  }

  if(count($errors) > 0) {
    $_SESSION['errors'] = $errors;

    print_r($errors);
    exit;
  }

  $destination = '/../uploads/' . $_SESSION['user_authenticated']['id']  . '/posts/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);

	// Set the $destination variable to be stored in the DB.
	$destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/posts/' . time() . '-' . $image['name'];
	
	$statement = $pdo->prepare('UPDATE posts SET image = :image, description = :description WHERE id = :id');
	$statement->bindParam(':image', $destination, PDO::PARAM_STR);
  $statement->bindParam(':description', $desc, PDO::PARAM_STR);
  $statement->bindParam(':id', $id, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$statement){
		die(var_dump($statement->errorInfo()));
	}

  redirect('/index.php');
}