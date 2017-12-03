(function() {
    "use strict";

    var ProductsController = function ($scope, $http) {
        var $ctrl = this;

        $ctrl.products = [];

        $ctrl.selectedProduct = null;
        $ctrl.selectedProductId = null;
        $ctrl.editing = false;
        $ctrl.requestUrl = "../php/requests/products.request.php";

        $ctrl.$onInit = function() {
            $http.get($ctrl.requestUrl).then(
                (res) => {
                    console.log(res);
                    $ctrl.products = res.data;
                },
                (res) => {
                    console.error(res);
                });
        }

        $ctrl.saveProducts = function() {
            $http.post($ctrl.requestUrl, $ctrl.products).then(
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

    ProductsController.$inject = ["$scope", "$http"];

    angular.module("app").component('wsProducts', {
     templateUrl: './app/components/products/products.template.html',
     controller: ProductsController,
 });
})();