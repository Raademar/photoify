<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

// STORE POSTS
if(isset($_FILES['image'])) {
  $image = $_FILES['image'];
	$desc = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) ?? '';

  if($image['size'] == 0) {
    reportError('Please choose a photo to upload.', '/new-post.php');
  }

  if($image['size'] >= 3545728) {
    reportError('The uploaded file exceeded the filsize limit', '/new-post.php');
	}

  
  // Here we check if the user already have a folder for uploads, if not, create one.
  if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'] . '/posts/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'] . '/posts/', 0777, true);
  }
	$destination = '/../uploads/' . $_SESSION['user_authenticated']['id']  . '/posts/' . time() . '-' . $image['name'];
	
	// Compress the images before we init the save.
  // compress($image['tmp_name'], $image['tmp_name'], 75); // Bugs out, skip until later.

	move_uploaded_file($image['tmp_name'], __DIR__.$destination);

	
	// Set the $destination variable to be stored in the DB.
	$destination = '/app/uploads/' . $_SESSION['user_authenticated']['id'] . '/posts/' . time() . '-' . $image['name'];
	
	$statement = $pdo->prepare('INSERT INTO posts (user_id, description, tags, image) 
		VALUES (:user_id, :description, :tags, :image)');
	$statement->bindParam(':user_id', $_SESSION['user_authenticated']['id'], PDO::PARAM_INT);
	$statement->bindParam(':description', $desc, PDO::PARAM_STR);
	$statement->bindParam(':tags', $tags, PDO::PARAM_STR);
	$statement->bindParam(':image', $destination, PDO::PARAM_STR);
	$statement->execute();
	
	if(!$statement){
		die(var_dump($statement->errorInfo()));
  }
  
  saved_to_database('/index.php');
}

// Post request for likes

$request = json_decode(file_get_contents('php://input'));

if(isset($request->id)) {
  $postId = intval($request->id);
  $userId = $_SESSION['user_authenticated']['id'];


  $statement = $pdo->prepare('INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  // UPDATE TABLE WITH THE NEW LIKE INTO THE POSTS TABLE
  $statement = $pdo->prepare('UPDATE posts 
		SET likes = (SELECT COUNT(post_id) 
		FROM likes WHERE post_id = :post_id 
		GROUP BY post_id) 
		WHERE id = :post_id;');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);

  if(!$statement){
    die(var_dump($pdo->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));

  }

  // SEND FEEDBACK BACK TO USER
  $statement = $pdo->prepare('SELECT post_id, user_id FROM likes WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $likes = $statement->fetch(PDO::FETCH_ASSOC);
  header('Content-Type: application/json');

  echo json_encode($likes);
}

if(isset($request->postId)) {
  $postId = intval($request->postId);
  $comment = trim(filter_var($request->comment, FILTER_SANITIZE_STRING));
  $userId = $_SESSION['user_authenticated']['id'];

  $statement = $pdo->prepare('INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
  $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
  $statement->bindParam(':content', $comment, PDO::PARAM_STR);

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $statement = $pdo->prepare('SELECT * FROM comments WHERE post_id = :post_id');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));
  }

  $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
  header('Content-Type: application/json');

  echo json_encode($comments);
}
