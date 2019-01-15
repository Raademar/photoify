<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
ini_set('display_errors', 'On');

$id = $_POST['id'];

$statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);


// FIX THIS

// if($post['user_id'] !== (int) $_SESSION['user_athenticated']['id']) {
// 	reportError('Ownership of post is missing.', '/index.php');
// }

if(isset($_POST['description'])) {
  // If user has edited the image or uploaded a new image on the same post
  // delete the current image before we save the new one.
  if($_FILES['image']['name'] !== '') {
    if(file_exists($_SERVER['DOCUMENT_ROOT'].$post['image'])) {
      if(unlink($_SERVER['DOCUMENT_ROOT'].$post['image'])){
      } else {
        reportError('Something went wrong', "/edit-post.php/?id=$id");
      }
    } else {
      reportError('File does not exist.', "/edit-post.php/?id=$id");
    }

    // If the user edits to a new image, select that one as $image
    $image = $_FILES['image'];

    if($image['size'] == 0) {
      reportError('Please choose a photo to upload.', "/edit-post.php/?id=$id");
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
  
	
	$statement = $pdo->prepare('UPDATE posts SET image = :image, description = :description WHERE id = :id');
	$statement->bindParam(':image', $destination, PDO::PARAM_STR);
  $statement->bindParam(':description', $desc, PDO::PARAM_STR);
  $statement->bindParam(':id', $id, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$statement){
		die(var_dump($statement->errorInfo()));
  }
  
  $_SESSION['errors'] = '';
  redirect('/index.php');
}
