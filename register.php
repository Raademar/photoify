<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

?>

<div class="outer-container">
	<form action="/app/users/register.php" method="POST">
		<div class="register-input-container">
			<input type="text" name="name" id="name" class="register-form-field" placeholder="Name">
			<input type="text" name="username" id="username" class="register-form-field" placeholder="Username">
			<input type="email" name="email" id="email" class="register-form-field" placeholder="Email">
			<input type="password" name="password" id="password" class="register-form-field" placeholder="Password">
			<input type="password" name="repeat-password" id="repeat-password" class="register-form-field" placeholder="Repeat password">
			<button type="submit" class="fullsize-button submit-register-button">Register</button>
		</div>
	</form>
	<div class="alt-link-container">
		<a href="/login.php" class="login-register-swap">Login</a>
	</div>
<!-- outer-container ends in footer. -->

<?php 
require __DIR__.'/views/footer.php';
?>
