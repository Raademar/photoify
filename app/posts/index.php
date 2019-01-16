<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

$statement = $pdo->prepare(
	'SELECT users.username, users.profile_image, p.id, p.image, p.user_id, p.description, p.likes -- comments.post_id, comments.content, comments.user_id
	FROM posts AS p
	INNER JOIN users ON users.id = p.user_id
	-- LEFT JOIN comments ON comments.post_id = p.id
	ORDER BY p.id DESC');

if(!$statement){
  die(var_dump($pdo->errorInfo()));
}
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

$data['posts'] = $posts;
$data['active_user'] = $_SESSION['user_authenticated']['id'];
header('Content-Type: application/json');
echo json_encode($data);
