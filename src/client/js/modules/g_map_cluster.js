$(document).ready(function() {
	var map,
		infowindow,
		mc,
		elevator,
		latlng,
		lat,
		lng;

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
	}

	//Get the latitude and the longitude;
	function successFunction(position) {
		var lat = position.coords.latitude,
			lng = position.coords.longitude;
		window.latlng = new google.maps.LatLng(lat, lng);
		initialize();
	}

	function errorFunction() {
		console.log('navigator is dead');
	}

	function initialize() {
		if (window.latlng) {
			lat = window.latlng.lat();
			lng = window.latlng.lng();
		}

		var myOptions = {
			zoom: 10,
			center: new google.maps.LatLng(lat || 0, lng || 0),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		infowindow = new google.maps.InfoWindow();
		map = new google.maps.Map(document.getElementById('clusterMap'), myOptions);
		getCoordinates();
	}

	function createMarkers(addresses) {
		var markers = [];
		addresses.forEach(function(item, i, array) {
			var tempstr = item.coordinates.split(','),
				markerInfo = createMarkerInfoTemplate(item),
				latlng = new google.maps.LatLng(tempstr[0], tempstr[1]),
				marker = new google.maps.Marker({
					position: latlng,
					map: map
				});

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.close();
				infowindow.setContent(markerInfo);
				infowindow.open(map, marker);
			});

			markers.push(marker);
		});

		createCluster(markers);
	}

	function getCoordinates() {
		$.ajax({
			type: 'POST',
			url: '/ajax/get-coordinates.php',
			data: {
				action: 'coordinates'
			},
			success: function(data) {
				if (data) {
					createMarkers($.parseJSON(data));
				}
			}
		});
	}

	function createCluster(markers) {
		var mcOptions = {gridSize: 50, maxZoom: 15};
		mc = new MarkerClusterer(map, markers, mcOptions);
	}

	//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
	function createMarkerInfoTemplate(item) {
		var type = (item.type === 'lost' ? 'Потеря' : 'Находка'),
			reward = (item.reward !== 0 ? (item.type === 'lost' ? ('Вознаграждение составляет: <b>' + item.reward + '</b> грн.') : ('Ожидаемое вознаграждение: <b>' + item.reward + '</b> грн.')) : ''),
			name = (item.item ? item.item : item.user_item);

		//jscs:disable validateQuoteMarks
		return "<div id='infowindow'><a href='/advert.php?id=" + item.id + "' target='_blank'>" + type + "'</a>&nbsp;&nbsp;<i>'" + name + "'</i><br />'" + item.date_publish + "'<br />'" + reward + "'</div>'";
		//jscs:enable validateQuoteMarks
		//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
	}

});
