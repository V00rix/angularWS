(function() {
    "use strict";

    var AdminController = function ($scope, $http) {
        var $ctrl = this;

        $ctrl.products = [];

        $ctrl.selectedProduct = null;
        $ctrl.selectedProductId = null;
        $ctrl.editing = false;

        $ctrl.$onInit = function() {
            $http.get("../php/requests/products.request.php").then(
                (res) => {
                    $ctrl.products = res.data;
                },
                (res) => {
                    console.error(res);
                });
        }

        $ctrl.saveProducts = function() {
            $http.post("../php/requests/products.request.php", $ctrl.products).then(
                (res) => {
                    console.log(res);
                },
                (res) => {
                    console.error(res);
                });
        }

        $ctrl.productSelected = function(id) {
        	$ctrl.editing = true;
        	$ctrl.selectedProductId = id;
        	$ctrl.selectedProduct = angular.copy($ctrl.products[id]);
        }

        $ctrl.newProduct = function() {
        	$ctrl.selectedProduct = new Product(
        		$ctrl.products.map(m => m.id)
        		.reduce((acc, val) => acc > val ? acc : val, 0));
        	$ctrl.editing = true;
        }

        $ctrl.editConfirmed = function() {
        	if ($ctrl.selectedProductId || $ctrl.selectedProductId === 0)
        		$ctrl.products[$ctrl.selectedProductId] = angular.copy($ctrl.selectedProduct);
        	else
        		$ctrl.products.push(angular.copy($ctrl.selectedProduct));
        	$ctrl.closeEdit();
        	$ctrl.saveProducts();
        }

        $ctrl.editCanceled = function() {
        	$ctrl.closeEdit();
        }

        $ctrl.deleteProduct = function() {
        	if ($ctrl.selectedProductId || $ctrl.selectedProductId === 0) {
        		$ctrl.products.splice($ctrl.selectedProductId, 1);
        		$ctrl.saveProducts();
        	}
        	$ctrl.closeEdit();
        }

        $ctrl.closeEdit = function() {		
        	$ctrl.selectedProduct = null;
        	$ctrl.selectedProductId = null;
        	$ctrl.editing = false;
        }
    }

    angular.module("app").component('wsAdmin', {
     templateUrl: './app/admin/admin.template.html',
     controller: AdminController,
 });
})();