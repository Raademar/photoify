<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

$statement = $pdo->prepare('SELECT * FROM posts');
$statement->execute();
$res = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($res);


// foreach($res as $row):
// 	$row['title'];
// 	$row['description'];
// 	$row['likes'];
// 	$row['image'];
// endforeach;
