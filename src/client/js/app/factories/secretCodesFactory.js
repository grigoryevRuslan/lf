app.factory('secretCodesFactory', ['$http', function($http) {
	return {
		getSecretCodes: function() {
			return $http.post(
				'ajax/secret.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
