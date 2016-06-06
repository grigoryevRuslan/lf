app.factory('gmapFactory', ['$http', function($http) {
	return {
		getCoordinates:function() {
			return $http.post('/ajax/get-coordinates.php', {action: 'all'});
		}
	};
}]);
