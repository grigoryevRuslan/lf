app.controller('counterController', ['$scope', 'advertDataFactory', function($scope, advertDataFactory) {
	$scope.amount = {};

	var success = function(data, status) {
		$scope.amount = data;
	},

	error = function(data, status) {
		console.log(status + 'from counterController');
	};

	advertDataFactory.getAdvertAmount().success(success);

}]);
