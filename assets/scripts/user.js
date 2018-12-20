const profileURI = '/app/users/index.php'
const profileContainer = document.querySelector('.profile-container')
const searchButton = document.querySelector('.search-button')
const profileSettingsModal = document.querySelector('.profile-modal-holder')
const profileImage = document.querySelector('.profile-image')
const name = document.querySelector('.active-user')
const desc = document.querySelector('.active-user-description')
const gallery = document.querySelector('.profile-photo-gallery')


const getUserInfo = () => {
	fetch(profileURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			console.log(json);
			renderInfo(json[0])
			renderPhotos(json[1])
		})
}

const renderInfo = (user) => {
	let postLength = user.length
	if(postLength === 0) {
		return
  }
  profileImage.src = user.profile_image
  name.textContent = user.name
  desc.textContent = user.description
}

const renderPhotos = (userPhoto) => {
	let postLength = userPhoto.length
	if(postLength === 0) {
		return
	}
	userPhoto.forEach(photo => {
		let image = document.createElement('img')
		image.classList.add('thumb-photo-gallery')
		image.src = photo.image
		gallery.appendChild(image)
	})
}

const toggleprofileSettingsModal = () => {
	profileSettingsModal.classList.remove('is-hidden')
	profileSettingsModal.classList.remove('is-visuallyHidden')
	profileSettingsModal.style.zIndex = '9999'
}

window.onclick = function(event) {
	if (event.target == profileSettingsModal) {
		profileSettingsModal.classList.add('is-hidden')
		profileSettingsModal.classList.add('is-visuallyHidden')
		profileSettingsModal.style.zIndex = '0'
	}
}

name.addEventListener('click', () => {
  toggleprofileSettingsModal()
})

// Toggle overlay for profile image
profileImage.addEventListener('mouseover', () => {
	document.querySelector('.profile-image-overlay').style.visibility = 'visible'
})
// When mouse leaved overlay, remove it.
document.querySelector('.profile-image-overlay').addEventListener('mouseleave', () => {
	document.querySelector('.profile-image-overlay').style.visibility = 'hidden'
})

getUserInfo()
