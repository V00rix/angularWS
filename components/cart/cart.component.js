"use strict";

var CartController = function ($scope, ProductsService) {
  var ctrl = this;

  ctrl.products = [];

  ctrl.$onInit = function() {
    ctrl.products = ProductsService.cartProducts;
  }

  ctrl.more = function(product) {
    var pr = ProductsService.products.find(p => p.id === product.id);
    if (pr.quantity > 0) {
      product.quantity++;
      ProductsService.cartProducts.fullLength++;
      pr.quantity--;
    }
  }

  ctrl.less = function(product) {
    var pr = ProductsService.products.find(p => p.id === product.id);
    if (product.quantity > 0) {
      product.quantity--;
      ProductsService.cartProducts.fullLength--;
      pr.quantity++;
    }
  }

  ctrl.removeProduct = function(id) {
    console.log(id, ctrl.products[id]);
    var pr = ProductsService.products.find(p => p.id === ctrl.products[id].id);
    ProductsService.cartProducts.fullLength -= ctrl.products[id].quantity;
    pr.quantity += ctrl.products[id].quantity;
    ctrl.products.splice(id, 1);
  }

  ctrl.orderConfirmed = function () {
    // this works badly
    ProductsService.saveProducts(); 
    ProductsService.cartProducts.fullLength = 0;
    ProductsService.cartProducts = [];
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
}

app.component('wsCart', {
  templateUrl: './components/cart/cart.template.html',
  controller: CartController
});