<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

$id = $_SESSION['user_authenticated']['id'];

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$res = $statement->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($res);
