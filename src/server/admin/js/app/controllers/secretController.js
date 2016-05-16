app.controller('secretController', ['$scope', '$http', function($scope, $http) {

	$scope.response = {
		success: '',
		error: ''
	};

	$scope.save = function(event) {
		event.preventDefault();
		$scope.isSending = true;

		$http.post(
			'ajax/secret.php',
			{
				name: $scope.name,
				description: $scope.description,
				example: $scope.example
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.response.success = response.data;
			$scope.isSending = false;
		}, function error(response) {
			$scope.response.error = response.data;
		});
	};

}]);
