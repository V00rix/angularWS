(function () {
	"use strict";

	var confirmationController = function($scope) {
		var $ctrl = this;

		$ctrl.ok = function() {	
			$scope.ok('test');
		}

		$ctrl.$onInit = function() {
		}
	}

	confirmationController.$inject = ["$scope"];

	angular.module("app").controller("confirmationController", confirmationController);
})();