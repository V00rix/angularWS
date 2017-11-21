(function () {
	"use strict";

	app.controller('AppController', AppController);

	function AppController($scope, $location) {
		var ctrl = this;
		ctrl.selectedProduct = null;

		ctrl.showDetail = function(product) {
			ctrl.selectedProduct = product;
			$location.path('/product-detail');
		}
	}

})();