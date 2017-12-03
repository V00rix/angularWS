(function () {
  "use strict";

  var ProductsController = function ($scope, ProductsService) { 
    var ctrl = this;

    ctrl.$onInit = function() {};

    ctrl.lowQuantity = function(quantity) {
      return (quantity <= 10 && quantity >  0) ? true : false;
    }
  }

  ProductsController.$inject = ["$scope", "ProductsService"];

  angular.module("app").component('wsProducts', {
    templateUrl: './components/products/products.template.html',
    controller: ProductsController,
    bindings: {
      products: '<',
      onProduct: '&'
    }
  })
})();