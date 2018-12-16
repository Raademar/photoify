<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we update posts.

$id = $_GET['id'] ?? null;

if($id === null) {
  echo("Cannot get the requested post.");
  exit();
}

$statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);

// Echo out post info for API.
header('Content-Type: application/json');
echo json_encode($post);
