(function() {
  "use strict";

  var CartController = function ($scope, ProductsService, LoginService) {
    var $ctrl = this;
    $ctrl.cart = null;

    $ctrl.$onInit = function() {
      ProductsService.getTemporary().then(
        (cart)=>{
          $ctrl.cart = cart;
        });
      if (!ProductsService.products)
        ProductsService.loadProducts();
    }

    $ctrl.more = function(product) {
      var pr = ProductsService.products.find(p => p.id === product.id);
      if (pr.quantity > 0) {
        product.quantity++;
        $ctrl.cart.fullLength++;
        pr.quantity--;
      }
      ProductsService.saveTemporary();
    }

    $ctrl.getCurrentUser = function() {
      return LoginService.currentUser;
    };

    $ctrl.less = function(product) {
      var pr = ProductsService.products.find(p => p.id === product.id);
      if (product.quantity > 0) {
        product.quantity--;
        $ctrl.cart.fullLength--;
        pr.quantity++;
      }
      ProductsService.saveTemporary();
    }

    $ctrl.removeProduct = function(id) {
      var pr = ProductsService.products.find(p => p.id === $ctrl.cart.products[id].id);
      $ctrl.cart.fullLength -= $ctrl.cart.products[id].quantity;
      pr.quantity += $ctrl.cart.products[id].quantity;
      $ctrl.cart.products.splice(id, 1);
      ProductsService.cartProducts = $ctrl.cart;
      ProductsService.saveTemporary();
    }

    $ctrl.orderConfirmed = function () {
      ProductsService.buy(); 
      $ctrl.cart.fullLength = 0;
      $ctrl.cart.products = [];
    }

    $ctrl.clearCart = function () {
      ProductsService.clearCart();
      $ctrl.cart.products = [];
      ProductsService.saveTemporary();
    }

    $ctrl.getFullCost = function() {
      return $ctrl.cart.products.map(p => p.cost * p.quantity).reduce((acc, val) => acc + val, 0);
    }
  }

  CartController.$inject = ["$scope", "ProductsService", "LoginService"];

  angular.module("app").component('wsCart', {
    templateUrl: './components/cart/cart.template.html',
    controller: CartController
  });
})();