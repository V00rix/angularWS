(function () {
  "use strict";

  var ProductsController = function ($scope, ProductsService) { 
    var ctrl = this;

    ctrl.$onInit = function() {
      console.log(ctrl.products);
    };

    ctrl.lowQuantity = function(quantity) {
      return (quantity <= 10 && quantity >  0) ? true : false;
    }
  }

  angular.module("app").component('wsProducts', {
    templateUrl: './components/products/products.template.html',
    controller: ProductsController,
    bindings: {
      products: '<',
      onProduct: '&'
    }
  })
})();