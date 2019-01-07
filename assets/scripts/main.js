const photoURI = '/app/posts/index.php'
const storeURI = '/app/posts/store.php'
const deleteURI = '/app/posts/delete.php'
const photoHolder = document.querySelector('.photo-container')
const searchButton = document.querySelector('.search-button')
const searchModal = document.querySelector('.search-modal-holder')

const getAllPosts = () => {
	fetch(photoURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			console.log(json)
			renderPhotos(json.posts)
			renderComments(findPostsWithComments(json.posts, json.comments))
		})
}

const renderPhotos = posts => {
	let postLength = posts.length
	if (postLength === 0) {
		photoHolder.innerHTML = `<h3>No photos to display :(</h3>`
		return
	}
	posts.forEach(item => {
		// Set styles for the icons for each photo.
		let photoDiv = document.createElement('div')
		let editButton = document.createElement('a')
		let editIcon = document.createElement('i')
		let commentIcon = document.createElement('i')
		let likeIcon = document.createElement('i')
		let dislikeIcon = document.createElement('i')
		let p = document.createElement('p')
		let comments = document.createElement('p')
		let likesOfPhoto = document.createElement('p')
		let iconHolder = document.createElement('div')
		let imageHolderDiv = document.createElement('div')
		let commentsAndLikeHolder = document.createElement('div')

		commentsAndLikeHolder.classList.add('comments-and-like-holder')
		imageHolderDiv.classList.add('image-holder-div')
		iconHolder.classList.add('icon-holder-inside-overlay')
		editIcon.classList.add('fas', 'fa-edit', 'fa-2x', 'edit-icon')
		commentIcon.classList.add(
			'far',
			'fa-comments',
			'fa-2x',
			'icon-style',
			'comment-icon'
		)
		likeIcon.classList.add(
			'far',
			'fa-heart',
			'fa-2x',
			'icon-style',
			'like-icon'
		)
		dislikeIcon.classList.add(
			'far',
			'fa-thumbs-down',
			'fa-2x',
			'icon-style',
			'dislike-icon'
		)
		editButton.href = `/edit-post.php?id=${item.id}`
		editButton.appendChild(editIcon)
		photoDiv.classList.add('photo')

		// --------------------------------------------------
		// Set the src for each image and assign a toggleable overlay.
		let img = document.createElement('img')
		let profileImageThumb = document.createElement('img')
		let h5 = document.createElement('h5')
		let photoOverlay = document.createElement('div')
		let userInfo = document.createElement('div')
		userInfo.classList.add('user-info')
		img.src = item.image
		profileImageThumb.src = item.profile_image
		h5.textContent = item.username

		userInfo.appendChild(profileImageThumb)
		userInfo.appendChild(h5)
		photoDiv.appendChild(userInfo)
		imageHolderDiv.appendChild(img)
		photoDiv.appendChild(imageHolderDiv)
		photoHolder.appendChild(photoDiv)

		// Get the image data and set it to the image overlay.
		imageHolderDiv.appendChild(photoOverlay)
		photoOverlay.classList.add('photo-overlay', 'toggle-overlay')
		userInfo.classList.add('user-info')
		commentsAndLikeHolder.appendChild(likesOfPhoto)
		commentsAndLikeHolder.appendChild(p)
		commentsAndLikeHolder.appendChild(comments)
		photoOverlay.appendChild(commentsAndLikeHolder)
		p.textContent = `${item.username}: ${item.description}`
		comments.textContent = item.content
		likesOfPhoto.textContent = `${item.likes} people like this photo.`
		photoOverlay.appendChild(editButton)
		iconHolder.appendChild(commentIcon)
		iconHolder.appendChild(likeIcon)
		iconHolder.appendChild(dislikeIcon)
		photoOverlay.appendChild(iconHolder)
		// -------------------------------------------------------

		// Assign clickListener for likeIcon.
		likeIcon.addEventListener('click', () => {
			likeIcon.classList.remove('far')
			likeIcon.classList.add('fas')
			likesOfPhoto.textContent = `${++item.likes} people like this photo.`
			let like = {
				id: item.id
			}
			fetch(storeURI, {
				method: 'POST',
				body: JSON.stringify(like),
				headers: {
					'Content-Type': 'application/json'
				}
			})
				.then(res => res.json())
				.then(response => console.log('Success:', JSON.stringify(response)))
				.catch(error => console.error('Error:', error))
		})
		// -------------------------------
		// Assign clickListener for dislikeIcon.
		dislikeIcon.addEventListener('click', () => {
			dislikeIcon.classList.remove('far')
			dislikeIcon.classList.add('fas')
			likesOfPhoto.textContent = `${--item.likes} people like this photo.`
			let like = {
				id: item.id
			}
			fetch(deleteURI, {
				method: 'POST',
				body: JSON.stringify(like),
				headers: {
					'Content-Type': 'application/json'
				}
			})
				.then(res => res.json())
				.then(response => console.log('Success:', JSON.stringify(response)))
				.catch(error => console.error('Error:', error))
		})
		// -------------------------------

		// Assign a clickListener for each photo to toggle overlay.
		photoDiv.addEventListener('click', event => {
			if (
				event.target == likeIcon ||
				event.target == commentIcon ||
				event.target == dislikeIcon
			) {
				return
			}
			photoOverlay.classList.toggle('toggle-overlay')
		})
		// -----------------------------------------------------
	})
}
const findPostsWithComments = (posts, comments) => {
	// Assign comments to each post
	comments.map(comment => {
		let post = posts.find(x => x.id === comment.post_id)
		post.comment = comment.content
		console.log(comment)
		
		return post ? { ...comment } : 'broken'
	})
	// ----------------------------
}
const renderComments = () => {
	let p = document.createElement('p')
	const photoOverlay = document.querySelector('.photo-overlay')
	photoOverlay.appendChild(p)
	p.textContent = post.comment
}

const toggleSearchModal = () => {
	searchModal.classList.remove('is-hidden')
	searchModal.classList.remove('is-visuallyHidden')
	searchModal.style.zIndex = '9999'
}

window.onclick = function(event) {
	if (event.target == searchModal) {
		searchModal.classList.add('is-hidden')
		searchModal.classList.add('is-visuallyHidden')
		searchModal.style.zIndex = '0'
	}
}

searchButton.addEventListener('click', () => {
	toggleSearchModal()
})

getAllPosts()
