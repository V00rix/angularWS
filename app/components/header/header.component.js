(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService) {
		var $ctrl = this;

		$ctrl.displayLogin = false;
		$ctrl.displayUserData = false;
		$ctrl.cartProducts = null;

		$ctrl.$onInit = function() {
			LoginService.subscribe($scope, () => {
				$ctrl.displayLogin = false;
			});
			LoginService.loggedIn();
			ProductsService.getTemporary().then(
				(prods)=>{
					$ctrl.cartProducts = prods;
				});
		}

		$ctrl.getFullLength = function() {
			return ProductsService.cartProducts.fullLength;
		}

		$ctrl.deleteAccount = function() {
			LoginService.deleteAccount();
		}

		$ctrl.getCurrentUser = function () {
			return LoginService.currentUser;
		}
		
		$ctrl.logout = function() {
			LoginService.logout();
			ProductsService.clearCart();
		}
	}

	HeaderController.$inject = ["$scope", "ProductsService", "LoginService"];

	angular.module("app").component('wsHeader', {
		templateUrl: './components/header/header.template.html',
		controller: HeaderController,
	});
})();