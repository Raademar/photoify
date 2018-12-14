<?php
declare(strict_types=1);
// Always start by loading the default application setup.
require __DIR__.'/../app/autoload.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-title" content="Photoify">
	<link rel="apple-touch-icon" href="/../assets/icons/512.png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,600i,700,800" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
	<link rel="stylesheet" href="assets/styles/style.css" media="all">
	<link rel="manifest" href="/manifest.json">
  <title><?php echo $config['title']; ?></title>
</head>
<body>
