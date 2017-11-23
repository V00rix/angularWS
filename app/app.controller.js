var AppController = function () {
	var ctrl = this;
	ctrl.login = false;
	ctrl.displayLogin = function() {
		ctrl.login = true;
		console.log(ctrl.login);
	}
}

app.controller("AppController", AppController);