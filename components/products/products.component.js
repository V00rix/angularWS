"use strict";

var ProductsController = function ($scope, ProductsService) { 
  var ctrl = this;
  
  ctrl.$onInit = function() {
    // console.log(ctrl.products);
  };

  ctrl.lowQuantity = function(quantity) {
    return (quantity <= 10 && quantity >  0) ? true : false;
  }

  ctrl.addToCart = function(product) {
    console.log(ProductsService.cartProducts, product);
    product.quantity--;
    var prod = ProductsService.cartProducts.find(p => p.id === product.id);
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
  }
}

app.component('wsProducts', {
  templateUrl: './components/products/products.template.html',
  controller: ProductsController,
  bindings: {
    products: '<'
  }
});