(function () {
  "use strict";

  var ProductDetailController = function ($scope, $routeParams, ProductsService) { 
    var ctrl = this;

    ctrl.$onInit = function() {
      var productName = $routeParams.productName;
      if (productName) {
        ctrl.product = ProductsService.products.find(p => p.name === productName);
        if (ctrl.product.reviews)
          ctrl.product.rate = ctrl.round(
            ctrl.product.reviews.map(r => r.rating)
            .reduce((acc, val) => acc + val, 0) / ctrl.product.reviews.length, 2);
      }
    };

    ctrl.addReview = function(review) {
      ctrl.product.reviews.push(review);
      console.log(ctrl.product);
      ProductsService.saveProducts();
    }

    ctrl.addToCart = function() {
      if (ctrl.product.quantity > 0) {
        ctrl.product.quantity--;
        var prod = ProductsService.cartProducts.products.find(p => p.id === ctrl.product.id);
        if (prod) {
          prod.quantity++;
        }
        else {
          prod = angular.copy(ctrl.product);
          prod.quantity = 1;
          ProductsService.cartProducts.products.push(prod);
        }
        ProductsService.cartProducts.fullLength = 
        ProductsService.cartProducts.products.map(p => p.quantity)
        .reduce((acc, val) => acc + val ,0); 
      }
    };

    ctrl.lowQuantity = function(quantity) {
      return (quantity <= 10 && quantity >  0) ? true : false;
    }

    // helpers
    ctrl.round = function(number, precision) {
      var factor = Math.pow(10, precision);
      var roundedTempNumber = Math.round(number * factor);
      return roundedTempNumber / factor;
    };
  };

  app.component('wsProductDetail', {
    templateUrl: './components/product-detail/productDetail.template.html',
    controller: ProductDetailController,
  });
})();