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

	if ($('#datepicker').length) {
		var $dp = $('#datepicker');

		$.datepicker.regional.ru = {
			closeText: 'Закрыть',
			prevText: '&#x3c;Пред',
			nextText: 'След&#x3e;',
			currentText: 'Сегодня',
			monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
			'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн',
			'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
			dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
			dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
			dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
			firstDay: 1,
			isRTL: false
		};

		$.datepicker.setDefaults($.datepicker.regional.ru);

		$dp.datepicker({
			dateFormat: 'dd-mm-yy',
			showOn: 'both',
			buttonImage: 'img/icon-datepicker.png',
			buttonText: 'Выберите дату',
			changeMonth: true,
			changeYear: true,
			showWeek: true,
			maxDate: new Date()
		});

		$dp.datepicker('setDate', new Date($dp.attr('data-default')));
	}
});
