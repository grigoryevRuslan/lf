app.controller('statsController', ['$scope', 'advertDataFactory', function($scope, advertDataFactory) {

	function getURLParam(name, url) {
		url = url || window.location.href;
		name = name.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
		var regexS = '[\\?&]' + name + '=([^&#]*)',
			regex = new RegExp(regexS),
			results = regex.exec(url);

		if (results === undefined || results === null) {
			return ';';
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, ' '));
		}
	}

	function success(data) {
		if (data) {
			$scope.advertViewsAmount = parseInt(data);
		}
	}

	advertDataFactory.getAdvertViews(parseInt(getURLParam('id'))).success(success);

}]);
