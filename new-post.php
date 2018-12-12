<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
// die(var_dump($_SESSION['user_authenticated']));
?>

<div class="outer-container">
	<form action="/app/posts/store.php" method="POST" enctype="multipart/form-data">
		<div class="posts-input-container">
			<div class="preview-image"></div>
			<input type="file" name="image" id="image" class="file-upload">
			<input type="text" name="title" id="title" class="posts-form-field" placeholder="Username or email">
			<textarea id="password" class="posts-form-field" placeholder="Describe your photo.."></textarea>
			<button type="submit" class="fullsize-button submit-posts-button">Share photo</button>
		</div>
	</form>
<?php 
require __DIR__.'/views/footer.php';
?>
