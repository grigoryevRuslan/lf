app.factory('latestFactory', ['$http', function($http) {
	return {
		getAll: function() {
			return $http.post(
				'/ajax/latest-item.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
