app.controller('latestController', ['$scope', 'advertDataFactory', function($scope, advertDataFactory) {
	$scope.latest = {};

	var success = function(data, status) {
		$scope.latest = data;
	},

	error = function(data, status) {
		console.log(status + 'from latestController');
	};

	advertDataFactory.getAdvertLatest().success(success);

}]);
