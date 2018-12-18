<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';
$data = [];

$id = $_SESSION['user_authenticated']['id'];

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare('SELECT users.id, posts.user_id, posts.description, posts.image 
  FROM posts INNER JOIN users ON users.id = posts.user_id WHERE users.id = :id');

if(!$statement) {
  die(var_dump($pdo->errorInfo()));
}

$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

$data[] = $user;
$data[] = $posts;

header('Content-Type: application/json');
echo json_encode($data);
