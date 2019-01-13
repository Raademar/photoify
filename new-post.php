<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}

?>

<div class="outer-container">
<?php if (isset($_SESSION['errors'])): ?>
	<h5 class="error-message"> <?=$_SESSION['errors']; ?> </h5> 
<?php endif; ?>
	<form action="/app/posts/store.php" method="POST" enctype="multipart/form-data">
		<div class="posts-input-container">
			<div class="preview-image"></div>
			<input type="file" name="image" id="image" class="file-upload">
			<label for="image">Pick file to upload</label>
			<textarea name="description" id="description" class="posts-form-field description" placeholder="Describe your photo.."></textarea>
			<button type="submit" class="fullsize-button submit-posts-button">Share photo</button>
		</div>
	</form>
<?php 
require __DIR__.'/views/footer.php';
?>
