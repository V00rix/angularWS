var MainController = function ($scope, ProductsService) {
	$scope.cartProducts = ProductsService.cartProducts;
}

MainController.$inject = ['$scope', 'ProductsService'];
app.controller("MainController", MainController);