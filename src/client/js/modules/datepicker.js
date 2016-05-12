$(function() {

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
