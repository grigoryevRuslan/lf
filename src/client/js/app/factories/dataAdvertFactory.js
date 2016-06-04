app.factory('advertDataFactory', ['$http', function($http) {
	return {
		getAdvertSecretCodes: function() {
			return $http.post(
				'/ajax/secret.php',
				{
					type: 'all'
				}
			);
		},

		getAppsAmount: function() {
			return $http.post(
				'/ajax/verify/count.php',
				{
					type: 'all'
				}
			);
		},

		getAdvertLatest: function() {
			return $http.post(
				'/ajax/latest-item.php',
				{
					type: 'all'
				}
			);
		},

		getAdvertViews: function(id) {
			return $http.post(
				'/ajax/page-counter.php',
				{
					id: id
				}
			);
		},

		getAdvertAmount: function() {
			return $http.post(
				'/ajax/items-counter.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
