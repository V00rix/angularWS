"use strict";

var LoginController = function ($scope, HttpService, LoginService) {
	var ctrl = this;

	ctrl.username = "";
	ctrl.password = "";

	ctrl.login = function(valid) {
		if (valid && ctrl.badUsername === 'found') {
			HttpService.login(ctrl.username, ctrl.password).then(
				(result) => {
					console.log("Logged in.");
					// enter loged in state
					LoginService.currentUser = new User(ctrl.username);
					ctrl.onLogin();
				},
				(response) => {
					if (response.status === 900) {
						console.warn("Login failure: Username '" + ctrl.username + "' was not found.");
					} 
					else if(response.status === 901) {
						console.warn("Login failure: wrong password");
						ctrl.badPassword = true;
					}
					else {						
						console.warn("Unhandled server error!", response);
					}
				});
		}
	}

	ctrl.checkUsername = function(form) {
		return form.username.$error.required && (form.$submitted || form.username.$touched);
	}

	ctrl.register =  function() {

	}

	ctrl.findUsername = function() {
		ctrl.badUsername = 'searching';
		HttpService.findUsername(ctrl.username).then(
			(result) => { ctrl.badUsername = 'found'; }, 
			() => { ctrl.badUsername = true; });
	}
}

app.component('wsLogin', {
	templateUrl: './components/login/login.template.html',
	controller: LoginController,
	bindings: {
		onLogin: "&"
	}
});