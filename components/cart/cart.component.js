"use strict";

var CartController = function ($scope, ProductsService) {
  var ctrl = this;
  var cart = ProductsService.cartProducts;

  ctrl.products = [];

  ctrl.$onInit = function() {
    ctrl.products = cart.products;
  }

  ctrl.more = function(product) {
    var pr = ProductsService.products.find(p => p.id === product.id);
    if (pr.quantity > 0) {
      product.quantity++;
      cart.fullLength++;
      pr.quantity--;
    }
  }

  ctrl.less = function(product) {
    var pr = ProductsService.products.find(p => p.id === product.id);
    if (product.quantity > 0) {
      product.quantity--;
      cart.fullLength--;
      pr.quantity++;
    }
  }

  ctrl.removeProduct = function(id) {
    var pr = ProductsService.products.find(p => p.id === ctrl.products[id].id);
    cart.fullLength -= ctrl.products[id].quantity;
    pr.quantity += ctrl.products[id].quantity;
    ctrl.products.splice(id, 1);
  }

  ctrl.orderConfirmed = function () {
    // this works badly
    ProductsService.saveProducts(); 
    cart.fullLength = 0;
    cart.products = [];
    ctrl.products = [];
  }

  ctrl.clearCart = function () {
    for (var product in ctrl.products) {
      
      var pr = ProductsService.products.find(p => p.id === product.id);
      pr.quantity += product.quantity;
    }
    ProductsService.cartProducts.fullLength = 0;
    ProductsService.cartProducts = [];
    ctrl.products = [];
  }

  ctrl.getFullCost = function() {
    return ctrl.products.map(p => p.cost * p.quantity).reduce((acc, val) => acc + val, 0);
  }
}

app.component('wsCart', {
  templateUrl: './components/cart/cart.template.html',
  controller: CartController
});