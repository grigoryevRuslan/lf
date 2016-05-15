app.controller('latestController', ['$scope', 'latestFactory', function($scope, latestFactory) {
	$scope.latest = {};

	var success = function(data, status) {
		$scope.latest = data;
	},

	error = function(data, status) {
		console.log(status + 'from latestController');
	};

	latestFactory.getAll().success(success);

}]);
