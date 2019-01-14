<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
if(isset($_POST['id'])){
  
  $id = $_POST['id'];

  $statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();
  $post = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $pdo->prepare('DELETE FROM posts WHERE id = :id');

  if(!$statement){
    die(var_dump($pdo->errorInfo()));
  }

  $statement->bindParam(':id', $id, PDO::PARAM_INT);
  $statement->execute();

  if(file_exists($_SERVER['DOCUMENT_ROOT'].$post['image'])) {
    if(unlink($_SERVER['DOCUMENT_ROOT'].$post['image'])){
      // MIGHT NEED TO BE MOVED
      redirect('/');
    } else {
      reportError('Something went wrong', '/index.php');
    }
  } else {
    reportError('File does not exist', '/index.php');
  }
}

$request = json_decode(file_get_contents('php://input'));

if(isset($request->id)) {
  // Remove likes
  $postId = intval($request->id);
  $userId = $_SESSION['user_authenticated']['id'];


  $statement = $pdo->prepare('DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id');
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
  $statement = $pdo->prepare('UPDATE posts SET likes = (SELECT COUNT(post_id) FROM likes WHERE post_id = :post_id GROUP BY post_id) WHERE id = :post_id;');
  $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);

  if(!$statement){
    die(var_dump($pdo->errorInfo()));
  }

  $statement->execute();

  if(!$statement){
    die(var_dump($statement->errorInfo()));

  }

  $statement = $pdo->prepare('SELECT DISTINCT post_id, user_id FROM likes WHERE post_id = :post_id');
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
