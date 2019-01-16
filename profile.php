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
	<!-- Modal for editing profile settings. -->
	<div class="settings-container is-hidden is-visuallyHidden">
		<span class="close-modal"><i class="fas fa-arrow-left"></i></span>
		<h2 class="settings-h2">Settings</h2> 
		<div class="dropdown-profile-settings">
			<ul class="dropdown-profile-settings-ul">
				<li class="settings-list-item profile">Profile</li>
				<li class="settings-list-item account">Account</li>
				<li class="settings-list-item feed disabled-setting">Feed</li>
				<li class="settings-list-item connections disabled-setting">Connections</li>
				<li class="settings-list-item privacy disabled-setting">Privacy</li>
				<li class="settings-list-item notifications disabled-setting">Notifications</li>
				<li class="like-icon"><a href="/app/users/logout.php" class="logout-button">Logout</a></li>
			</ul>
		</div>
	</div>

	<!-- PROFILE SETTINGS -->
	<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="profile-modal-holder is-hidden is-visuallyHidden profile-settings">
		<div class="profile-input-container profile-modal-content">
			<span class="close-modal"><i class="fas fa-arrow-left"></i></span>
			<h2 class="settings-h2">Profile</h2> 
			<input type="text" name="name" id="name" class="profile-form-field" placeholder="Your name..">
			<input type="text" name="username" id="username" class="profile-form-field" placeholder="Your username..">
			<input type="email" name="email" id="email" class="profile-form-field" placeholder="Your email..">
			<textarea name="description" id="description" class="profile-form-field" placeholder="Write something about yourself.."></textarea>
			<button type="submit" class="fullsize-button submit-profile-button">Update profile</button>
		</div>
	</form>
	<!-- --------------- -->

	<!-- ACCOUNT SETTINGS -->
	<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="profile-modal-holder is-hidden is-visuallyHidden account-settings">
		<div class="profile-input-container profile-modal-content">
			<span class="close-modal"><i class="fas fa-arrow-left"></i></span>
			<h2 class="settings-h2">Account</h2> 
			<input type="password" name="password" id="password" class="profile-form-field" placeholder="Enter your new password..">
			<input type="password" name="password2" id="password2" class="profile-form-field" placeholder="Enter your new password again..">
			<button type="submit" disabled class="fullsize-button submit-profile-button">Update profile</button>
			<span class="delete-account-button">Delete account</span>
		</div>
	</form>
	<!-- --------------- -->

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
