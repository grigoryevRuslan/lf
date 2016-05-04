var map;
function initAutocomplete() {
	map = new google.maps.Map(document.getElementById('mapCanvas'), {
		center: {
			lat: -33.8688,
			lng: 151.2195
		},
		zoom: 13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	var input = document.getElementById('pac-input'),
		searchBox = new google.maps.places.SearchBox(input);

	map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
	});

	google.maps.event.trigger(map, 'resize');
	var markers = [];

	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length === 0) {
			return;
		}

		// Clear out the old markers.
		markers.forEach(function(marker) {
			marker.setMap(null);
		});

		markers = [];

		// For each place, get the icon, name and location.
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place) {
			var icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
			};

			// Create a marker for each place.
			markers.push(new google.maps.Marker({
				map: map,
				icon: icon,
				title: place.name,
				position: place.geometry.location
			}));

			if (place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});

		map.fitBounds(bounds);
	});
}
