$(function() {
	var map,
		latLng = new google.maps.LatLng(50.4666825, 30.52032),
		geocoder = new google.maps.Geocoder(),
		isMapInit = false,
		infowindow,
		marker;

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
		gLatLng = latLng;

		var coords = [
			latLng.lat(),
			latLng.lng()
		].join(', ');

		$('#coordinates').val(coords);
	}

	function updateMarkerAddress(str) {
		if ($('#gmap-address').length) {
			document.getElementById('gmap-address').innerHTML = str;
			$('#clearAddress').show();
		}
	}

	function initialize() {
		initCoords = getCoordinates();
		latLng = new google.maps.LatLng(initCoords.lat, initCoords.lng);
		if (!isMapInit) {

			map = new google.maps.Map(document.getElementById('mapCanvas'), {
				zoom: 13,
				center: latLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			isMapInit = true;
		}

		if (marker) {
			marker.setMap(null);
			map.setCenter(latLng);
		}

		if (infowindow) {
			infowindow.close();
		}

		infowindow = new google.maps.InfoWindow({
			content: 'Перетащите маркер на нужную точку'
		});

		marker = new google.maps.Marker({
			position: latLng,
			title: 'Point A',
			map: map,
			draggable: true
		});

		infowindow.open(map, marker);
		if ($('#coordinates').length) {
			updateMarkerPosition(latLng);
			geocodePosition(latLng);

			google.maps.event.addListener(marker, 'drag', function() {
				updateMarkerPosition(marker.getPosition());
			});

			google.maps.event.addListener(marker, 'dragend', function() {
				updateMarkerAddress('Dragging...');
				geocodePosition(marker.getPosition());
			});
		}

		initSearchBox();
	}

	function getCoordinates() {
		var $coordinates = $('#coordinates'),
			obj = {};
		if ($coordinates.length && $coordinates.val() !== '') {
			obj.lat = parseFloat($coordinates.val().split(',')[0]);
			obj.lng = parseFloat($coordinates.val().split(',')[1]);
		} else {
			obj.lat = 50.4666825;
			obj.lng = 30.52032;
		}

		return obj;
	}

	function clearCoordinates() {
		if ($('#coordinates').length) {
			$('#coordinates').val('');
			$('#gmap-address').html('');
		}
	}

	function isCoordinatesExists() {
		if ($('#coordinates').length) {
			return $('#coordinates').val() !== '' ? true : false;
		} else {
			return null;
		}
	}

	if ($('.open-popup').length) {
		$('.open-popup').on('click', function(e) {
			e.preventDefault();
			initialize();
		});
	}

	if ($('#clearAddress').length) {
		$('#clearAddress').on('click', function() {
			clearCoordinates();
			$(this).hide();
		});
	}

	if (isCoordinatesExists()) {
		initCoords = getCoordinates();
		latLng = new google.maps.LatLng(initCoords.lat, initCoords.lng);
		geocodePosition(latLng);
	}

	function initSearchBox() {
		var searchBox = new google.maps.places.SearchBox(document.getElementById('searchPlace'));
		/*map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));*/
		google.maps.event.addListener(searchBox, 'places_changed', function() {
			searchBox.set('map', null);

			var places = searchBox.getPlaces(),
				bounds = new google.maps.LatLngBounds(),
				i,
				place;

			places.forEach(function(place) {
				if (place.geometry.viewport) {
					bounds.union(place.geometry.viewport);
				} else {
					bounds.extend(place.geometry.location);
				}
			});

			map.fitBounds(bounds);
			searchBox.set('map', map);
			map.setZoom(Math.min(map.getZoom(), 12));

			marker = new google.maps.Marker({
				position: places[0].geometry.location,
				map: map,
				animation: google.maps.Animation.DROP
			});

			geocodePosition(places[0].geometry.location);
			updateMarkerPosition(marker.getPosition());

		});
	}

});
