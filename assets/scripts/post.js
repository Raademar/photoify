const fileUpload = document.querySelector('.file-upload')
const description = document.querySelector('.description')
const editPhotoURI = `/app/posts/update.php${window.location.search}`

const previewUploadedFiles = (files) => {
	const previewImage = document.querySelector('.preview-image')
	for (let i = 0; i < files.length; i++) {
    let file = files[i];
		let img = document.createElement('img')
		img.classList.add('obj')
		img.file = file
		previewImage.appendChild(img)

		let reader = new FileReader()
		reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result } }) (img)
		reader.readAsDataURL(file)
	}
}

fileUpload.addEventListener('input', () => {
	previewUploadedFiles(fileUpload.files)
})

const fetchPostForEdit = () => {
	fetch(editPhotoURI)
	.then(res => {
		return res.json()
	})
	.then(json => {
		console.log(json)
		description.textContent = json.description
		const previewImage = document.querySelector('.preview-image')
		let file = json.image
		let img = document.createElement('img')
		img.classList.add('obj')
		img.src = file
		console.log(img)
		previewImage.appendChild(img)
	})
}

if(window.location.pathname === '/edit-post.php') {
	fetchPostForEdit()
}