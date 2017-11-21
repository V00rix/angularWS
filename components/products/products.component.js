(function () {
  "use strict";

  var ProductsController = function ($scope, ProductsService) { 
    var ctrl = this;

    ctrl.$onInit = function() {
      // fake reviews
      var users = [
      new User(777, "V00rix"),
      new User(1, "elumi\`xor")
      ];
      ctrl.products[0].reviews = [
      new Review(users[0], 5, "Amazing", "This explanation makes no sense."),
      new Review(users[1], 2, "Disappointing", "Some very very long explanation with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " very long inner content with"
        + " which probably makes no sense as well.")
      ];
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
      products: '<',
      onProduct: '&'
    }
  })})();