(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService) {
		var $ctrl = this;

		$ctrl.displayLogin = false;
		$ctrl.displayUserData = false;

		$ctrl.$onInit = function() {
			$ctrl.cartProducts = ProductsService.cartProducts;
			LoginService.subscribe($scope, () => {
				$ctrl.displayLogin = false;
			});
		}

		$ctrl.getCurrentUser = function () {
			return LoginService.currentUser;
		}
		
		$ctrl.logout = function() {
			LoginService.logout();
		}
	}

	HeaderController.$inject = ["$scope", "ProductsService", "LoginService"];

	angular.module("app").component('wsHeader', {
		templateUrl: './components/header/header.template.html',
		controller: HeaderController,
	});
})();