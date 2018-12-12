<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

?>


<h1>New post</h1>
<div class="button-nav-container">
	<a href="index.php"><button class="navigation-button"><i class="fas fa-home fa-2x"></i></button></a>
	<a href="new-post.php"><button class="floating-action-button"><i class="fas fa-plus fa-2x"></i></button></a>
	<button class="navigation-button search-button"><i class="fas fa-search fa-2x"></i></button>
</div>

<?php 
require __DIR__.'/views/footer.php';
?>
