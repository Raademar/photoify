const profileURI = "/app/users/index.php"
const profileUpdateImageURI = "/app/users/profile.php"
const profileContainer = document.querySelector(".profile-container")
const searchButton = document.querySelector(".search-button")
const profileSettingsModal = document.querySelector(".profile-modal-holder")
const profileImage = document.querySelector(".profile-image")
const name = document.querySelector(".active-user")
const desc = document.querySelector(".active-user-description")
const gallery = document.querySelector(".profile-photo-gallery")
const settingsContainer = document.querySelector('.settings-container')
const closeModal = [...document.querySelectorAll('.close-modal')]
const toggleSpecificSettingsModal = [...document.querySelectorAll('.settings-list-item')]
const profileImgeOverlay = document.querySelector('.profile-image-overlay')


const getUserInfo = () => {
	fetch(profileURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			console.log(json)
			renderInfo(json[0])
			renderPhotos(json[1])
		})
}

const renderInfo = user => {
	let postLength = user.length
	if (postLength === 0) {
		return
	}
	profileImage.src = user.profile_image
	name.textContent = user.name
	desc.textContent = user.description
}

const renderPhotos = async userPhoto => {
	let postLength = userPhoto.length
	if (postLength === 0) {
		return
	}
	userPhoto.forEach(photo => {
		const thumbnailImage = `
			<div class="thumbnail">
				<img src="${photo.image}" data-id="${photo.id}">
			</div>
		`
		gallery.innerHTML += thumbnailImage

	})
		const portraitThumbnailImage = [...document.querySelectorAll('.thumbnail img')]
		await portraitThumbnailImage.map(img => {
			(img.clientHeight > img.clientWidth) ? img.classList.add('portrait') : img.classList.add('landscape')
		})

		portraitThumbnailImage.map(img => {
			img.addEventListener('click', (event) => {
				let imageId = img.dataset.id
				fetchSpecificPhoto(imageId, event.target)
			})
		})

		localStorage.setItem('userPhotos', JSON.stringify(userPhoto))
}

const toggleprofileSettingsModal = () => {
	settingsContainer.classList.remove("is-hidden")
	settingsContainer.classList.remove("is-visuallyHidden")
	settingsContainer.style.zIndex = "9999"
}

const toggleSpecificSetting = (setting) => {
	const settingForms = [...document.querySelectorAll('form')]
	settingForms.forEach((form) => {
		if(form.classList.contains(`${setting}-settings`)) {
			form.classList.remove("is-hidden")
			form.classList.remove("is-visuallyHidden")
			form.style.zIndex = "99999"
		}
	})
}

// window.addEventListener('click', () => {
// 	if(document.querySelector('.fullsize-photo-overlay-modal'))
// 	document.querySelector('.fullsize-photo-overlay-modal').parentNode.removeChild(document.querySelector('.fullsize-photo-overlay-modal'))
// })

const fetchSpecificPhoto = (imageId, target) => {
	let photoToShowFullsize = JSON.parse(localStorage.getItem('userPhotos')).filter(x => x.id === imageId)
	console.log(photoToShowFullsize)
	
	const fullsizePhotoOverlayModal = `
		<div class="fullsize-photo-overlay-modal">
			<img src="${photoToShowFullsize[0].image}" class="fullsize-photo">
		</div>
	`
	target.parentNode.parentNode.innerHTML += (fullsizePhotoOverlayModal)
}

const fillUserInfo = user => {
	const name = document.querySelector('#name')
	const username = document.querySelector('#username')
	const email = document.querySelector('#email')
	const description = document.querySelector('#description')

	name.value = user.name
	username.value = user.username
	email.value = user.email
	description.value = user.description
}

toggleSpecificSettingsModal.forEach((setting) => {
	setting.addEventListener('click', () => {
		let settingToToggle = setting.classList[1]
		toggleSpecificSetting(settingToToggle)
		fetch(profileURI)
		.then(res => {
			return res.json()
		})
		.then(json => {
			fillUserInfo(json[0])
		})
	})
})

closeModal.forEach(close => close.addEventListener('click', () => {
	if(close.parentNode !== settingsContainer) {
		close.parentNode.parentNode.classList.add("is-hidden")
		close.parentNode.parentNode.classList.add("is-visuallyHidden")
		close.parentNode.parentNode.style.zIndex = "0"
	} else {
		settingsContainer.classList.add("is-hidden")
		settingsContainer.classList.add("is-visuallyHidden")
		settingsContainer.style.zIndex = "0"
	}
}))

name.addEventListener("click", () => {
	toggleprofileSettingsModal()
})

// Toggle overlay for profile image
profileImage.addEventListener("mouseover", () => {
	document.querySelector(".profile-image-overlay").style.visibility = "visible"
})
// When mouse leaved overlay, remove it.
document
	.querySelector(".profile-image-overlay")
	.addEventListener("mouseleave", () => {
		document.querySelector(".profile-image-overlay").style.visibility = "hidden"
})

const toggleprofileModal = () => {
	const tempProfileModal = `
		<div class="profile-photo-modal-holder">
			<div class="inner-profile-modal-holder">
				<div class="inner-profile-modal-holder-header">
					<h3 class="h3-header">Change profile image</h3>
				</div>
				<div class="inner-profile-modal-holder-buttons">
					<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="update-profile-photo-form">
						<input type="file" name="profile-photo" id="profile-photo" class="input-file">
						<label for="profile-photo">
							<span class="upload-new-profile-image">Upload new image</span>
						</label>
						</form>
					<button class="close-profile-modal error-message">Cancel</button>
				</div>
			</div>
		</div>
	`
	profileContainer.innerHTML += tempProfileModal
	const profileModal = document.querySelector(".profile-photo-modal-holder")
	
	window.onclick = function(event) {
		if (event.target == profileModal) {
			profileContainer.removeChild(profileModal)
		}
	}	
}
profileImgeOverlay.addEventListener("click", () => {
	console.log('toggled modal')
	toggleprofileModal()
	const profilePhotoInputFile = document.querySelector('.input-file')
	const updateProfilePhotoForm = document.querySelector('.update-profile-photo-form')
	profilePhotoInputFile.addEventListener('change', () => {
		updateProfilePhotoForm.submit()
	})
})
getUserInfo()
