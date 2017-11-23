"use strict";

var AdminController = function ($scope, ProductsService, $http) {
	var ctrl = this;

	ctrl.products = [];

	ctrl.selectedProduct = null;
	ctrl.selectedProductId = null;
	ctrl.editing = false;

	ctrl.$onInit = function() {
		//
    }

    ctrl.saveProducts = function() {
    	ProductsService.saveProducts();
    }

    ctrl.productSelected = function(id) {
    	ctrl.editing = true;
    	ctrl.selectedProductId = id;
    	ctrl.selectedProduct = angular.copy(ctrl.products[id]);
    }

    ctrl.newProduct = function() {
    	ctrl.selectedProduct = new Product(
    		ctrl.products.map(m => m.id)
    		.reduce((acc, val) => acc > val ? acc : val, 0));
    	ctrl.editing = true;
    }

    ctrl.editConfirmed = function() {
    	console.log(ctrl.selectedProductId, ctrl.products[ctrl.selectedProductId]);
    	if (ctrl.selectedProductId || ctrl.selectedProductId === 0)
    		ctrl.products[ctrl.selectedProductId] = angular.copy(ctrl.selectedProduct);
    	else
    		ctrl.products.push(angular.copy(ctrl.selectedProduct));
    	ctrl.closeEdit();
    	ctrl.saveProducts();
    }

    ctrl.editCanceled = function() {
    	ctrl.closeEdit();
    }

    ctrl.deleteProduct = function() {
    	if (ctrl.selectedProductId || ctrl.selectedProductId === 0) {
    		ctrl.products.splice(ctrl.selectedProductId, 1);
    		ctrl.saveProducts();
    	}
    	ctrl.closeEdit();
    }

    ctrl.closeEdit = function() {		
    	ctrl.selectedProduct = null;
    	ctrl.selectedProductId = null;
    	ctrl.editing = false;
    }

    ctrl.onInit = function() {
    	if (ProductsService.products)
    		ctrl.products = ProductsService.products;
    	else 	
    		ProductsService.loadProducts().then(() => {
    			ctrl.products = ProductsService.products;
    		});

    	console.log(ctrl.products);
    }
}

app.component('wsAdmin', {
	templateUrl: './components/admin/admin.template.html',
	controller: AdminController,
	bindings: {
		products: '<'
	}
});