<?php
declare(strict_types=1);

require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}


$id = $_GET['id'] ?? null;

if($id === null) {
  reportError('Cannot get the requested post.', '/index.php');
}
?>

<div class="outer-container">
	<form action="/app/posts/update-post.php" method="POST" enctype="multipart/form-data">
		<div class="posts-input-container">
			<div class="preview-image"></div>
      <textarea name="description" id="description" class="posts-form-field description" placeholder="Describe your photo.."></textarea>
      <input type="hidden" name="id" id="id" value="<?= $id; ?>">
      <div class="button-holder-div">
        <button type="submit" class="fullsize-button submit-posts-button">Update photo</button>
        <button class="delete-text-button delete-posts-button">Delete photo</button>
      </div>
		</div>
	</form>
<?php 
require __DIR__.'/views/footer.php';
?>
