function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader(),
			$image = $('#addUploadFilePreview'),
			$preloadedImage = $('#uploadFilePreview');

		reader.onload = function(e) {
			$image.attr('src', e.target.result);
		};

		reader.readAsDataURL(input.files[0]);
		$image.show();
		if ($preloadedImage.length) {
			$preloadedImage.hide();
		}
	}
}

$('#addUploadFile').change(function() {
	readURL(this);
});
