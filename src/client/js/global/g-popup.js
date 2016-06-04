$(function() {
	if ($('.open-popup').length) {
		$('.open-popup').on('click', function(e) {
			e.preventDefault();
			var type = $(this).data('type');

			if ($('.popup.popup_' + type).length) {
				if ($(this).data('remove')) {
					$('.popup.popup_' + type).find('form #ad-remove').val($(this).data('remove'));
				}

				$('.popup.popup_' + type).fadeIn(500);
			}
		});
	}

	if ($('.popup__close').length) {
		$('.popup__close').on('click', function(e) {
			e.preventDefault();

			$('.popup').fadeOut(500);
		});
	}

	if ($('.popup').length) {
		$('.popup').on('click', function(e) {
			if ($(e.target).hasClass('popup')) {
				$('.popup').fadeOut(500);
			}
		});
	}
});
