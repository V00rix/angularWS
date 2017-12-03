(function() {
	"use strict";

	var HttpService = function($http) {
		this.baseUrl = "../php/requests/";

		this.getProducts = function() {
			console.log("Sending GET...");
			return $http.get(this.baseUrl + "products.request.php");
		}

		this.buy = function(request) {		
			console.log("Sending POST...");
			return $http.post(this.baseUrl + "buy.request.php", request);
		}

		this.addReview = function(productId, review) {		
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

		this.loggedIn = function() {
			console.log("Checking if the user is logged in.");
			return $http.get(this.baseUrl + "login.request.php");
		}

		this.deleteAccount = function(username) {
			console.log("Sending delete request.");
			return $http.put(this.baseUrl + "register.request.php", {username: username});
		}

		this.postTemp  = function(cartProducts) {
			console.log("Saving temporary cart.");
			return $http.post(this.baseUrl + "temporary.request.php", {cartProducts: cartProducts});			
		}

		this.getTemp = function() {			
			console.log("Getting temporary cart.");
			return $http.get(this.baseUrl + "temporary.request.php");
		}

		this.logout = function() {
			console.log("Logging out.");
			return $http.get(this.baseUrl +  "logout.request.php");			
		}
	}

	HttpService.$inject = ['$http'];

	angular.module("app").service("HttpService", HttpService);
})();