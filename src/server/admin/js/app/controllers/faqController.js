app.controller('faqController', ['$scope', '$http', '$timeout', 'getFaqFactory', function($scope, $http, $timeout, getFaqFactory) {

	getFaqFactory.getAllFaqs().success(function(data, status) {
		if (data) {
			$scope.faq.latest = data;
		}
	});

	$scope.save = function(_faq) {
		var faq = _faq,
			id = (faq.edit !== undefined ? faq.edit.id : 0);

		$scope.faq.sending = true;

		$http.post(
			'ajax/faq/save.php',
			{
				id: id,
				answer: faq.answer,
				question: faq.question
			}, {
				headers: {
					'Content-Type': 'application/json'
				}
			}
		).then(function success(response) {
			$scope.faq.latest.push({answer: faq.answer, question: faq.question});
			$scope.faq.success = response.data;
			$scope.faq.sending = false;
			$scope.faq.showresponse = true;
			$scope.clear();
			$timeout(function() {
				$scope.faq.showresponse = false;
			}, 1000);

			getFaqFactory.getAllFaqs().success(function(data, status) {
				if (data) {
					$scope.faq.latest = data;
				}
			});
		}, function error(response) {
			$scope.faq.error = response.data;
		});
	};

	$scope.edit = function(id) {
		$scope.faq.edit = {
			id: parseInt(id)
		};

		angular.forEach($scope.faq.latest, function(item, val) {
			if (item.id === id) {
				$scope.faq.answer = item.answer;
				$scope.faq.question = item.question;
			}
		});
	};

	$scope.clear = function() {
		$scope.faq.answer = '';
		$scope.faq.question = '';
		$scope.faq.edit = {};
	};

}]);
