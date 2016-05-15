app.factory('counterFactory', ['$http', function($http) {
	return {
		getAll: function() {
			return $http.post(
				'ajax/items-counter.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
