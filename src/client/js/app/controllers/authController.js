app.controller('authController', ['$scope', 'vcRecaptchaService', function($scope, recaptcha) {

	$scope.widgetId = null;

	$scope.setResponse = function(response) {
		if (response && response !== '') {
			$scope.submitted = true;
		}
	};

	$scope.cbExpiration = function() {
		$scope.submitted = false;
	};

	$scope.moveToRegister = function() {
		$scope.login = false;
		$scope.enter = true;
	};

}]);
