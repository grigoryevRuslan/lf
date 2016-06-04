app.controller('pmController', ['$scope', 'advertDataFactory', function($scope, advertDataFactory) {

	var success = function(data, status) {
		$scope.pm = parseInt(data[0]) !== 0 ? data[0] : false;
	},

	error = function(data, status) {
		console.log(status + 'from pmController');
	};

	advertDataFactory.getAppsAmount().success(success);

}]);
