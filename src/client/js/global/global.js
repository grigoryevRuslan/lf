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
			buttonImage: '/img/icon-datepicker.png',
			buttonText: 'Выберите дату',
			changeMonth: true,
			changeYear: true,
			showWeek: true,
			maxDate: new Date()
		});

		$dp.datepicker('setDate', new Date($dp.attr('data-default')));
	}

	if ($('#suggest').length) {

		$('#suggest').autocomplete({
			source: function(request, response) {
				$.ajax({
					url: 'ajax/autocomplete.php',
					dataType: 'json',
					data: {
						term: request.term
					},

					success: function(data) {
						$('#search_form').find('.search__preloader').hide();
						response(

							//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
							$.map(data, function(item) {
								return {
									label: __highlight(item.item || item.user_item, request.term),
									value: item.item || item.user_item
								};
							}

							//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
						));
					},

					error: function(data, status) {
						$('#search_form').find('.search__preloader').hide();
					}
				});
			},

			search: function() {
				$('#search_form').find('.search__preloader').show();
			},

			minLength: 3,

			select: function(event, ui) {
				//$('#search_form').submit();
			}
		}).keydown(function(e) {
			if (e.keyCode === 13) {
				$('#search_form').trigger('submit');
			}
		}).data('ui-autocomplete')._renderItem = function(ul, item) {
			return $('<li></li>').data('ui-autocomplete-item', item).append(
				$('<a></a>').html(item.label)).appendTo(ul);
		};

	}

	function __highlight(s, t) {
		var matcher = new RegExp('(' + $.ui.autocomplete.escapeRegex(t) + ')', 'ig');
		return s.replace(matcher, '<strong>$1</strong>');
	}
});
