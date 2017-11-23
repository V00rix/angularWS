(function() {
	"use strict";

	var HeaderController = function ($scope, ProductsService, LoginService) {
		var ctrl = this;

		ctrl.$onInit = onInit;
		ctrl.login = login;
		ctrl.switchLogin = switchLogin;
		ctrl.getCurrentUser = getCurrentUser;

		function onInit () {
			ctrl.cartProducts = ProductsService.cartProducts;
			ctrl.res = 0;
		}

		function switchLogin () {
			ctrl.res = ++ctrl.res % 3;
		}

		function login () {
			// send request to web api
			// console.log(ctrl.username);
			// console.log(ctrl.password);
			
			/* login request response failure */
			if (/* username not found */ ctrl.username != "admin") {
				console.warn("Login failure: Username '" + ctrl.username + "' was not found.");
				// encourage to register
				ctrl.badUsername = true;
				ctrl.badPassword = false;
			} 
			else if(/* wrond password */ ctrl.password != "password") {
				console.warn("Login failure: wrong password");
				ctrl.badUsername = false;
				ctrl.badPassword = true;
			}
			else /* login request response success */ {
				console.log("Logged in.");
				ctrl.badUsername = false;
				ctrl.badPassword = false;
				// enter loged in state
				LoginService.currentUser = new User(ctrl.username);
				ctrl.logedIn = true;
			};
		};

		function getCurrentUser () {
			return LoginService.currentUser;
		}
	}

	app.component('wsHeader', {
		templateUrl: './components/header/header.template.html',
  controller: HeaderController,
  bindings: {
  	onLogin: "&"
  }
	});
})();