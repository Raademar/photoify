const fileUpload = document.querySelector('.file-upload')

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