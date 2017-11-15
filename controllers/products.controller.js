var ProductsController = function ($scope, ProductsService) {
	$scope.models = {
		products: []
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

	$scope.lowQuantity = function(quantity) {
		return (quantity <= 10 && quantity >  0) ? true : false;
	}

	$scope.addToCart = function(product) {
		console.log(product);
		product.quantity--;
		var prod = ProductsService.cartProducts.find(p => p.id === product.id);
		console.log(prod);
		if (prod) {
			prod.quantity++;
		}
		else {
			prod = angular.copy(product);
			prod.quantity = 1;
			ProductsService.cartProducts.push(prod);
		}
		ProductsService.cartProducts.fullLength = 
			ProductsService.cartProducts.map(p => p.quantity)
			.reduce((acc, val) => acc + val ,0);
		console.log(ProductsService.cartProducts);
	}
}

ProductsController.$inject = ["$scope", "ProductsService"]; 

app.controller("ProductsController", ProductsController);