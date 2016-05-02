$(function() {
	function getURLParam(name, url) {
		url = url || window.location.href;
		name = name.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
		var regexS = '[\\?&]' + name + '=([^&#]*)',
			regex = new RegExp(regexS),
			results = regex.exec(url);

		if (results === undefined || results === null) {
			return ';';
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, ' '));
		}
	}

	var id = parseInt(getURLParam('id'));

	$.ajax({
		type: 'POST',
		url: '/ajax/page-counter.php',
		data: {
			id: id
		},
		success: function(data) {
			if (data) {
				if ($('#views').length) {
					$('#views').text(parseInt(data));
				}
			}
		}
	});
});
