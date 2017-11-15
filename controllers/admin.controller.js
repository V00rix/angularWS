var AdminController = function ($scope, ProductsService) {
	$scope.models = {
		products: []
	}

	$scope.selectedProduct = null;
	$scope.selectedProductId = null;
	$scope.editing = false;

	$scope.saveProducts = function() {
		ProductsService.saveProducts();
	}

	$scope.productSelected = function(id) {
		$scope.editing = true;
		$scope.selectedProductId = id;
		$scope.selectedProduct = angular.copy($scope.models.products[id]);
		console.log($scope.selectedProduct, $scope.models.products[id]);
	}

	$scope.newProduct = function() {
		$scope.selectedProduct = new Product(
			$scope.models.products.map(m => m.id)
			.reduce((acc, val) => acc > val ? acc : val, 0));
		$scope.editing = true;
	}

	$scope.editConfirmed = function() {
		console.log($scope.selectedProductId, $scope.models.products[$scope.selectedProductId]);
		if ($scope.selectedProductId || $scope.selectedProductId === 0)
			$scope.models.products[$scope.selectedProductId] = angular.copy($scope.selectedProduct);
		else
			$scope.models.products.push(angular.copy($scope.selectedProduct));
		$scope.closeEdit();
		$scope.saveProducts();
	}

	$scope.editCanceled = function() {
		$scope.closeEdit();
	}

	$scope.deleteProduct = function() {
		if ($scope.selectedProductId || $scope.selectedProductId === 0) {
			$scope.models.products.splice($scope.selectedProductId, 1);
			$scope.saveProducts();
		}
		$scope.closeEdit();
	}

	$scope.closeEdit = function() {		
		$scope.selectedProduct = null;
		$scope.selectedProductId = null;
		$scope.editing = false;
	}

	$scope.onInit = function() {
		if (ProductsService.products)
			$scope.models.products = ProductsService.products;
		else 	
			ProductsService.loadProducts().then(() => {
				$scope.models.products = ProductsService.products;
			});
		
		console.log($scope.models.products);
	}
}

AdminController.$inject = ["$scope", "ProductsService"]; 

app.controller("AdminController", AdminController);