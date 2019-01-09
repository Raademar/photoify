<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}

// die(var_dump($_SESSION['user_authenticated']));
?>


<div class="outer-container">
	<!-- Modal for editing profile settings. -->
	<div class="settings-container is-hidden is-visuallyHidden">
		<span class="close-modal"><i class="fas fa-arrow-left"></i></span>
		<h2 class="settings-h2">Settings</h2> 
		<div class="dropdown-profile-settings">
			<ul class="dropdown-profile-settings-ul">
				<li class="settings-list-item">Profile</li>
				<li class="settings-list-item">Account</li>
				<li class="settings-list-item">Feed</li>
				<li class="settings-list-item">Connections</li>
				<li class="settings-list-item">Privacy</li>
				<li class="settings-list-item">Notifications</li>
				<li class="like-icon"><a href="/app/users/logout.php" class="logout-button">Logout</a></li>
			</ul>
		</div>
	</div>
<!-- 
	<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="profile-modal-holder is-hidden is-visuallyHidden">
		<div class="profile-input-container profile-modal-content">
			<input type="text" name="name" id="name" class="profile-form-field" placeholder="Your name..">
			<input type="text" name="username" id="username" class="profile-form-field" placeholder="Your username..">
			<input type="file" name="image" id="image" class="file-upload">
			<textarea name="description" id="description" class="profile-form-field" placeholder="Write something about yourself.."></textarea>
			<input type="password" name="password" id="password" class="profile-form-field" placeholder="Enter your password..">
			<button type="submit" class="fullsize-button submit-profile-button">Update profile</button>
		</div>
	</form> -->
	<!-- End of modal -->
	<!-- User profile -->
	<div class="profile-container">
		<img src="" alt="User profile photo." class="profile-image">
		<div class="profile-image-overlay">
			<i class="fas fa-camera"></i>
			<span>Update</span>
		</div>
		<h2 class="active-user">No active user.</h2> 
		<h5 class="active-user-description toggle-description">No active user.</h5>
		<div class="profile-photo-gallery"></div>
	</div>
<!-- outer-container ends in footer. -->
<?php 
require __DIR__.'/views/footer.php';
?>
