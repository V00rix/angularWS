(function() {
	"use strict";

	var LoginController = function ($scope, HttpService, LoginService) {
		var $ctrl = this;

		$ctrl.username = "";
		$ctrl.password = "";

    	// error statuses
    	$ctrl.usernameFound = null;
    	$ctrl.emailNotFree = null;
    	$ctrl.badPassword = null;

    	$ctrl.login = function(valid) {
    		if (valid && $ctrl.usernameFound) {
    			let requestConfig = {
    				username: $ctrl.username, 
    				password: $ctrl.password, 
    				successCallback: () => { 
    					LoginService.userChanged(new User($ctrl.username));
    				},
    				failureCallback: (status) => {
                        $ctrl.badPassword = status;
    				}
    			};  
    			LoginService.login(requestConfig);
    		}
    	}

    	$ctrl.checkUsername = function(valid) {
    		if (valid) {  
    			$ctrl.usernameFound = null;
        		// some timeout to prevent fast dis-|reappearing
        		let requestConfig = {
        			username: $ctrl.username, 
        			usernameCallback: function(status) {
        				if (status) {
        					$ctrl.usernameFound = true;
        				}
        				else 
        					$ctrl.usernameFound = false;
        			}
        		};  
        		LoginService.checkCredentials(requestConfig);
        	}
        }

        $ctrl.register =  function() {
        	LoginService.onRegistrationStart();
        }
    }

    LoginController.$inject = ["$scope", "HttpService", "LoginService"];

    angular.module("app").component('wsLogin', {
    	templateUrl: './components/login/login.template.html',
    	controller: LoginController,
        bindings: {
            windowClosed: '&'
      }
  });
})();