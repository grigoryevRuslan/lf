app.factory('pmFactory', ['$http', function($http) {
	return {
		getAll: function() {
			return $http.post(
				'ajax/verify/count.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
