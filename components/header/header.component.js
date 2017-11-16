"use strict";

var HeaderController = function ($scope, ProductsService) {
	var ctrl = this;
	ctrl.$onInit = function() {
		ctrl.cartProducts = ProductsService.cartProducts;
	}
}

app.component('wsHeader', {
  templateUrl: './components/header/header.template.html',
  controller: HeaderController
});