$(function() {
	if ($('#register-btn').length) {
		$('#register-btn').on('click', function(e) {
			e.preventDefault();

			$('#formLogin').hide();
			$('#formRegister').show();
		});
	}

	if ($('#login-btn').length) {
		$('#login-btn').on('click', function(e) {
			e.preventDefault();

			$('#formRegister').hide();
			$('#formLogin').show();
		});
	}

	if ($('.open-popup').length) {
		$('.open-popup').on('click', function(e) {
			e.preventDefault();

			if ($('.popup').length) {
				$('.popup').fadeIn(500);
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
