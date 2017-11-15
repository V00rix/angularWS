var CartController = function ($scope, ProductsService) {
	$scope.products = [];

	$scope.onInit = function() {
		$scope.products = ProductsService.cartProducts;
	}

	$scope.more = function(product) {
		var pr = ProductsService.products.find(p => p.id === product.id);
		if (pr.quantity > 0) {
			product.quantity++;
			ProductsService.cartProducts.fullLength++;
			pr.quantity--;
		}
	}

	$scope.less = function(product) {
		var pr = ProductsService.products.find(p => p.id === product.id);
		if (product.quantity > 0) {
			product.quantity--;
			ProductsService.cartProducts.fullLength--;
			pr.quantity++;
		}
	}

	$scope.removeProduct = function(id) {
		console.log(id, $scope.products[id]);
		var pr = ProductsService.products.find(p => p.id === $scope.products[id].id);
		ProductsService.cartProducts.fullLength -= $scope.products[id].quantity;
		pr.quantity += $scope.products[id].quantity;
		$scope.products.splice(id, 1);
	}

	$scope.orderConfirmed = function () {
		ProductsService.saveProducts(); 
		ProductsService.cartProducts.fullLength = 0;
		ProductsService.cartProducts = [];
		$scope.products = [];
	}

	$scope.clearCart = function () {
		for (var product in $scope.products) {
			var pr = ProductsService.products.find(p => p.id === product.id);
			pr.quantity += product.quantity;
		}
		ProductsService.cartProducts.fullLength = 0;
		ProductsService.cartProducts = [];
		$scope.products = [];
	}

}
CartController.$inject = ["$scope", "ProductsService"]; 

app.controller("CartController", CartController);