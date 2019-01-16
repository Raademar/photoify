<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';

if(!isset($_SESSION['user_authenticated'])) {
	setcookie('active_visit', 'active', time() - 3600);
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
	function setVisible(selector, visible) {
		selector === '.outer-container' ? document.querySelector(selector).classList.add('animated', 'fadeIn')
		document.querySelector(selector).style.display = visible ? 'flex' : 'none'
	}

	let cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)active_visit\s*\=\s*([^;]*).*$)|^.*$/, "$1");
	console.log(cookieValue);
	

	if(cookieValue !== 'active') {
		function onReady(callback) {
			var intervalId = window.setInterval(function() {
				if (finishedLoading === true || cookieValue === 'active') {
					window.clearInterval(intervalId)
					callback.call(this)
				}
			}, 3000)
		}

		onReady(function() {
			setVisible('.outer-container', true)
			setVisible('#loading', false)
		}) 
	} else {
			setVisible('.outer-container', true)
			setVisible('#loading', false)
	}
</script>

<?php 
require __DIR__.'/views/footer.php';
?>
