app.controller('requestController', ['$scope', '$http', function($scope, $http) {

	$scope.actionRequest = function(id, status) {
		$scope.reqs[id].isAction = true;

		$http.post(
			'../ajax/verify/action.php',
			{
				requestId: id,
				status: status
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.response.success = response.data;
			console.log(response);
		}, function error(response) {
			$scope.response.error = response.data;
		});
	};

}]);
