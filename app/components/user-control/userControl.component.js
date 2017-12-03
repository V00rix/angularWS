(function () {
  "use strict";

  var UserControlController = function ($scope, ProductsService) { 
    var ctrl = this;

    ctrl.$onInit = function() {
      console.log(ctrl.products);
    };

    ctrl.lowQuantity = function(quantity) {
      return (quantity <= 10 && quantity >  0) ? true : false;
    }
  }

  UserControlController.$inject = ["$scope", "ProductsService"];

  angular.module("app").component('wsProducts', {
    templateUrl: './components/user-control/userControl.template.html',
    controller: UserControlController,
    bindings: {
      products: '<',
      onProduct: '&'
    }
  })
})();