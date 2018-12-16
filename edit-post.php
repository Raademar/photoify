<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
// die(var_dump($_SESSION['user_authenticated']));
?>

<div class="outer-container">
	<form action="/app/posts/update-post.php" method="POST" enctype="multipart/form-data">
		<div class="posts-input-container">
			<div class="preview-image"></div>
			<input type="file" name="image" id="image" class="file-upload">
			<textarea name="description" id="description" class="posts-form-field description" placeholder="Describe your photo.."></textarea>
			<button type="submit" class="fullsize-button submit-posts-button">Share photo</button>
		</div>
	</form>
<?php 
require __DIR__.'/views/footer.php';
?>
