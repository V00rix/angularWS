(function() {
	"use strict";

	var LoginService = function() {
		/* 
		
		backend reuqest
		1. it should check by ip and credentials
		2. it should check time of login session expiry
		
		*/
		this.getCurrentUser = function() {
			// return new User("sda");
			return null;
		}

		this.currentUser = this.getCurrentUser(); 
	};

	LoginService.$inject = [];

	angular.module("app").service("LoginService", LoginService);
})();