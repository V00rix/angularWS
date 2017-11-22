(function () {
	"use strict";

	app.controller('AppController', AppController);

	function AppController($scope, $location) {
		var ctrl = this;

		ctrl.showDetail = function(productName) {
			$location.path('/product-detail/' + productName);
		}
	}

})();