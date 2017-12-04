(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService) {
		var $ctrl = this;

		$ctrl.displayLogin = false;
		$ctrl.userDataDisplayed = false;
		$ctrl.cartProducts = null;
		$ctrl.timeout = null;

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
			LoginService.deleteAccount().then($ctrl.userDataDisplayed = false);
		}

		$ctrl.getCurrentUser = function () {
			return LoginService.currentUser;
		}
		
		$ctrl.logout = function() {
			LoginService.logout().then($ctrl.userDataDisplayed = false);
		}

		$ctrl.displayUserData = function() {
			$ctrl.userDataDisplayed = true;
			if ($ctrl.timeout)
				clearTimeout($ctrl.timeout);
		}

		$ctrl.hideUserData = function() {
			$ctrl.timeout = setTimeout(()=>{
				$ctrl.userDataDisplayed = false;
				$scope.$apply();
			}, 600);	
		}
	}

	HeaderController.$inject = ["$scope", "ProductsService", "LoginService"];

	angular.module("app").component('wsHeader', {
		templateUrl: './components/header/header.template.html',
		controller: HeaderController,
	});
})();