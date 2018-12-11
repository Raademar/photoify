<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

$statement = $pdo->prepare('SELECT * FROM posts');
$statement->execute();
$res = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/assets/styles/style.css">
  <title><?php echo $config['title']; ?></title>
</head>
<body>
  <?php foreach($res as $row): ?>
    <h1><?= $row['title']; ?></h1>
    <p><?= $row['description']; ?></p>
    <span><?= $row['likes']; ?></span>
    <img src="<?= $row['image']; ?>" alt="">
  <?php endforeach;?>
</body>
</html>