<?php
declare(strict_types=1);

?>
<?php if(isset($_SESSION['user_authenticated'])): ?>
	<div class="button-nav-container">
		<a href="
			<?= contains('/index.php',$_SERVER['SCRIPT_NAME'])? 'profile.php' : 'index.php'; ?>
		">
			<button class="navigation-button">
				<i class="fas fa-<?= contains('/index.php',$_SERVER['SCRIPT_NAME'])? 'user' : 'home'; ?> fa-2x"></i>
			</button>
		</a>
		<a href="new-post.php"><button class="floating-action-button"><i class="fas fa-plus fa-2x"></i></button></a>
		<button class="navigation-button search-button"><i class="fas fa-search fa-2x"></i></button>
	</div>
</div>
<?php else: ?>
</div>
<?php endif; ?>
	<script src="assets/scripts/main.js"></script>
</body>
</html>
