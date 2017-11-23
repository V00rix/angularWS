"use strict";

var HttpService = function($http) {
	this.baseUrl = "./php/requests/";

	this.get = function() {
		console.log("Sending GET...");
        return $http.get(this.baseUrl + "products.request.php");
	}

	this.post = function(products) {		
		console.log("Sending PUT...");
        return $http.put(this.baseUrl + "products.request.php", products);
	}

	this.login = function(username, password) {
		console.log("Loging in " + username  + ", " + password + "...");
		return $http.post(this.baseUrl +  "login.request.php", {username: username, password: password});
	} 

	this.findUsername = function(username) {
		return $http.put(this.baseUrl +  "login.request.php", {username: username});
	} 
}

// HttpService.$inject = ['$http'];