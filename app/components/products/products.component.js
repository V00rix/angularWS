(function () {
    "use strict";

    var ProductsController = function () {
        var $ctrl = this;

        $ctrl.$onInit = function () {
        };

        $ctrl.lowQuantity = function (quantity) {
            return (quantity <= 10 && quantity > 0);
        }
    };

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