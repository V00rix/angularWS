(function() {
	"use strict";

	var HttpService = function($http) {
		this.baseUrl = "../php/requests/user/";

		/* Product requests */
		this.getProducts = function() {
			console.log("Getting products...");
			return $http.get(this.baseUrl + "products/getProductList.request.php");
		};

		this.buy = function(request) {		
			console.log("Sending buy request...");
			return $http.post(this.baseUrl + "products/buyProducts.request.php", request);
		};

		this.addReview = function(productId, review) {		
			console.log("Adding review...");
			return $http.put(this.baseUrl + "products/reviews/addReview.request.php", {productId: productId, review: review});
		};

		this.deleteReview = function(productId, reviewId, review) {		
			console.log("Deleting review...");
			return $http.put(this.baseUrl + "products/reviews/deleteReview.request.php", {productId: productId, reviewId: reviewId, review: review});
		};

		this.updateReview = function(productId, reviewId, review) {		
			console.log("Updating review...");
			return $http.put(this.baseUrl + "products/reviews/updateReview.request.php", {productId: productId, reviewId: reviewId, review: review});
		};

		/* Temporary Cart */
		this.postTemp  = function(cartProducts) {
			console.log("Saving temporary cart.");
			return $http.post(this.baseUrl + "products/temporaryCart/updateTemporaryCart.request.php", {cartProducts: cartProducts});			
		};

		this.getTemp = function() {			
			console.log("Getting temporary cart.");
			return $http.get(this.baseUrl + "products/temporaryCart/getTemporaryCart.request.php");
		};

		/* Check user credentials */
		this.getCredentialsStatus = function(username, email, password) {
			console.log("Getting credentials status.");
			return $http.post(this.baseUrl +  "account/checkUserCredentials.request.php", {username: username, email: email, password: password});
		};

		/* Login requests */
		this.login = function(username, email, password) {
			console.log("Logging in");
			return $http.post(this.baseUrl +  "account/login/loginUser.request.php", {username: username, email: email, password: password});
		};

		this.loggedIn = function() {
			console.log("Checking if the user is logged in.");
			return $http.get(this.baseUrl + "account/login/isUserLoggedIn.request.php");
		};

		/* Registration requests */
		this.register = function(username, email, password) {
			console.log("Registering new user.");
			return $http.post(this.baseUrl +  "account/register/registerNewUser.request.php", {username: username, email: email, password: password});			
		};

		this.deleteAccount = function(username) {
			console.log("Sending delete request.");
			return $http.put(this.baseUrl + "account/delete/deleteUserAccount.request.php", {username: username});
		};

		/* Logout Request */
		this.logout = function() {
			console.log("Logging out.");
			return $http.get(this.baseUrl +  "logout/logoutUser.request.php");			
		}
	};

	HttpService.$inject = ['$http'];

	angular.module("app").service("HttpService", HttpService);
})();