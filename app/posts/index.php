<?php
declare(strict_types=1);
require __DIR__. '/../autoload.php';

$statement = $pdo->prepare('SELECT * FROM posts ORDER BY id DESC');

if(!$statement){
  die(var_dump($pdo->errorInfo()));
}
$statement->execute();
$res = $statement->fetchAll(PDO::FETCH_ASSOC);

// Create new sql query to fetch count of likes for each post.

// $statement = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE post_id = 45');
// $statement->execute();
// $likes = $statement->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($res);



// SELECT posts.id, posts.user_id, posts.description, posts.image, post_id, COUNT(post_id)
//   FROM posts 
//   LEFT JOIN likes ON likes.post_id = posts.id
//   GROUP BY likes.post_id;

// SELECT posts.id, posts.user_id, posts.description, posts.image, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) posts.likes
//   FROM posts
//   GROUP BY likes.post_id
//   ORDER BY posts.id DESC;