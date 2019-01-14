<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	redirect('/login.php');
}

?>
<div id="loading"></div>
<div class="outer-container">
<?php if (isset($_SESSION['errors'])): ?>
	<h5 class="error-message"> <?=$_SESSION['errors']; ?> </h5> 
<?php endif; ?>
	<div class="search-modal-holder is-hidden is-visuallyHidden">
		<div class="search-modal-content">
			<form action="/app/posts/index.php" method="GET">
				<div class="input-container">
					<input type="text" name="search-query" id="search-query" class="search-query" placeholder="Search for something..">
					<button type="submit" class="fullsize-button submit-search-button" disabled>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="photo-container"></div>
	<!-- outer-container ends in footer. -->

<script>
	if (!document.cookie.split(';').filter((item) => item.includes('active_visit=true')).length) {
		console.log('finns inte')
		
		function onReady(callback) {
		var intervalId = window.setInterval(function() {
			if (document.getElementsByTagName('body')[0] !== undefined) {
				window.clearInterval(intervalId)
				callback.call(this)
			}
		}, 2000)
	}

	function setVisible(selector, visible) {
		document.querySelector(selector).style.display = visible ? 'flex' : 'none'
	}

	onReady(function() {
		setVisible('.outer-container', true)
		setVisible('#loading', false)
	})
	setTimeout(() => {
		document.cookie = 'active_visit=true'
	}, 10000);
	} else {
			console.log('finns')
			document.querySelector('#loading').style.display = 'none'
	}
</script>

<?php 
require __DIR__.'/views/footer.php';
?>
