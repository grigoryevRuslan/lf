app.factory('getItemViewFactory', ['$http', function($http) {
	return {
		getItemViews: function(id) {
			return $http.post(
				'/ajax/page-counter.php',
				{
					id: id
				}
			);
		}
	};
}]);
