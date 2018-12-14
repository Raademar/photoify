<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}
// die(var_dump($_SESSION['user_authenticated']));
?>


<div class="outer-container">
<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data">
		<div class="profile-input-container">
			<input type="text" name="name" id="name" class="profile-form-field" placeholder="Your name..">
			<input type="text" name="username" id="username" class="profile-form-field" placeholder="Your username..">
			<input type="file" name="image" id="image" class="file-upload">
			<textarea name="description" id="description" class="profile-form-field" placeholder="Write something about yourself.."></textarea>
			<input type="password" name="password" id="password" class="profile-form-field" placeholder="Enter your password..">
			<button type="submit" class="fullsize-button submit-profile-button">Update profile</button>
		</div>
	</form>
	<a href="/app/users/logout.php" class="logout-button">Logout</a>
<!-- outer-container ends in footer. -->
<?php 
require __DIR__.'/views/footer.php';
?>
