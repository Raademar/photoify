<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
ini_set('display_errors', 'On');

$id = $_POST['id'];

$statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

if(isset($_POST['description'])) {
  // If user has edited the image or uploaded a new image on the same post
  // delete the current image before we save the new one.
  if($_FILES['image']['name'] !== '') {
    if(file_exists($_SERVER['DOCUMENT_ROOT'].$post['image'])) {
      if(unlink($_SERVER['DOCUMENT_ROOT'].$post['image'])){
      } else {
        echo 'fail';
        die(var_dump($post['image']));
      }
    } else {
      echo 'file does not exist.';
      var_dump($_SERVER["DOCUMENT_ROOT"].$post['image']);
      die(var_dump($post['image']));
    }

    // If the user edits to a new image, select that one as $image
    $image = $_FILES['image'];

    if($image['size'] >= 3145728) {
      $errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
    }

    $destination = '/../uploads/' . $_SESSION['user_authenticated']['id']  . '/posts/' . time() . '-' . $image['name'];
    move_uploaded_file($image['tmp_name'], __DIR__.$destination);

    // Set the $destination variable to be stored in the DB.
    $destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/posts/' . time() . '-' . $image['name'];

  } else {
    // Else we keep the same image as previous.
    $image = $post['image'];

    // Set the $destination variable to be stored in the DB.
    $destination = $image;
  }

  $desc = ($_POST['description']) ? trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) : $post['description'];
  

  if(count($errors) > 0) {
    $_SESSION['errors'] = $errors;
    print_r($errors);
    exit;
  }
	
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