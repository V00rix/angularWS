(function () {
  "use strict";

  var ProductDetailController = function ($scope, $interval) { 
    var ctrl = this;

    ctrl.$onInit = function() {
      console.log(ctrl.product);
    }
  }

  app.component('wsProductDetail', {
    templateUrl: './components/product-detail/productDetail.template.html',
    controller: ProductDetailController,
    bindings: {
      product: '<',
    }
  })})();