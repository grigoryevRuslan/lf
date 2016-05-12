app.controller('addAdvertController', ['$scope', 'vcRecaptchaService', function($scope, recaptcha) {
	$scope.submitted = false;
	$scope.meta = str2arr('');

	$scope.setResponse = function(response) {
		if (response && response !== '') {
			$scope.submitted = true;
		}
	};

	$scope.cbExpiration = function() {
		$scope.submitted = false;
	};

	$scope.$watch('tags', function(newValue, oldValue) {
		$scope.meta = arr2str(newValue);
	}, true);

	$scope.$watch('preloadTags', function(newValue, oldValue) {
		if ($scope.preloadTags !== undefined) {
			$scope.tags = str2arr($scope.preloadTags);
		}
	});

	// Convert array of objects to string for tags functionality
	function arr2str(arr) {
		var str = '',
			divider = ', ';
		if (arr !== undefined) {
			for (var i = 0; i <= arr.length; i++) {
				if (arr[i] !== undefined) {
					if (i === arr.length - 1) {
						divider = '';
					}

					str += arr[i].text + divider;
				}
			}
		}

		return str;
	}

	// Convert string to array of objects for tags functionality
	function str2arr(str) {
		var objects = [],
			arr = str.split(',');

		for (var i = 0; i < arr.length; i++) {
			objects.push({text: arr[i]});
		}

		return objects;
	}

}]);
