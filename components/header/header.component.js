(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService) {
		var ctrl = this;

		ctrl.displayLogin = false;

		ctrl.$onInit = function() {
			ctrl.cartProducts = ProductsService.cartProducts;
		}

		ctrl.getCurrentUser = function () {
			return LoginService.currentUser;
		}
	}

	angular.module("app").component('wsHeader', {
		templateUrl: './components/header/header.template.html',
		controller: HeaderController,
	});
})();