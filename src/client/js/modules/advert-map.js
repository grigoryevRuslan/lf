$(function() {
	var advert = (function() {
		var map = null,
			marker = null,
			latLng = null;

		return {
			init: function() {
				this.getCoordinates(this.createMap, this.createMarker);
			},

			createMap: function(latLng) {
				var center = advert.setCoordinates(latLng);

				map = new google.maps.Map(document.getElementById('advertMap'), {
					zoom: 17,
					center: center,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
			},

			getCoordinates: function(callback1, callback2) {
				var latLng = {};
				$.ajax({
					type: 'POST',
					url: '/ajax/get-coordinates.php',
					data: {
						action: 'single',
						id: this.getAdvertId()
					},
					success: function(data) {
						latLng.lat = parseFloat($.parseJSON(data)[0].coordinates.split(',')[0]);
						latLng.lng = parseFloat($.parseJSON(data)[0].coordinates.split(',')[1]);
						callback1(latLng);
						callback2(latLng);
					}
				});
			},

			setCoordinates: function(obj) {
				latLng = new google.maps.LatLng(obj.lat, obj.lng);
				return latLng;
			},

			createMarker: function(latLng) {
				marker = new google.maps.Marker({
					position: advert.setCoordinates(latLng),
					title: 'Место',
					map: map,
					icon: 'img/advert-marker.png',
					animation: google.maps.Animation.DROP
				});
			},

			getParameterByName: function(name, url) {
				if (!url) {url = window.location.href;}

				name = name.replace(/[\[\]]/g, '\\$&');
				var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
					results = regex.exec(url);
				if (!results) {return null;}

				if (!results[2]) {return '';}

				return decodeURIComponent(results[2].replace(/\+/g, ' '));
			},

			getAdvertId: function() {
				return this.getParameterByName('id');
			}
		};
	}());

	if ($('#advertMap').length) {
		advert.init();
	}
});
