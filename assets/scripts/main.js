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
			renderPhotos(json.posts)
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
		commentsAndLikeHolder.dataset.id = item.id
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
		photoDiv.dataset.id = item.id
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
		createBoldText(item.username, commentsAndLikeHolder)
		commentsAndLikeHolder.appendChild(p)
		commentsAndLikeHolder.appendChild(comments)
		photoOverlay.appendChild(commentsAndLikeHolder)
		p.textContent = `${item.description}`
		p.classList.add('comment-text')
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
		const photos = [...document.querySelectorAll('.photo')]
		photos.forEach(photo => photo.addEventListener('click', () => {
			const commentURI  = `/app/comments/index.php?post=${photo.dataset.id}`
			fetch(commentURI)
			.then(res => {
				return res.json()
			})
			.then(data => {
				console.log(data)
					data.forEach((comment, i, a) => {
						const commentHolder = [...document.querySelectorAll('.comments-and-like-holder')]
						const innerCommentDiv = document.createElement('div')
						innerCommentDiv.classList.add('inner-comment-holder')
						commentHolder[i].appendChild(innerCommentDiv)
						
						if(innerCommentDiv.childNodes.length === 0){
							const commentText = document.createElement('p')
							commentText.classList.add('comment-text')
							commentText.textContent = `${comment.content}`
							let res = commentHolder.filter(holder => holder.dataset.id === photo.dataset.id)
							createBoldText(comment.username, res[0])
							res[0].appendChild(commentText)
							res[0].innerHTML += `<div class="clear"></div>`
						} else {
							return
						}
					})
				})
		}))
}

// CREATE USERNAME AS DOM ELEMENT TO MAKE IT BOLD
const createBoldText = (text, parent) => {
	let node = document.createRange().createContextualFragment(`<span>${text}</span>`)
	parent.appendChild(node)
	parent.querySelectorAll('span').forEach(item => {
		item.classList.add('bold-username')
	})
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
