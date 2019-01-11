<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

?>

<div class="outer-container">
<?php if (isset($_SESSION['errors'])): ?>
	<h5 class="error-message"> <?=$_SESSION['errors']; ?> </h5> 
<?php endif; ?>
	<form action="/app/users/login.php" method="POST">
		<div class="login-input-container">
			<input type="text" name="username" id="username" class="login-form-field" placeholder="Username or email">
			<input type="password" name="password" id="password" class="login-form-field" placeholder="Password">
			<button type="submit" class="fullsize-button submit-login-button">Login</button>
			<div class="alt-link-container">
		</div>
	</form>
	<a href="/register.php" class="login-register-swap">Register</a>
	</div>
	<!-- outer-container ends in footer. -->

<?php 
require __DIR__.'/views/footer.php';
?>
