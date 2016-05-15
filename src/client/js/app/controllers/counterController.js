app.controller('counterController', ['$scope', 'counterFactory', function($scope, counterFactory) {
	$scope.amount = {};

	var success = function(data, status) {
		$scope.amount = data;
	},

	error = function(data, status) {
		console.log(status + 'from counterController');
	};

	counterFactory.getAll().success(success);

}]);
