app.controller('shareController', ['$scope', function($scope) {

	$scope.shareVk = function(purl, ptitle, pimg, text) {
		url  = 'http://vkontakte.ru/share.php?';
		url += 'url='          + encodeURIComponent(purl);
		url += '&title='       + encodeURIComponent(ptitle);
		url += '&description=' + encodeURIComponent(text);
		url += '&image='       + encodeURIComponent(pimg);
		url += '&noparse=true';
		openPopup(url);
	};

	$scope.shareTwitter = function(purl, ptitle) {
		url  = 'http://twitter.com/share?';
		url += 'text='      + encodeURIComponent(ptitle);
		url += '&url='      + encodeURIComponent(purl);
		url += '&counturl=' + encodeURIComponent(purl);
		openPopup(url);
	};

	$scope.shareGplus = function(purl) {
		url = 'https://plus.google.com/share?url=';
		url += encodeURIComponent(purl);
		openPopup(url);
	};

	function openPopup(url) {
		window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
	}

}]);
