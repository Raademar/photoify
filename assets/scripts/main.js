const photoURI = '/app/posts/index.php'
const photoHolder = document.querySelector('.photo-container')

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
