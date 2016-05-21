app.controller('pmController', ['$scope', 'pmFactory', function($scope, pmFactory) {

	var success = function(data, status) {
		$scope.pm = parseInt(data[0]) !== 0 ? data[0] : false;
	},

	error = function(data, status) {
		console.log(status + 'from pmController');
	};

	pmFactory.getAll().success(success);

}]);
