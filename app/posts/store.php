<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

if(isset($_FILES['image'], $_POST['title'])) {
  $image = $_FILES['image'];
  $title = $_POST['title'];
  $errors = [];

  if($image['size'] >= 3145728) {
    $errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
  }

  if(count($errors) > 0) {
    $_SESSION['errors'] = $errors;

    print_r($errors);
    exit;
  }
  
  // Here we check if the user already have a folder for uploads, if not, create one.
  if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'])) {
    mkdir(__DIR__ .'/../uploads/' . $_SESSION['user_authenticated']['id'], 0777, true);
  }
  $destination = '/../uploads/' . $_SESSION['user_authenticated']['id'] . '/' . time() . '-' . $image['name'];
  move_uploaded_file($image['tmp_name'], __DIR__.$destination);


}

redirect('/');