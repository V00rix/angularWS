"use strict";

var LoginController = function ($scope, HttpService) {
	var ctrl = this;

	ctrl.username = "";
	ctrl.password = "";

	ctrl.login = function() {
		HttpService.login(ctrl.username, ctrl.password).then(
			(res) => {
				console.log(res);
			});
	}

	ctrl.register =  function() {

	}
}

app.component('wsLogin', {
	templateUrl: './components/login/login.template.html',
	controller: LoginController,
	bindings: {
		onLogin: "&"
	}
});