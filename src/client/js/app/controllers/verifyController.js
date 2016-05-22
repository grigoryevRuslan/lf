app.controller('verifyController', ['$scope', '$http', function($scope, $http) {

	$scope.sendRequest = function(e) {
		e.preventDefault();
		$scope.response.sending = true;

		$http.post(
			'../ajax/verify/send.php',
			{
				advertId: $scope.verify.advertId,
				advertType: $scope.verify.advertType,
				request: $scope.verify.request
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.response.success = response.data.text;
			$scope.response.limitCounter = response.data.limitCounter;
			$scope.verify.hideField = true;
		}, function error(response) {
			$scope.response.error = response.data;
		});
	};

}]);
