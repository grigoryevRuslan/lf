app.factory('getFaqFactory', ['$http', function($http) {
	return {
		getAllFaqs: function() {
			return $http.post(
				'/admin/ajax/faq/get.php',
				{
					type: 'all'
				}
			);
		}
	};
}]);
