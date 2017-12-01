(function() {
	"use strict";

	var HttpService = function($http) {
		this.baseUrl = "./php/requests/";

		this.get = function() {
			console.log("Sending GET...");
			return $http.get(this.baseUrl + "products.request.php");
		}

		this.post = function(products) {		
			console.log("Sending POST...");
			return $http.put(this.baseUrl + "products.request.php", products);
		}

		this.put = function(productId, review) {		
			console.log("Sending PUT...");
			return $http.put(this.baseUrl + "products.request.php", {productId: productId, review: review});
		}

		this.getCredentialsStatus = function(username, email, password) {
			console.log("Getting credentials status.");
			return $http.post(this.baseUrl +  "login.request.php", {username: username, email: email, password: password});
		}

		this.register = function(username, email, password) {
			console.log("Registering new user.");
			return $http.post(this.baseUrl +  "register.request.php", {username: username, email: email, password: password});			
		}

		this.logout = function() {
			console.log("Logging out.");
			return $http.get(this.baseUrl +  "logout.request.php");			
		}
	}

	HttpService.$inject = ['$http'];

    angular.module("app").service("HttpService", HttpService);
})();