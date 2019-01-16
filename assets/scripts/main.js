const photoURI = "/app/posts/index.php"
const storeURI = "/app/posts/store.php"
const deleteURI = "/app/posts/delete.php"
const photoHolder = document.querySelector(".photo-container")
const searchButton = document.querySelector(".search-button")
const searchModal = document.querySelector(".search-modal-holder")
const bottomNav = document.querySelector(".button-nav-container")
let postsLoaded = 0
let finishedLoading = false

const getAllPosts = () => {
	fetch(photoURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			console.log(json)
			renderPhotos(json.posts, json.active_user)
		})
}

const renderPhotos = (posts, user) => {
	let postLength = posts.length
	if (postLength === 0) {
		photoHolder.innerHTML = `<h3>No photos to display :(</h3>`
		return
	}
	posts.forEach(item => {
		// Set styles for the icons for each photo.
		let photoDiv = document.createElement("div")
		let editButton = document.createElement("a")
		let editIcon = document.createElement("i")
		let commentIcon = document.createElement("i")
		let likeIcon = document.createElement("i")
		let dislikeIcon = document.createElement("i")
		let p = document.createElement("p")
		let comments = document.createElement("p")
		let likesOfPhoto = document.createElement("p")
		let iconHolder = document.createElement("div")
		let imageHolderDiv = document.createElement("div")
		let commentsAndLikeHolder = document.createElement("div")

		commentsAndLikeHolder.classList.add("comments-and-like-holder")
		commentsAndLikeHolder.dataset.id = item.id
		imageHolderDiv.classList.add("image-holder-div")
		iconHolder.classList.add("icon-holder-inside-overlay")
		editIcon.classList.add("fas", "fa-edit", "fa-2x", "edit-icon")
		commentIcon.classList.add(
			"far",
			"fa-comments",
			"fa-2x",
			"icon-style",
			"comment-icon"
		)
		likeIcon.classList.add(
			"far",
			"fa-heart",
			"fa-2x",
			"icon-style",
			"like-icon"
		)
		dislikeIcon.classList.add(
			"far",
			"fa-thumbs-down",
			"fa-2x",
			"icon-style",
			"dislike-icon"
		)
		editButton.href = `/edit-post.php?id=${item.id}`

		const dropDownMenu = `
		<div class="dropdown">
			<button class="dropbtn"></button>
			<div class="dropdown-content">
				<a href="${editButton}">
					Edit post
					<i class="fas fa-edit edit-icon"></i>
				</a>
			</div>
		</div>
		`
		photoDiv.classList.add("photo")

		// --------------------------------------------------
		// Set the src for each image and assign a toggleable overlay.
		let img = new Image()
		let profileImageThumb = document.createElement("img")
		let h5 = document.createElement("h5")
		let photoOverlay = document.createElement("div")
		let userInfo = document.createElement("div")
		photoDiv.dataset.id = item.id
		userInfo.classList.add("user-info")
		img.src = item.image
		img.classList.add("lazy")
		profileImageThumb.src = item.profile_image
		h5.textContent = item.username

		userInfo.appendChild(profileImageThumb)
		userInfo.appendChild(h5)
		photoDiv.appendChild(userInfo)
		imageHolderDiv.appendChild(img)
		photoDiv.appendChild(imageHolderDiv)
		photoHolder.insertAdjacentElement("beforeend", photoDiv)
		//photoHolder.appendChild(photoDiv)

		// Get the image data and set it to the image overlay.
		imageHolderDiv.appendChild(photoOverlay)
		photoOverlay.classList.add("photo-overlay", "toggle-overlay")
		userInfo.classList.add("user-info")
		commentsAndLikeHolder.appendChild(likesOfPhoto)
		createBoldText(item.username, commentsAndLikeHolder)
		commentsAndLikeHolder.appendChild(p)
		commentsAndLikeHolder.appendChild(comments)
		photoOverlay.appendChild(commentsAndLikeHolder)
		p.textContent = `${item.description}`
		p.classList.add("comment-text")
		comments.textContent = item.content
		likesOfPhoto.textContent = `${item.likes || 0} ${
			item.likes === 1 ? "person" : "people"
		} like this photo.` // FIX THIS
		if (item.user_id == user)
			photoOverlay.insertAdjacentHTML("beforeend", dropDownMenu)
		iconHolder.appendChild(commentIcon)
		iconHolder.appendChild(likeIcon)
		iconHolder.appendChild(dislikeIcon)
		photoOverlay.appendChild(iconHolder)

		// -------------------------------------------------------

		const toggleCommentField = () => {
			commentIcon.removeEventListener("click", toggleCommentField, true)
			bottomNav.classList.add("animated", "fadeOutDownBig")
			const commentInputModal = `
				<div class="comment-modal-holder animated fadeInDown">
					<div class="comment-modal-content">
						<div class="input-container comment-input-container">
							<input type="text" name="comment-text" id="comment-text" class="comment-text-input" placeholder="Write your comment..">
							<button type="submit" class="fullsize-button submit-comment-button">Submit comment</button>
						</div>
						<span class="delete-text-button">Cancel</span>
					</div>
				</div>
			`
			photoDiv.insertAdjacentHTML("beforeend", commentInputModal)
			const submitCommentButton = document.querySelector(
				".submit-comment-button"
			)
			const commentText = document.querySelector(".comment-text-input")
			const cancelComment = document.querySelector(".delete-text-button")
			const commentModal = document.querySelector(".comment-modal-holder")
			cancelComment.addEventListener("click", () => {
				bottomNav.classList.remove("fadeOutDownBig")
				bottomNav.classList.add("animated", "fadeInUpBig")
				photoDiv.removeChild(commentModal)
				commentIcon.addEventListener("click", toggleCommentField, true)
			})

			submitCommentButton.addEventListener("click", () => {
				let comment = {
					postId: item.id,
					comment: commentText.value
				}
				if (commentText.value !== "") {
					fetch(storeURI, {
						method: "POST",
						body: JSON.stringify(comment),
						headers: {
							"Content-Type": "application/json"
						}
					})
						.then(res => res.json())
						.then(response => {
							bottomNav.classList.remove("fadeOutDownBig")
							bottomNav.classList.add("animated", "fadeInUpBig")
							commentModal.innerHTML = ""
							photoOverlay.classList.add("toggle-overlay")
							console.log(response)
							photoDiv.removeChild(commentModal)
							commentIcon.addEventListener("click", toggleCommentField, true)
						})
						.catch(error => console.error(error))
				} else {
					alert("please say something")
				}
			})
		}

		// Assign clickListener for commentIcon
		commentIcon.addEventListener("click", toggleCommentField, true)

		// ------------------------------------

		const registerLike = () => {
			likeIcon.classList.remove("far")
			likeIcon.classList.add("fas")
			likesOfPhoto.textContent = `${++item.likes} people like this photo.`
			let like = {
				id: item.id
			}
			fetch(storeURI, {
				method: "POST",
				body: JSON.stringify(like),
				headers: {
					"Content-Type": "application/json"
				}
			})
				.then(res => res.json())
				.then(response => console.log("Success:", JSON.stringify(response)))
				.catch(error => console.error("Error:", error))
			likeIcon.removeEventListener("click", registerLike, true)
		}

		// Assign clickListener for likeIcon.
		likeIcon.addEventListener("click", registerLike, true)

		// -------------------------------

		const registerDislike = () => {
			dislikeIcon.classList.remove("far")
			dislikeIcon.classList.add("fas")
			likesOfPhoto.textContent = `${--item.likes} people like this photo.`
			let like = {
				id: item.id
			}
			fetch(deleteURI, {
				method: "POST",
				body: JSON.stringify(like),
				headers: {
					"Content-Type": "application/json"
				}
			})
				.then(res => res.json())
				.then(response => console.log("Success:", JSON.stringify(response)))
				.catch(error => console.error("Error:", error))
			dislikeIcon.removeEventListener("click", registerDislike, true)
		}

		// Assign clickListener for dislikeIcon.
		dislikeIcon.addEventListener("click", registerDislike, true)
		// -------------------------------

		const findItems = (needle, haystack) => {
			let target = haystack.filter(x => x === needle)
			return target[0]
			
		}

		// Assign a clickListener for each photo to toggle overlay.
		photoDiv.addEventListener("click", event => {
			const targets = [
				likeIcon,
				commentIcon,
				dislikeIcon,
				findItems(event.target, [...document.querySelectorAll(".dropbtn")]),
				findItems(event.target, [...document.querySelectorAll(".comment-text-input")]),
			]		
			if (targets.includes(event.target)) {
				return
			}
			if (photoOverlay.classList.contains("toggle-overlay")) {
				photoOverlay.classList.remove("toggle-overlay")
			} else {
				photoOverlay.classList.add("toggle-overlay")
			}
		})
		// -----------------------------------------------------

		img.addEventListener("load", () => {
			++postsLoaded
			if (postsLoaded === posts.length) {
				document.cookie = "active_visit=active"
				finishedLoading = true
			}
		})
	})
	// ---- END OF POSTS.FOREACH ----
	const dropbtns = [...document.querySelectorAll(".dropbtn")]
	dropbtns.forEach(dropbtn => {
		dropbtn.addEventListener("click", () => {
			togglePostSettingsDropdown(event)
		})
	})

	const photos = [...document.querySelectorAll(".photo")]
	photos.forEach(photo =>
		photo.addEventListener("click", event => {
			const commentURI = `/app/comments/index.php?post=${photo.dataset.id}`
			fetch(commentURI)
				.then(res => {
					return res.json()
				})
				.then(data => {
					const commentHolder =
						event.target.parentNode.querySelector(
							".comments-and-like-holder"
						) || document.querySelector(".comments-and-like-holder")
					const outerInnerCommentDiv = document.createElement("div")
					outerInnerCommentDiv.classList.add("outer-inner-comment-holder")
					if (
						commentHolder.contains(
							commentHolder.querySelector(".outer-inner-comment-holder")
						)
					) {
						commentHolder.removeChild(
							commentHolder.querySelector(".outer-inner-comment-holder")
						)
					}
					commentHolder.appendChild(outerInnerCommentDiv)
					outerInnerCommentDiv.innerHTML = ""
					data.forEach((comment, i, a) => {
						const innerCommentDiv = document.createElement("div")
						innerCommentDiv.classList.add("inner-comment-holder")
						outerInnerCommentDiv.appendChild(innerCommentDiv)
						const commentText = document.createElement("p")
						commentText.classList.add("comment-text")
						commentText.textContent = `${comment.content}`
						createBoldText(comment.username, innerCommentDiv)
						innerCommentDiv.appendChild(commentText)
						innerCommentDiv.innerHTML += `<div class="clear"></div>`
					})
				})
		})
	)
}

