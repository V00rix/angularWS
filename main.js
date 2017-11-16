"use strict";

var app = angular.module("app", ["ngRoute"]);

app.service("ProductsService", ProductsService);
app.service("HttpService", HttpService);

var configFunction = function ($routeProvider) {
    $routeProvider
    .when("/products",
        {
            template: '<ws-products products="$resolve.products"></ws-products>',
            resolve: { 
                products: function(ProductsService) { 
                    return ProductsService.loadProducts(); 
                }
            },
            useAsDefault: true
        })
    .when("/cart",
        {
            template: '<ws-cart products="$resolve.products"></ws-cart>'
        })
    .when("/admin",
        {
            template: '<ws-admin products="$resolve.products"></ws-admin>',
            resolve: { 
                products: function(ProductsService) { 
                    return ProductsService.loadProducts(); 
                }
            }
        })
}
configFunction.$inject = ["$routeProvider"];

app.config(configFunction);