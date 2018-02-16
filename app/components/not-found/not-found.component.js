(function() {
	"use strict";

	var NotFoundController = function ($scope) {
		var $ctrl = this;

    };

    NotFoundController.$inject = ["$scope"];

    angular.module("app").component('wsNotFound', {
    	templateUrl: './components/not-found/not-found.template.html',
    	controller: NotFoundController,
    });
})();