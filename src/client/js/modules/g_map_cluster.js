$(document).ready(function() {
	var map,
		infowindow,
		mc,
		latlng,
		lat,
		lng,
		markers = [];

	function initialize() {
		lat = 50.4666825;
		lng = 30.52032;

		var myOptions = {
			zoom: 10,
			center: new google.maps.LatLng(lat || 0, lng || 0),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		infowindow = new google.maps.InfoWindow();
		map = new google.maps.Map(document.getElementById('clusterMap'), myOptions);
		getCoordinates();
		initSearchBox();
	}

	function createMarkers(addresses) {
		addresses.forEach(function(item, i, array) {
			var tempstr = item.coordinates.split(','),
				markerInfo = createMarkerInfoTemplate(item),
				latlng = new google.maps.LatLng(tempstr[0], tempstr[1]),
				marker = new google.maps.Marker({
					position: latlng,
					map: map,
					animation: google.maps.Animation.DROP,
					type: item.type
				});

			google.maps.event.addListener(marker, 'mouseover', function() {
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
				action: 'all'
			},
			success: function(data) {
				if (data) {
					createMarkers($.parseJSON(data));
				}
			}
		});
	}

	function createCluster(markers) {
		var mcOptions = {
			gridSize: 50,
			maxZoom: 15,
			styles: [{
				height: 44,
				url: 'http://www.luckfind.me/img/map-cluster.png',
				width: 44
			}]
		};
		mc = new MarkerClusterer(map, markers, mcOptions);
	}

	//jscs:disable requireCamelCaseOrUpperCaseIdentifiers
	function createMarkerInfoTemplate(item) {
		var type = (item.type === 'lost' ? 'Потеря' : 'Находка'),
			image_uri = '/upload/' + item.image_uri,
			reward = (item.reward !== 0 ? (item.type === 'lost' ? ('Вознаграждение составляет: <b>' + item.reward + '</b> грн.') : ('Ожидаемое вознаграждение: <b>' + item.reward + '</b> грн.')) : ''),
			name = (item.item ? item.item : item.user_item);

		//jscs:disable validateQuoteMarks
		return "<div id='infowindow'><a href='/advert.php?id=" + item.id + "' target='_blank'><img class='image' src=" + image_uri + " /></a><div class='content'><a href='/advert.php?id=" + item.id + "' target='_blank'>" + type + "'</a>&nbsp;&nbsp;<i>'" + name + "'</i><br />'" + item.date_publish + "'<br />'" + reward + "'</div></div>'";
		//jscs:enable validateQuoteMarks
		//jscs:enable requireCamelCaseOrUpperCaseIdentifiers
	}

	function initSearchBox() {
		var searchBox = new google.maps.places.SearchBox(document.getElementById('searchPlace'));

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

		});
	}

	initialize();

	if ($('.switch-markers').length) {
		$('.switch-markers .icon').on('click', function() {
			if (!$(this).hasClass('icon_active')) {
				$('.switch-markers .icon').removeClass('icon_active');
				$(this).addClass('icon_active');
				mc.clearMarkers();
				var type = $(this).data('show'),
					newMarkers = [];
				for (var i = 0; i < markers.length; i++) {
					if (type !== 'all') {
						markers[i].setVisible(false);
						if (markers[i].type === type) {
							markers[i].setVisible(true);
							newMarkers.push(markers[i]);
						} else {
							markers[i].setVisible(false);
						}
					} else {
						markers[i].setVisible(true);
						newMarkers.push(markers[i]);
					}
				}

				createCluster(newMarkers);
			}
		});
	}

});
