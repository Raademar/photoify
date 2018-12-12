<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}
?>


<div class="outer-container">
	<h1>Welcome <?= $_SESSION['user_authenticated']['name']; ?></h1>
	<a href="/app/users/logout.php" class="logout-button">Logout</a>
<!-- outer-container ends in footer. -->
<?php 
require __DIR__.'/views/footer.php';
?>
