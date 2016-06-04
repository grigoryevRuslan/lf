app.controller('addAdvertController', ['$scope', 'vcRecaptchaService', 'advertDataFactory', function($scope, recaptcha, advertDataFactory) {
	$scope.submitted = false;
	$scope.meta = str2arr('');

	advertDataFactory.getAdvertSecretCodes().success(function(data, status) {
		$scope.codes = data;
		$scope.codes.push(
			{id: 1000, name: 'Другое', example: '', description: ''}
		);
	});

	$scope.setResponse = function(response) {
		if (response && response !== '') {
			$scope.submitted = true;
		}
	};

	$scope.cbExpiration = function() {
		$scope.submitted = false;
	};

	$scope.setFile = function(element) {
		var reader = new FileReader();
		$scope.currentFile = element.files[0];

		reader.onload = function(event) {
			$scope.imageSource = event.target.result;
			$scope.$apply();
		};

		reader.readAsDataURL(element.files[0]);
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
