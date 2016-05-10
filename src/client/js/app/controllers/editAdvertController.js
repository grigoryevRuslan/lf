app.controller('editAdvertController', ['$scope', 'vcRecaptchaService', function($scope, recaptcha) {
	$scope.submitted = false;

	$scope.setResponse = function(response) {
		if (response && response !== '') {
			$scope.submitted = true;
		}
	};

	$scope.cbExpiration = function() {
		$scope.submitted = false;
	};
}]);
