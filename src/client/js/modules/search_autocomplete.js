$(function() {

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
					}
				});
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
