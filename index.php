<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}

// die(var_dump($_SESSION['user_authenticated']));
?>

<div class="outer-container">
<?php if (isset($_SESSION['errors'])): ?>
	<h5 class="error-message"> <?=$_SESSION['errors']; ?> </h5> 
<?php endif; ?>
	<div class="search-modal-holder is-hidden is-visuallyHidden">
		<div class="search-modal-content">
			<form action="/app/posts/index.php" method="GET">
				<div class="input-container">
					<input type="text" name="search-query" id="search-query" class="search-query" placeholder="Search for something..">
					<button type="submit" class="fullsize-button submit-search-button">Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="photo-container"></div>
	<!-- outer-container ends in footer. -->

<?php 
require __DIR__.'/views/footer.php';
?>
