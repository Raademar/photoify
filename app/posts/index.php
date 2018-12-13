<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

$statement = $pdo->prepare('SELECT * FROM posts ORDER BY id DESC');
$statement->execute();
$res = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($res);