// CREATE USERNAME AS DOM ELEMENT TO MAKE IT BOLD
const createBoldText = (text, parent) => {
	let node = document
		.createRange()
		.createContextualFragment(`<span>${text}</span>`)
	parent.appendChild(node)
	parent.querySelectorAll("span").forEach(item => {
		item.classList.add("bold-username")
	})
}

const toggleSearchModal = () => {
	searchModal.classList.remove("is-hidden")
	searchModal.classList.remove("is-visuallyHidden")
	searchModal.style.zIndex = "9999"
}

window.onclick = function(event) {
	if (event.target == searchModal) {
		searchModal.classList.add("is-hidden")
		searchModal.classList.add("is-visuallyHidden")
		searchModal.style.zIndex = "0"
	}
}

searchButton.addEventListener("click", () => {
	toggleSearchModal()
})

const togglePostSettingsDropdown = event => {
	event.target.nextElementSibling.classList.toggle("show")
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
	if (!event.target.matches(".dropbtn")) {
		let dropdowns = document.querySelector(".dropdown-content")
		if (dropdowns) {
			for (let i = 0; i < dropdowns.length; i++) {
				let openDropdown = dropdowns[i]
				if (openDropdown.classList.contains("show")) {
					openDropdown.classList.remove("show")
				}
			}
		} else {
			return
		}
	}
}

getAllPosts()

// document.addEventListener("DOMContentLoaded", function() {
// 	let lazyloadImages = document.querySelectorAll("img.lazy")
// 	let lazyloadThrottleTimeout

// 	function lazyload () {
// 		if(lazyloadThrottleTimeout) {
// 			clearTimeout(lazyloadThrottleTimeout)
// 		}
// 		console.log('scrolling')

// 		lazyloadThrottleTimeout = setTimeout(function() {
// 				let scrollTop = window.pageYOffset
// 				lazyloadImages.forEach(function(img) {
// 						if(img.offsetTop < (window.innerHeight + scrollTop)) {
// 							img.src = img.dataset.src
// 							img.classList.remove('lazy')
// 						}
// 				})
// 				if(lazyloadImages.length == 0) {
// 					document.removeEventListener("scroll", lazyload)
// 					window.removeEventListener("resize", lazyload)
// 					window.removeEventListener("orientationChange", lazyload)
// 				}
// 		}, 20)
// 	}

// 	document.addEventListener("scroll", lazyload)
// 	window.addEventListener("resize", lazyload)
// 	window.addEventListener("orientationChange", lazyload)
// })
