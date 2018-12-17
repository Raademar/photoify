<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we delete new posts in the database.

$id = $_POST['id'] ?? null;

if($id === null) {
  echo("Cannot get the requested post.");
  exit();
}

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
  } else {
    echo 'fail';
    die(var_dump($post['image']));
  }
} else {
  echo 'file does not exist.';
  var_dump($_SERVER["DOCUMENT_ROOT"].$post['image']);
  die(var_dump($post['image']));
}

redirect('/');