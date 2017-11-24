(function () {
	"use strict";

	var app = angular.module("app", ["ngRoute"]);

	var configFunction = function ($routeProvider) {
		$routeProvider.when("/",
		{
			template: '<ws-admin products="$resolve.products.data"></ws-admin>',
			resolve: { 
				products: function($http) { 
					return $http.get("../php/requests/products.request.php"); 
				}
			}
		})
	}
	configFunction.$inject = ["$routeProvider"];

	app.config(configFunction);
})();