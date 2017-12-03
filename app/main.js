(function () {
    "use strict";

    var app = angular.module("app", ["ngRoute"]);

    var configFunction = function ($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true)
        $routeProvider
        .when("/", {redirectTo: '/products'})
        .when("/products",
        {
            template: '<ws-products products="$resolve.products" on-product="main.showDetail(productName)"></ws-products>',
            resolve: { 
                products: function(ProductsService) { 
                    return ProductsService.loadProducts(); 
                }
            },
            useAsDefault: true
        })
        .when("/cart",
        {
            template: '<ws-cart></ws-cart>'
        })
        .when("/registration",
        {
            template: '<ws-registration></ws-registration>'
        })
        .when("/product-detail/:productName?", {
            template: '<ws-product-detail></ws-product-detail>',
            resolve: { 
                products: function(ProductsService) { 
                    return ProductsService.loadProducts(); 
                }
            }
        })
        .otherwise({
            template: '<ws-not-found></ws-not-found>',
        });
    }
    configFunction.$inject = ["$routeProvider" ,"$locationProvider"];

    app.config(configFunction);

    (function () {
        "use strict";

        app.controller('AppController', AppController);

        function AppController($scope, $location) {
            var ctrl = this;

            ctrl.showDetail = function(productName) {
                $location.path('/product-detail/' + productName);
            }
        }

    })();
})();