$(function() {

	var geocoder;
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
	}

	//Get the latitude and the longitude;
	function successFunction(position) {
		var lat = position.coords.latitude,
			lng = position.coords.longitude;
		codeLatLng(lat, lng);
	}

	function errorFunction() {
		console.log('Geocoder failed');
	}

	function initialize() {
		geocoder = new google.maps.Geocoder();
	}

	function codeLatLng(lat, lng) {
		window.latlng = new google.maps.LatLng(lat, lng);
		var str = lat + ',' + lng,
			params = {
			city: '',
			street: '',
			coordinates: str
		};

		geocoder.geocode({
			latLng: window.latlng
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {

					//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
					params.street = results[0].formatted_address;
					for (var i = 0; i < results[0].address_components.length; i++) {
						for (var b = 0; b < results[0].address_components[i].types.length; b++) {

							if (results[0].address_components[i].types[b] == 'administrative_area_level_1') {
								city = results[0].address_components[i];
								params.city = city.short_name;
								break;
							}
						}
					}

					//jscs:enable requireCamelCaseOrUpperCaseIdentifiers

					$.ajax({
						url: 'ajax/save_coordinates.php',
						dataType: 'json',
						data: params,
						success: function(data) {
							console.log(data);
						}
					});
				} else {
					console.log('No results found');
				}
			} else {
				console.log('Geocoder failed due to: ' + status);
			}
		});
	}

	initialize();
});
