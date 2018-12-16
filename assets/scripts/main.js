const photoURI = '/app/posts/index.php'
const photoHolder = document.querySelector('.photo-container')
const searchButton = document.querySelector('.search-button')
const searchModal = document.querySelector('.search-modal-holder')


const getAllPosts = () => {
	fetch(photoURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			renderPhotos(json)
		})
}

const renderPhotos = (posts) => {
	let postLength = posts.length
	if(postLength === 0) {
		photoHolder.innerHTML = `<h3>No photos to display :(</h3>`
	}
	posts.forEach(item => {
		let photoDiv = document.createElement('div')
		// Create an icon with link to edit-post for each photo
		let editButton = document.createElement('a')
		let icon = document.createElement('i')
		icon.classList.add('fas','fa-edit','edit-icon')
		editButton.href = `edit-post.php?id=${item.id}`
		editButton.appendChild(icon)
		photoDiv.classList.add('photo')
		photoDiv.appendChild(editButton)
		// --------------------------------------------------
		let img = document.createElement('img')
		img.src = item.image
		photoDiv.appendChild(img)
		photoHolder.appendChild(photoDiv)
		// Assign a descending z-index to each rendered image to display them in order.
		photoDiv.style.zIndex = --postLength
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
