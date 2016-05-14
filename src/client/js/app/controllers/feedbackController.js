app.controller('feedbackController', ['$scope', '$http', function($scope, $http) {

	$scope.response = {
		sending: false,
		success: '',
		error: ''
	};

	$scope.isSending = false;

	$scope.sendFeedback = function(e) {
		e.preventDefault();
		$scope.response.sending = true;
		$scope.isSending = true;

		$http.post(
			'../ajax/feedback.php',
			{
				name: $scope.name,
				mail: $scope.email,
				text: $scope.text
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.response.sending = false;
			$scope.response.success = response.data;
		}, function error(response) {
			$scope.response.error = response.data;
		});
	};

}]);
