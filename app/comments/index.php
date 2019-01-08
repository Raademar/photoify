<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

if(isset($_GET['post'])){
	$id = $_GET['post'];
	$fetchComments = $pdo->prepare('SELECT post_id, user_id, content, users.username 
		FROM comments 
		INNER JOIN users ON users.id = user_id
		WHERE post_id = :id');
	if(!$fetchComments){
		die(var_dump($pdo->errorInfo()));
	}
	$fetchComments->bindParam(':id', $id, PDO::PARAM_INT);
	$fetchComments->execute();
	$comments = $fetchComments->fetchAll(PDO::FETCH_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($comments);
}
