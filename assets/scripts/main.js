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
	posts.forEach(item => {
		let img = document.createElement('img')
		img.src = item.image
		photoHolder.appendChild(img)
	})
	// Assign a descending z-index to each rendered image to display them in order.
	const rederedImages = [...document.querySelectorAll('img')]
	rederedImages.map(x => {
		x.style.zIndex = --postLength
	})
}

getAllPosts()

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
