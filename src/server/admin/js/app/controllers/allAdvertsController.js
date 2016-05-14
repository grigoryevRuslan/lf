app.controller('allAdvertsController', ['$scope', '$http', function($scope, $http) {

	$scope.response = {
		success: '',
		error: ''
	};

	$scope.publishAction = function(id, publish) {
		var isPublished = publish ? 1 : 0;
		$http.post(
			'ajax/publish.php',
			{
				id: parseInt(id),
				isPublished: isPublished
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.response.success = response.data;
		}, function error(response) {
			$scope.response.error = response.data;
		});
	};

}]);
