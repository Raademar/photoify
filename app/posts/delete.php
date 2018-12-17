<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we delete new posts in the database.

$id = $_POST['id'] ?? null;

if($id === null) {
  echo("Cannot get the requested post.");
  exit();
}

$statement = $pdo->prepare('DELETE FROM posts WHERE id = :id');

if(!$statement){
  die(var_dump($pdo->errorInfo()));
}

$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
redirect('/');