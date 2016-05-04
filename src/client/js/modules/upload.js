function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader(),
			$image = $('#addUploadFilePreview');

		reader.onload = function(e) {
			$image.attr('src', e.target.result);
		};

		reader.readAsDataURL(input.files[0]);
		$image.show();
	}
}

$('#addUploadFile').change(function() {
	readURL(this);
});
