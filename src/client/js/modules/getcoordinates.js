$(function() {

	function geocodePosition(pos) {
		geocoder.geocode({
			latLng: pos
		}, function(responses) {
			if (responses && responses.length > 0) {
				//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
				updateMarkerAddress(responses[0].formatted_address);
				//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
			} else {
				updateMarkerAddress('Cannot determine address at this location.');
			}
		});
	}

	function updateMarkerPosition(latLng) {
		var coords = [
			latLng.lat(),
			latLng.lng()
		].join(', ');

		$('#coordinates').val(coords);
	}

	function updateMarkerAddress(str) {
		if ($('#gmap-address').length) {
			document.getElementById('gmap-address').innerHTML = str;
		}
	}

	function initialize() {
		var infowindow = new google.maps.InfoWindow({
				content: 'Перетащите маркер на нужную точку'
			}),
			latLng = new google.maps.LatLng(50.4666825, 30.52032),
			map = new google.maps.Map(document.getElementById('mapCanvas'), {
				zoom: 13,
				center: latLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}),
			marker = new google.maps.Marker({
				position: latLng,
				title: 'Point A',
				map: map,
				draggable: true
			});

		infowindow.open(map, marker);

		if ($('#coordinates').length) {
			geocoder = new google.maps.Geocoder();
			// Update current position info.
			updateMarkerPosition(latLng);
			geocodePosition(latLng);

			// Add dragging event listeners.
			google.maps.event.addListener(marker, 'dragstart', function() {
				updateMarkerAddress('Dragging...');
			});

			google.maps.event.addListener(marker, 'drag', function() {
				updateMarkerPosition(marker.getPosition());
			});

			google.maps.event.addListener(marker, 'dragend', function() {
				geocodePosition(marker.getPosition());
			});
		}
	}

});
