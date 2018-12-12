<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';


?>

<div class="outer-container">
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
	<div class="button-nav-container">
		<a href="profile.php"><button class="navigation-button"><i class="fas fa-user fa-2x"></i></button></a>
		<a href="new-post.php"><button class="floating-action-button"><i class="fas fa-plus fa-2x"></i></button></a>
		<button class="navigation-button search-button"><i class="fas fa-search fa-2x"></i></button>
	</div>
</div>

<?php 
require __DIR__.'/views/footer.php';
?>
